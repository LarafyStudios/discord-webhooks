<?php

namespace LarafyStudios\DiscordWebhooks;

/**
 * @property array $data
 */
class DiscordEmbed
{
    /**
     * The embed data.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Set the title of the embed.
     *
     * @param  string  $title  The embed title.
     * @param  string|null  $url  Optional URL for the title.
     *
     * @return static
     */
    public function setTitle(string $title, ?string $url = null): static
    {
        $this->data['title'] = $title;

        if ($url) {
            $this->data['url'] = $url;
        }

        return $this;
    }

    /**
     * Set the description of the embed.
     *
     * @param  string  $description  The embed description.
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->data['description'] = $description;

        return $this;
    }

    /**
     * Set the color of the embed.
     *
     * @param  int  $color  The embed color as an integer (e.g., 0x3498db for blue).
     *
     * @return static
     */
    public function setColor(int $color): static
    {
        $this->data['color'] = $color;

        return $this;
    }

    /**
     * Set the timestamp of the embed.
     *
     * @param  \DateTimeInterface|null  $timestamp  The timestamp. Defaults to now.
     *
     * @return static
     */
    public function setTimestamp(?\DateTimeInterface $timestamp = null): static
    {
        $this->data['timestamp'] = ($timestamp ?? now())->toIso8601String();

        return $this;
    }

    /**
     * Set the footer of the embed.
     *
     * @param  string  $text  The footer text.
     * @param  string|null  $iconUrl  Optional footer icon URL.
     *
     * @return static
     */
    public function setFooter(string $text, ?string $iconUrl = null): static
    {
        $this->data['footer'] = array_filter([
            'text' => $text,
            'icon_url' => $iconUrl,
        ]);

        return $this;
    }

    /**
     * Set the image of the embed.
     *
     * @param  string  $url  The image URL.
     *
     * @return static
     */
    public function setImage(string $url): static
    {
        $this->data['image'] = ['url' => $url];

        return $this;
    }

    /**
     * Set the thumbnail of the embed.
     *
     * @param  string  $url  The thumbnail URL.
     *
     * @return static
     */
    public function setThumbnail(string $url): static
    {
        $this->data['thumbnail'] = ['url' => $url];

        return $this;
    }

    /**
     * Set the author of the embed.
     *
     * @param  string  $name  The author name.
     * @param  string|null  $url  Optional author URL.
     * @param  string|null  $iconUrl  Optional author icon URL.
     *
     * @return static
     */
    public function setAuthor(string $name, ?string $url = null, ?string $iconUrl = null): static
    {
        $this->data['author'] = array_filter([
            'name' => $name,
            'url' => $url,
            'icon_url' => $iconUrl,
        ]);

        return $this;
    }

    /**
     * Add a field to the embed.
     *
     * @param  string  $name  The field name.
     * @param  string  $value  The field value.
     * @param  bool  $inline  Whether the field should be inline.
     *
     * @return static
     */
    public function addField(string $name, string $value, bool $inline = false): static
    {
        if (!isset($this->data['fields'])) {
            $this->data['fields'] = [];
        }

        $this->data['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline,
        ];

        return $this;
    }

    /**
     * Convert the embed to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
