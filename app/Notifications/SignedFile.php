<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Budget\Budget;

class SignedFile extends Notification
{
    use Queueable;

    /**
     * The budget for sending information.
     *
     * @var string
     */
    public $budget;

    /**
     * The name of user.
     *
     * @var string
     */
    public $userName;

    /**
     * The name of file.
     *
     * @var string
     */
    public $fileName;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($budget, $userName, $fileName)
    {
        $this->budget = $budget;
        $this->userName = $userName;
        $this->fileName = $fileName;
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
                    ->subject('Arquivo Assinado')
                    ->greeting('Olá ' . $this->userName)
                    ->line('O seguinte arquivo do orçamento ' . $this->budget->internal_id . ' acaba de ser assinado:')
                    ->line('- ' . $this->fileName)
                    ->line('Verifique o arquivo acessando sua conta do ' . config('app.name') . '.')
                    ->action('Verifique sua conta', url('/home/user/budget/show/'. $this->budget->id));
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

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
