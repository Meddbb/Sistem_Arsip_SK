<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\SK;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('viewAny-user', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('create-sk', function (User $user) {
            return $user->isAdmin() || $user->isAnggotaDivisi();
        });
    }
}