<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class ExperienceForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('company')
                    ->required(),
                TextInput::make('company_url')
                    ->label('Company URL')
                    ->url(),
                TextInput::make('work_location')
                    ->label('Work location'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                \Filament\Forms\Components\TagsInput::make('description')
                    ->placeholder('Add a bullet point'),
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Visible on Portfolio')
                    ->default(true),
            ]);
    }
}
