# Discord Webhooks for Laravel

A simple, elegant, and feature-rich Laravel package for sending Discord webhook messages with support for text content, embeds, and rich formatting.

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x

## Installation

Install the package via Composer:

```bash
composer require larafystudios/discord-webhooks
```

The package will automatically register its service provider and facade.

## Configuration

### Publish Configuration (Optional)

If you want to customize the default configuration, publish the config file:

```bash
php artisan vendor:publish --tag=discord-webhooks-config
```

This will create a `config/discord-webhooks.php` file in your project.

### Environment Variables

You can configure the package using environment variables in your `.env` file:

```env
DISCORD_WEBHOOK_URL=https://discord.com/api/webhooks/your-webhook-url
DISCORD_WEBHOOK_USERNAME="Laravel Application"
DISCORD_WEBHOOK_AVATAR_URL=https://example.com/avatar.png
```

## Usage

### Basic Text Message

Send a simple text message:

```php
use LarafyStudios\DiscordWebhooks\DiscordWebhook;

DiscordWebhook::make()
    ->setContent('Hello from Laravel!')
    ->send();
```

### Using the Facade

You can also use the provided facade:

```php
use DiscordWebhook;

DiscordWebhook::make()
    ->setContent('Hello from Laravel!')
    ->send();
```

### Custom Webhook URL

Specify a different webhook URL for a specific message:

```php
DiscordWebhook::make('https://discord.com/api/webhooks/your-custom-webhook-url')
    ->setContent('Custom webhook message')
    ->send();
```

### Customize Username and Avatar

Set a custom username and avatar for the webhook:

```php
DiscordWebhook::make()
    ->setUsername('My Custom Bot')
    ->setAvatarUrl('https://example.com/avatar.png')
    ->setContent('Hello with custom identity!')
    ->send();
```

### Rich Embeds

Create beautiful embed messages:

```php
DiscordWebhook::make()
    ->setContent('Check out this embed!')
    ->addEmbed(function ($embed) {
        $embed->setTitle('Embed Title', 'https://example.com')
              ->setDescription('This is a detailed description of the embed content.')
              ->setColor(0x3498db) // Blue color
              ->addField('Field 1', 'Value 1', true)
              ->addField('Field 2', 'Value 2', true)
              ->addField('Field 3', 'This is a longer value that spans multiple lines', false)
              ->setFooter('Footer text', 'https://example.com/footer-icon.png')
              ->setTimestamp();
    })
    ->send();
```

### Embed Only (No Text)

Send an embed without text content:

```php
DiscordWebhook::make()
    ->addEmbed(function ($embed) {
        $embed->setTitle('Notification')
              ->setDescription('This is an embed-only message')
              ->setColor(0x00ff00) // Green
              ->setTimestamp();
    })
    ->send();
```

### Multiple Embeds

Add multiple embeds to a single message:

```php
DiscordWebhook::make()
    ->setContent('Multiple embeds example')
    ->addEmbed(function ($embed) {
        $embed->setTitle('First Embed')
              ->setDescription('This is the first embed')
              ->setColor(0xff0000); // Red
    })
    ->addEmbed(function ($embed) {
        $embed->setTitle('Second Embed')
              ->setDescription('This is the second embed')
              ->setColor(0x0000ff); // Blue
    })
    ->send();
```

### Using Embed Instance Directly

You can also create and pass an embed instance directly:

```php
use LarafyStudios\DiscordWebhooks\DiscordEmbed;

$embed = new DiscordEmbed();
$embed->setTitle('Direct Embed')
      ->setDescription('Created directly')
      ->setColor(0xffff00);

DiscordWebhook::make()
    ->setContent('Using direct embed instance')
    ->addEmbed($embed)
    ->send();
```

### Method Chaining

All methods support fluent chaining:

```php
DiscordWebhook::make()
    ->setUsername('My Bot')
    ->setAvatarUrl('https://example.com/avatar.png')
    ->setContent('Chained methods example')
    ->addEmbed(function ($embed) {
        $embed->setTitle('Title')
              ->setDescription('Description')
              ->setColor(0x3498db)
              ->setAuthor('Author Name', 'https://example.com', 'https://example.com/author.png')
              ->setThumbnail('https://example.com/thumbnail.png')
              ->setImage('https://example.com/image.png')
              ->addField('Inline Field 1', 'Value', true)
              ->addField('Inline Field 2', 'Value', true)
              ->addField('Full Width Field', 'Value', false)
              ->setFooter('Footer', 'https://example.com/footer.png')
              ->setTimestamp();
    })
    ->send();
```

## API Reference

### DiscordWebhook Methods

| Method | Description | Parameters |
|--------|-------------|------------|
| `make(?string $url = null)` | Create a new webhook instance | `$url` - Optional webhook URL |
| `setContent(string $content)` | Set the message text content | `$content` - The message text |
| `setUsername(string $username)` | Set the webhook username | `$username` - The username |
| `setAvatarUrl(string $avatarUrl)` | Set the webhook avatar URL | `$avatarUrl` - The avatar URL |
| `addEmbed(callable\|DiscordEmbed $embed)` | Add an embed to the message | `$embed` - Callback or embed instance |
| `send()` | Send the webhook message | Returns `bool` |

### DiscordEmbed Methods

| Method | Description | Parameters |
|--------|-------------|------------|
| `setTitle(string $title, ?string $url = null)` | Set the embed title | `$title` - Title text, `$url` - Optional title URL |
| `setDescription(string $description)` | Set the embed description | `$description` - Description text |
| `setColor(int $color)` | Set the embed color | `$color` - Hex color as integer (e.g., `0x3498db`) |
| `setTimestamp(?\DateTimeInterface $timestamp = null)` | Set the embed timestamp | `$timestamp` - Optional timestamp (defaults to now) |
| `setFooter(string $text, ?string $iconUrl = null)` | Set the embed footer | `$text` - Footer text, `$iconUrl` - Optional icon URL |
| `setImage(string $url)` | Set the embed image | `$url` - Image URL |
| `setThumbnail(string $url)` | Set the embed thumbnail | `$url` - Thumbnail URL |
| `setAuthor(string $name, ?string $url = null, ?string $iconUrl = null)` | Set the embed author | `$name` - Author name, `$url` - Optional author URL, `$iconUrl` - Optional icon URL |
| `addField(string $name, string $value, bool $inline = false)` | Add a field to the embed | `$name` - Field name, `$value` - Field value, `$inline` - Whether field is inline |

## Error Handling

The `send()` method returns `boolean`:
- `true` if the webhook was sent successfully
- `false` if the webhook failed to send

Errors are automatically logged to Laravel's log system. If the webhook URL is not set, an `InvalidArgumentException` will be thrown during instantiation.

## Examples

### Notification System

```php
// In your User model or event listener
use LarafyStudios\DiscordWebhooks\DiscordWebhook;

public function notifyNewUser($user)
{
    DiscordWebhook::make()
        ->setContent("New user registered: {$user->name}")
        ->addEmbed(function ($embed) use ($user) {
            $embed->setTitle('New User Registration')
                  ->setDescription("User {$user->name} ({$user->email}) has registered.")
                  ->setColor(0x00ff00)
                  ->addField('User ID', (string) $user->id, true)
                  ->addField('Email', $user->email, true)
                  ->setTimestamp();
        })
        ->send();
}
```

### Error Reporting

```php
try {
    // Your code here
} catch (\Exception $e) {
    DiscordWebhook::make()
        ->setContent('⚠️ An error occurred in the application')
        ->addEmbed(function ($embed) use ($e) {
            $embed->setTitle('Error Report')
                  ->setDescription($e->getMessage())
                  ->setColor(0xff0000)
                  ->addField('File', $e->getFile(), false)
                  ->addField('Line', (string) $e->getLine(), true)
                  ->setTimestamp();
        })
        ->send();
}
```

## Testing

When testing your application, you may want to prevent actual webhook calls. You can mock the `Http` facade or use a test webhook URL.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Support

For issues, questions, or contributions, please visit the [GitHub repository](https://github.com/LarafyStudios/discord-webhooks).

---

Made with ❤️ by [LarafyStudios](https://github.com/LarafyStudios)
