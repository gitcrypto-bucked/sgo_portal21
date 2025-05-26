<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
 use \App\Console\Commands\cronrunner;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$file = 'command1_output.log';

//Schedule::command('cronrunner:cron')->everyMinute()->sendOutputTo($file);

Schedule::call('cronrunner:cron')->everyFifteenMinutes()->sendOutputTo($file);


