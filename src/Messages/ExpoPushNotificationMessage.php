<?php

namespace Gopal\ExpoNotificationChannel\Messages;

class ExpoPushNotificationMessage
{
    public $title;
    public $body;
    public $subtitle = '';
    public $priority = 'default';
    public $sound = 'default';
    public $badgeCount = 0;
    public $data = [];

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    public function subtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function priority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    public function sound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    public function badgeCount($badgeCount)
    {
        $this->badgeCount = $badgeCount;
        return $this;
    }

    public function data($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
}
