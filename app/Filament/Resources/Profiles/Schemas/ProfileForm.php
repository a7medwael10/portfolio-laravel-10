<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Forms\Components\ServiceImageUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;

class ProfileForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('title'),
                Textarea::make('bio')
                    ->label('Short Bio (Home Page)')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('about_text')
                    ->label('Extended Bio (About Page)')
                    ->columnSpanFull(),
                ServiceImageUpload::make('hero_image', 'Home Page Photo', 'avatars'),
                ServiceImageUpload::make('avatar', 'About Page Photo', 'avatars'),
                FileUpload::make('cv')
                    ->label('CV / Resume File')
                    ->directory('cvs')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->openable()
                    ->downloadable(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('github_url')
                    ->url(),
                TextInput::make('linkedin_url')
                    ->url(),
                TextInput::make('location'),
            ]);
    }
}
