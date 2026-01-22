<?php

namespace LarafyStudios\DiscordWebhooks;

use Illuminate\Support\ServiceProvider;

class DiscordWebhooksServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/discord-webhooks.php',
            'discord-webhooks'
        );

        $this->app->singleton('discord-webhook', function ($app) {
            return new DiscordWebhook();
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/discord-webhooks.php' => config_path('discord-webhooks.php'),
        ], 'discord-webhooks-config');
    }
}
