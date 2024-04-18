<?php

namespace App\Listeners;

use App\Events\EtatsPersonnelEvent;
use App\Exports\EtatPersonnelExport;
use App\Models\Client;
use Filament\Notifications\Notification;

class DownloadEtatsPersonnelListener
{
    /**
     * Create the event listener.
     */
    protected Client $client;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EtatsPersonnelEvent $event): void
    {
        $this->client = $event->client;
        try {
            \Maatwebsite\Excel\Facades\Excel::download(new EtatPersonnelExport($this->client), "etat-personnel-{$this->client->nom}.xlsx");
            Notification::make('Etat personnel téléchargé avec succès')
                ->title('Téléchargement réussi')
                ->body('Le téléchargement de l\'état personnel a été effectué avec succès.')
                ->color('success')
                ->iconColor('success')
                ->send()
                ->sendToDatabase(auth()->user(), true);
        } catch (\Exception $e) {
            Notification::make('Erreur lors du téléchargement de l\'état personnel')
                ->title('Erreur')
                ->body($e)
                ->color('danger')
                ->iconColor('danger')
                ->send()
                ->sendToDatabase(auth()->user(), true);

        }

    }
}
