<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Forms\Components\ServiceImageUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                TextInput::make('cv')
                    ->label('CV Google Drive URL')
                    ->url()
                    ->placeholder('https://drive.google.com/file/d/.../view')
                    ->helperText('Set the Google Drive file sharing to “Anyone with the link” before saving.')
                    ->prefixIcon('heroicon-m-link')
                    ->columnSpanFull(),
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
                Section::make('Arabic Translation (الترجمة العربية)')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name_ar')
                            ->label('Name (Arabic)'),
                        TextInput::make('title_ar')
                            ->label('Title (Arabic)'),
                        TextInput::make('location_ar')
                            ->label('Location (Arabic)'),
                        Textarea::make('bio_ar')
                            ->label('Short Bio (Arabic)')
                            ->columnSpanFull(),
                        Textarea::make('about_text_ar')
                            ->label('Extended Bio (Arabic)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
