<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class EducationForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('degree')
                    ->required(),
                TextInput::make('institution')
                    ->required(),
                TextInput::make('institution_url')
                    ->label('Institution URL')
                    ->url(),
                TextInput::make('location'),
                TextInput::make('field_of_study'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('grade'),
                \Filament\Forms\Components\TagsInput::make('description')
                    ->placeholder('Add a bullet point'),
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Visible on Portfolio')
                    ->default(true),
            ]);
    }
}
