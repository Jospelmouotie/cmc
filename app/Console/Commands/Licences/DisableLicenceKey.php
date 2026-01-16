<?php

namespace App\Console\Commands\Licences;

use App\Models\Licence;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DisableLicenceKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nksoftcare:disable-licence-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Désactivation de la clé de licence';

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

        if ($licence->expire_date >= Carbon::now()){

            $this->error('La clé de licence n\'a pas encore expiré');
        }else{

            $this->info('Désactivation de la clé de licence......');

            Licence::DisableLicenceKey();

            $this->info('La clé de licence a bien été désactivé');
        }

    }
}
