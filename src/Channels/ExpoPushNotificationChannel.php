<?php

namespace Gopal\ExpoNotificationChannel\Channels;

use Gopal\LaravelExpoNotificationChannel\ExpoPushNotifiable;
use Illuminate\Notifications\Notification;
use GuzzleHttp\Client as HttpClient;

class ExpoPushNotificationChannel
{
    protected $httpClient;
    protected $url;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->url = 'https://exp.host/--/api/v2/push/send';
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toExpo')) {
            throw new \RuntimeException('toExpo method is required for notification');
        }
        $payload = $notification->toExpo($notifiable);
        $this->sendTokens($notifiable, $notification, $payload);
    }

    private function sendTokens($notifiable, Notification $notification, $payload)
    {
        /** @var ExpoPushNotifiable $notifiable */
        $tokens = collect($notifiable->routeNotificationForExpo());
        $tokens->each(function ($to, $key) use ($notifiable, $notification, $payload) {
            $payload = $this->buildMessage($notification->toExpo($notifiable));
            $payload['to'] = $to;
            $this->httpClient->request('POST', $this->url, ['json' => $payload]);
        });
    }

    protected function buildMessage($data):array
    {
        $result = [
            'title' => $data->title,
            'body' => $data->body,
            'subtitle' => $data->subtitle,
            'priority' => $data->priority,
            'sound' => $data->sound,
            'badge' => $data->badgeCount,
            'data' => $data->data,
        ];
        return $result;
    }
}
