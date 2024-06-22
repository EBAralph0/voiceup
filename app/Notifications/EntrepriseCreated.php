<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Entreprise;
class EntrepriseCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Entreprise $entreprise)
    {
        //
        $this->entreprise = $entreprise;
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
                    ->line('Votre entreprise a ete creee.')
                    ->line('Nom de l\'entreprise: ' . $this->entreprise->nom_entreprise)
                    ->action('Aller voir', url('/entreprises/'.$this->id))
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
            "nom_entreprise"=>$this->nom_entreprise,
            "sigle"=>$this->sigle,
            "numero_entreprise"=>$this->numero_entreprise,
            "mail_entreprise"=>$this->mail_entreprise,
            "logo_entreprise"=>$this->logo_entreprise,
            "created_by_id"=>$this->created_by_id,
            "slogan"=>$this->slogan,
            "description"=>$this->description,
            "id_secteur"=>$this->id_secteur
        ];
    }
}
