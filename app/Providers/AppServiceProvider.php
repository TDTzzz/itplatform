<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Question::observe(\App\Observers\QuestionObserver::class);
        \App\Post::observe(\App\Observers\PostObserver::class);
        \App\Answer::observe(\App\Observers\AnswerObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
