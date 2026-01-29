<?php

namespace App\Console\Commands\Licences;

use App\Models\Licence;
use Illuminate\Console\Command;

class ActiveLicenceKey extends Command
{
    protected $signature = 'nksoftcare:active-licence-key';
    protected $description = 'Activation de la clé de licence';

    public function handle()
    {
        // On cherche la licence
        $licence = Licence::where('client', 'cmcuapp')
                  ->orWhere('client', 'CMCU-RENDER') // Ajout pour matcher ton seeder
                  ->first();

        // Sécurité : Si la licence n'existe pas du tout
        if (!$licence) {
            $this->error('Aucune licence trouvée dans la base de données. Lancez le seeder d\'abord.');
            return;
        }

        // Sécurité : On vérifie la propriété active_date
        if ($licence->active_date) {
            $this->error('Votre licence est déjà activée.');
        } else {
            $this->info('Activation de la licence......');
            Licence::ActiveLicenceKey();
            $this->info('Votre licence a bien été activée.');
        }
    }
}
