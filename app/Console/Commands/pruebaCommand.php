<?php

namespace App\Console\Commands;

use App\Jobs\ValidarOrdenesEfectivo;
use Illuminate\Console\Command;

class pruebaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prueba-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }
}
