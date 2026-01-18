<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Auth::class, function ($app) {
            $firebase = (new Factory)
                ->withServiceAccount(env('FIREBASE_CREDENTIALS'));

            return $firebase->createAuth();
        });
    }

    public function boot(): void
    {
        //
    }
}
