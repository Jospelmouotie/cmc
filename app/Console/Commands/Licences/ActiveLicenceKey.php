<?php

namespace App\Console\Commands\Licences;

use App\Models\Licence;
use Illuminate\Console\Command;

class ActiveLicenceKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nksoftcare:active-licence-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activation de la clé de licence';

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

        $licence = Licence::where('client', 'cmcuapp')->first();

        if ($licence->active_date){
            $this->error('Votre licence est déja activé');
        }else{

            $this->info('Activation de la licence......');

            Licence::ActiveLicenceKey();

            $this->info('Votre licence a bien été ativé');
        }

    }
}
