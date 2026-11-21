<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Field::configureUsing(function (Field $field): void {
            $field->translateLabel();
        });

        Column::configureUsing(function (Column $column): void {
            $column->translateLabel();
        });

        BaseFilter::configureUsing(function (BaseFilter $filter): void {
            $filter->translateLabel();
        });
    }
}
