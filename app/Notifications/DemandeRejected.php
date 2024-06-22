<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Demande;


class DemandeRejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Demande $demande)
    {
        //
        $this->demande = $demande;
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
            ->line('Votre demande n\' a pas aboutie.')
            ->line('Nom de l\'entreprise: ' . $this->demande->nom_entreprise)
            ->line('Utilisateur: ' . $this->demande->user->name)
            ->action('Creer une nouvelle', url('/demandes/create'))
            ->line('Merci d\'utiliser Voice Up!');
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
            'demande_id' => $this->demande->id,
            'nom_entreprise' => $this->demande->nom_entreprise,
        ];
    }
}
