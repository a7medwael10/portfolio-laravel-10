<?php

namespace App\Filament\Resources\Messages\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                \Filament\Tables\Columns\IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Read Status'),
            ])
            ->actions([
                ViewAction::make(),
                \Filament\Tables\Actions\Action::make('toggleRead')
                    ->label(fn ($record) => $record->is_read ? 'Mark as Unread' : 'Mark as Read')
                    ->icon(fn ($record) => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_read ? 'warning' : 'success')
                    ->action(fn ($record) => $record->update(['is_read' => ! $record->is_read])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
