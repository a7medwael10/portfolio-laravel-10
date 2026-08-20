<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class SkillForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->required(),
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Visible on Portfolio')
                    ->default(true),
            ]);
    }
}
