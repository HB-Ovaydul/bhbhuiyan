<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientAccountNotification extends Notification
{
    use Queueable;

    private $token;
    private $name;
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($patient)

    {   
        
        $this -> token  = $patient -> access_token;
        $this -> name      = $patient -> first_name;
        
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
                    ->line('Assalamu Alaikum.' .$this->name.' '. 'Confirm Your Account, Press The Active Link' )
                    ->action('Activate', url('/patient_access_account/'.$this->token))
                    ->line('Thank you for using our application!');

                    
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
}
