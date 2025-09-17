<?php

namespace App\Notifications;

use App\Models\Summary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContentSummaryNotification extends Notification
{
    use Queueable;
    protected  $summary;

    /**
     * Create a new notification instance.
     */
    public function __construct(Summary $summary)
    {
        $this->summary = $summary;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'ملاحظات جديدة على المحتوى',
            'message'  => ('قام المشرف بإضافة ملاحظات على محتواك: ' . $this->summary->content->title)
        ];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
