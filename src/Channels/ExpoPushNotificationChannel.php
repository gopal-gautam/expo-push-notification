<?php

namespace Gopal\ExpoNotificationChannel\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client as HttpClient;

class ExpoPushNotificationChannel
{
    protected $http;
    protected $url;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
        $this->url = 'https://exp.host/--/api/v2/push/send';
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toExpo')) {
            throw new \RuntimeException('Notification is missing toExpo method.');
        }
        $data = $notification->toExpo($notifiable);
        $this->sendTokens($notifiable, $notification, $data);
    }

    private function sendTokens($notifiable, Notification $notification, $payload)
    {
        $tokens = collect($notifiable->routeNotificationForExpo());
        $tokens->each(function ($to, $key) use ($notifiable, $notification, $payload) {
            $payload = $this->buildMessage($notification->toExpo($notifiable));
            $payload['to'] = $to;
            $this->http->request('POST', $this->url, ['json' => $payload]);
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
