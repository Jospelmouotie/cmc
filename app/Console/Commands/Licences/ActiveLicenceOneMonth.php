<?php

namespace App\Console\Commands\Licences;

use App\Models\Licence;
use Illuminate\Console\Command;

class ActiveLicenceOneMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nksoftcare:licence-one-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ajout d\'un mois de validité pour la clé de licence';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Ajout d\'un mois de validité pour la clé de licence......');

        Licence::ActiveLicenceOneMonth();

        $this->info('Bravo!! un nouveau mois de validité pour l\'utilisation de l\'application');
    }
}
