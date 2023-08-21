<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseCreated extends Notification
{
    use Queueable;

    protected Expense $expense;

    /**
     * Create a new notification instance.
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Olá ' . $this->expense->user->name ?? "")
                    ->subject("Nova Despesa Criada")
                    ->line('Você acabou de lançar uma nova despesa no sistema. Confira os detalhes:')
                    ->line('Descrição: ' . $this->expense->description )
                    ->line('Valor: R$' . $this->expense->value )
                    ->line('Data da Ocorrência: ' . Carbon::parse($this->expense->occurrence_date)->format("d/m/Y") );
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
