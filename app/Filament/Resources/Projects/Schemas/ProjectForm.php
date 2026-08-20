<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectType;
use App\Filament\Forms\Components\ServiceImageUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;

class ProjectForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('type')
                    ->label('Project Type')
                    ->options(ProjectType::class)
                    ->default(ProjectType::FREELANCE)
                    ->required()
                    ->live(),
                Select::make('experience_id')
                    ->label('Company Experience')
                    ->relationship('experience', 'company')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->company} ({$record->title})")
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Select the company experience this project was built for')
                    ->visible(fn (Get $get) => $get('type') === ProjectType::COMPANY->value || $get('type') === ProjectType::COMPANY),
                Textarea::make('description')
                    ->columnSpanFull(),
                ServiceImageUpload::make('main_image', directory: 'projects'),
                TextInput::make('github_url')
                    ->url(),
                TextInput::make('live_url')
                    ->url(),
                Select::make('skills')
                    ->multiple()
                    ->relationship('skills', 'name')
                    ->preload(),
                \Filament\Forms\Components\Toggle::make('is_visible')
                    ->label('Visible on Portfolio')
                    ->default(true),
            ]);
    }
}
