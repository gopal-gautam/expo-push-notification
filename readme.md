# Expo Push Notification channel for laravel
This package will provide the notification channel for expo push notification


## Setup

    composer require 
    php artisan vendor:publish

## Prepare your model
You can use this in your notifiable model. 
You will need a column in your database to save device token for expo. 
You can specify that in expo_notification.php config file
All you have to do now is add use ExpoPushNotifiable trait in your model:

    use ExpoPushNotifiable;

## Adding via
In your notification add ExpoNotificationChannel

    /**  
     * Get the notification's delivery channels. * * @param mixed  $notifiable  
     * @return array  
     */public function via($notifiable)  
    {  
      return [ExpoPushNotificationChannel::class];  
    }
