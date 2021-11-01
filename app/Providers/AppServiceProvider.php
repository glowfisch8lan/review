<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(trans('common.letter_reg_title'))
                ->greeting(trans('common.letter_reg_hello',['name'=>$notifiable->name]))
                ->line(trans('common.letter_reg_text'))
                ->salutation(' ')
                ->action(trans('common.letter_reg_action'), $url)
                ->line(trans('common.letter_regard'))
                ->markdown('vendor.notifications.email',[
                    'footer'=>trans('common.letter_reg_footer'),
                ]);
        });
    }
}
