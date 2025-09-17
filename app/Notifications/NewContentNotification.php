<?php

namespace App\Notifications;

use App\Models\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewContentNotification extends Notification
{
    use Queueable;

    public $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // يمكنك إضافة 'mail' إذا أردت إرسال بريد
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'محتوى جديد',
            'message'  => 'تم إضافة محتوى جديد بعنوان: ' . $this->content->title,
            'student' => $this->content->student->user->name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'محتوى جديد',
            'body'  => 'تم إضافة محتوى جديد بعنوان: ' . $this->content->title,
            'content_id' => $this->content->id,
            'student' => $this->content->student->user->name,
        ]);
    }
}
