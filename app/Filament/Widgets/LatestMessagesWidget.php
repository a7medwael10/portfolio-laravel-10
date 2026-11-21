<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Messages\MessageResource;
use App\Models\Message;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessagesWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Latest Messages';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Latest Messages'))
            ->query(Message::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->weight('medium')
                    ->searchable(false),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->color('gray')
                    ->copyable(),
                TextColumn::make('message')
                    ->label(__('Message'))
                    ->limit(60)
                    ->tooltip(fn (Message $record): string => $record->message),
                IconColumn::make('is_read')
                    ->label(__('Read'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('Received'))
                    ->since(),
            ])
            ->actions([
                Action::make('view')
                    ->label(__('View'))
                    ->icon('heroicon-m-eye')
                    ->url(fn (Message $record): string => MessageResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading(__('No messages yet'))
            ->emptyStateDescription(__('Messages sent from your portfolio contact form will appear here.'));
    }
}
