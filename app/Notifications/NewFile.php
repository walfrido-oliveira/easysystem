<?php

namespace App\Notifications;

use App\Budget\Budget;
use App\Budget\BudgetFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewFile extends Notification
{
    use Queueable;

    /**
     * The budget for sending information.
     *
     * @var Budget
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
     * @var BudgetFiles
     */
    public $file;

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
    public function __construct($budget, $userName, $file)
    {
        $this->budget = $budget;
        $this->userName = $userName;
        $this->file = $file;
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
                    ->subject('Novo Arquivo Adicionado')
                    ->greeting('Olá ' . $this->userName)
                    ->line('Foi adicionado o seguinte arquivo ao orçamento ' . $this->budget->internal_id . ', clique no link abaixo e visualize  o arquivo:')
                    ->line(new HtmlString("<a href='" . route('file.open', $this->file->id) . "' class='btn btn-success' target='_blank'>" . $this->file->name . "</a>"))
                    ->line('Ou visualize seu orçamento acessando sua conta do ' . config('app.name') . '.')
                    ->action('Acesse sua conta', url('/home/user/budget/show/'. $this->budget->id));
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
