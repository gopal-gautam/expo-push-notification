<?php

namespace Gopal\ExpoNotificationChannel;

use Illuminate\Support\ServiceProvider;

class ExpoNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->offerPublishing();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Setup the configuration for Expo Notification Channel.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/expo_notification.php', 'expo_notification'
        );
    }

    /**
     * Setup the resource publishing groups for Inbox.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/expo_notification.php' => config_path('expo_notification.php'),
            ], 'expo-notification-config');
        }
    }
}
