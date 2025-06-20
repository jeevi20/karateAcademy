<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClassScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $classDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($classDetails)
    {
        $this->classDetails = $classDetails;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // Can add 'database' if needed
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Karate Class Scheduled')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new karate class has been scheduled.')
            ->line('**Class Name:** ' . $this->classDetails['name'])
            ->line('**Date:** ' . $this->classDetails['date'])
            ->line('**Instructor:** ' . $this->classDetails['instructor'])
            ->action('View Schedule', url('/schedule'))
            ->line('Thank you for being part of our karate academy!');
    }

    /**
     * Get the array representation of the notification (for database storage).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Karate Class Scheduled',
            'message' => 'A new karate class has been scheduled for ' . $this->classDetails['date'],
            'class_name' => $this->classDetails['name'],
            'instructor' => $this->classDetails['instructor'],
        ];
    }
}
