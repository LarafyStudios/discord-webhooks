<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Webhook URL
    |--------------------------------------------------------------------------
    |
    | This is the default Discord webhook URL that will be used when no
    | specific webhook URL is provided.
    |
    */
    'default_webhook_url' => env('DISCORD_WEBHOOK_URL'),

    /*
    |--------------------------------------------------------------------------
    | Default Username
    |--------------------------------------------------------------------------
    |
    | The default username for webhook messages.
    |
    */
    'default_username' => env('DISCORD_WEBHOOK_USERNAME', 'Laravel Application'),

    /*
    |--------------------------------------------------------------------------
    | Default Avatar URL
    |--------------------------------------------------------------------------
    |
    | The default avatar URL for webhook messages.
    |
    */
    'default_avatar_url' => env('DISCORD_WEBHOOK_AVATAR_URL'),
];
