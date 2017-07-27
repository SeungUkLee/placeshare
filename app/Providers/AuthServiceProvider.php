<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->registerPolicies();

        // "Ability" 정의 : 다른 사람의 글을 볼때 수정, 삭제 할 수 없으며 @can으로 인해 해당 버튼을 볼 수 없다.
//       Gate::before(function ($user) {
//            if ($user->isAdmin()) return true;
//        });
        Gate::define('update', function ($user, $model) {
            return $user->id === $model->user_id;
        });
        Gate::define('delete', function ($user, $model) {
            return $user->id === $model->user_id;
        });

        //
    }
}
