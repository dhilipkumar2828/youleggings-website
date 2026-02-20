<?php

namespace App\Console;

use App\Console\Commands\AutoCart;

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel

{

    /**

     * Define the application's command schedule.

     *

     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule

     * @return void

     */

     protected $commands=[

               \App\Console\Commands\AutoCart::class,

                  \App\Console\Commands\AutoWishlist::class,

         ];

    protected function schedule(Schedule $schedule)

    {

         $schedule->command('auto:cartsend')->everyMinute();

         $schedule->command('auto:wishlistsend')->everyMinute();

    }

    /**

     * Register the commands for the application.

     *

     * @return void

     */

    protected function commands()

    {

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

    }

}
