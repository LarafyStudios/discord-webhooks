<?php

namespace LarafyStudios\DiscordWebhooks\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook make(?string $url = null)
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook url(string $url)
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook username(string $username)
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook avatarUrl(string $avatarUrl)
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook content(string $content)
 * @method static \LarafyStudios\DiscordWebhooks\DiscordWebhook embed(callable $callback)
 * @method static bool send()
 *
 * @see \LarafyStudios\DiscordWebhooks\DiscordWebhook
 */
class DiscordWebhook extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'discord-webhook';
    }
}
