<?php

namespace Gopal\LaravelExpoNotificationChannel;

trait ExpoPushNotifiable
{
    public function routeNotificationForExpo()
    {
        return $this->{config('expo_notification.token_column')};
    }
}
