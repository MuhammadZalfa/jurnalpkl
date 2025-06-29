<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Models\User;
use App\Policies\AssessmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Assessment::class => AssessmentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->role === 'admin') {
                return true;
            }
        });
    }
}