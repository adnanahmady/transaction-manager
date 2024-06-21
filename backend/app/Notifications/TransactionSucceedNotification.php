<?php

namespace App\Notifications;

use App\Models\User;
use App\NotificationChannels\SmsChannel;
use App\NotificationMessages\NotificationMessage;
use App\Support\Sms\SmsMessage;
use App\Support\Sms\SmsMessageInterface;
use App\Support\Sms\SmsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TransactionSucceedNotification extends Notification implements
    SmsNotification,
    ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param NotificationMessage $message
     */
    public function __construct(
        private readonly NotificationMessage $message,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SmsChannel::class];
    }

    public function toSms(User $notifiable): SmsMessageInterface
    {
        return (new SmsMessage())
            ->receptor($notifiable->{User::PHONE_NUMBER})
            ->content($this->message->prepare());
    }
}
