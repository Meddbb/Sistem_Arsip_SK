<?php

namespace App\Providers;

use App\Models\SK;
use App\Models\User;
use App\Policies\SKPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        SK::class => SKPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}