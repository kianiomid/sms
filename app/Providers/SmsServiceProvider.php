<?php

namespace App\Providers;

use App\Services\SMS\Kavenegar\KavenegarSmsPanel;
use App\Services\SMS\Mellipayamak\MellipayamakSmsPanel;
use App\Services\SMS\SmsInterface;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SmsInterface::class, function ($app) {
            return new MellipayamakSmsPanel($app);
        });

        $this->app->bind(SmsInterface::class, function ($app) {
            return new KavenegarSmsPanel($app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
