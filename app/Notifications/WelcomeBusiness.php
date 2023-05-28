<?php

namespace App\Notifications;

use App\Utils\NotificationUtil;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Business;

class WelcomeBusiness extends Notification
{
    use Queueable;
    
    protected $notificationInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $notificationUtil = new NotificationUtil();
        $mailData = ['email_settings' => [
                "mail_driver" => "smtp",
                "mail_host" => "smtp.hostinger.com",
                "mail_port" => "465",
                "mail_username" => "support@erptec.net",
                "mail_password" => "Mostafa_010",
                "mail_encryption" => "SSL",
                "mail_from_address" => "support@erptec.net",
                "mail_from_name" => "ERP TEC"
            ]];
        $notificationUtil->configureEmail($mailData, false);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('This is a test email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'title'
        ];
    }
}
