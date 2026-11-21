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
            ->query(Message::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->weight('medium')
                    ->searchable(false),
                TextColumn::make('email')
                    ->color('gray')
                    ->copyable(),
                TextColumn::make('message')
                    ->limit(60)
                    ->tooltip(fn (Message $record): string => $record->message),
                IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Message $record): string => MessageResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('No messages yet')
            ->emptyStateDescription('Messages sent from your portfolio contact form will appear here.');
    }
}
