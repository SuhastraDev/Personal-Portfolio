<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share unread messages count with all admin views
        View::composer('layouts.admin', function ($view) {
            $view->with('unreadMessagesCount', Contact::unread()->count());
        });
    }
}
