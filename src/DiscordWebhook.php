<?php

namespace LarafyStudios\DiscordWebhooks;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

/**
 * @property string $url
 * @property string $username
 * @property string $avatarUrl
 * @property string|null $content
 * @property array $embeds
 */
class DiscordWebhook
{
    /**
     * The Discord webhook URL.
     *
     * @var string
     */
    protected string $url;

    /**
     * The Discord webhook username.
     *
     * @var string
     */
    protected string $username;

    /**
     * The Discord webhook avatar URL.
     *
     * @var string
     */
    protected string $avatarUrl;

    /**
     * The message content (text).
     *
     * @var string|null
     */
    protected ?string $content = null;

    /**
     * The embeds array.
     *
     * @var array
     */
    protected array $embeds = [];

    /**
     * Create a new Discord webhook instance.
     *
     * @param  string|null  $url  The webhook URL. If not provided, will use the default from config.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(?string $url = null)
    {
        $this->url = $url ?? config('discord-webhooks.default_webhook_url') ?? '';

        if (empty($this->url)) {
            throw new InvalidArgumentException('Discord webhook URL is required. Set DISCORD_WEBHOOK_URL in your .env or pass it to the constructor.');
        }

        $this->username = config('discord-webhooks.default_username') ?? '';
        $this->avatarUrl = config('discord-webhooks.default_avatar_url') ?? '';
    }

    /**
     * Set the Discord webhook username.
     *
     * @param  string  $username  The webhook username.
     *
     * @return self
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Set the Discord webhook avatar URL.
     *
     * @param  string  $avatarUrl  The webhook avatar URL.
     *
     * @return self
     */
    public function setAvatarUrl(string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    /**
     * Set the message content (text).
     *
     * @param  string  $content  The message content.
     *
     * @return static
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Add an embed to the message.
     *
     * @param  callable|DiscordEmbed  $embed  A callback that receives a DiscordEmbed instance, or a DiscordEmbed instance directly.
     *
     * @return static
     */
    public function addEmbed(callable|DiscordEmbed $embed): static
    {
        if ($embed instanceof DiscordEmbed) {
            $this->embeds[] = $embed->toArray();
        } else {
            $embedInstance = new DiscordEmbed();
            $embed($embedInstance);
            $this->embeds[] = $embedInstance->toArray();
        }

        return $this;
    }

    /**
     * Send the webhook message with both text and embeds.
     *
     * @return bool
     */
    public function send(): bool
    {
        $payload = array_filter([
            'content' => $this->content,
            'username' => !empty($this->username) ? $this->username : null,
            'avatar_url' => !empty($this->avatarUrl) ? $this->avatarUrl : null,
            'embeds' => !empty($this->embeds) ? $this->embeds : null,
        ], fn ($value) => $value !== null);

        if (empty($payload)) {
            Log::warning('Discord webhook payload is empty. At least content or embeds must be set.');

            return false;
        }

        try {
            $response = Http::post($this->url, $payload);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to send Discord webhook: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Create a new Discord webhook instance.
     *
     * @param  string|null  $url  The webhook URL. If not provided, will use the default from config.
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function make(?string $url = null): static
    {
        return new static($url);
    }
}
