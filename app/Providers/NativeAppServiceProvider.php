<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Window::open('movies.all')
            ->route('movies.all')
            ->title('CinemaHub - Home')
            ->width(800)
            ->height(800);

        Window::open('admin.dashboard')
            ->route('admin.dashboard')
            ->title('CinemaHub - Admin')
            ->width(600)
            ->height(600);
        MenuBar::show();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
