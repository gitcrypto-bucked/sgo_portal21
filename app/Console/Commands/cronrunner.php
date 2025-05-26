<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class cronrunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronrunner:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute cron files on cron folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job running at ". now());

        shell_exec('cd '.dirname(__DIR__,3).'/cron &&  php updateChamadosStatus.php');
        sleep(4);
        shell_exec('cd '.dirname(__DIR__,3).' &&  php artisan optimize:clear');

    }
}

