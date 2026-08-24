<?php

namespace App\Notifications;

use App\Models\Message;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification
{
    public function __construct(public Message $message)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title('New Contact Message')
            ->icon('heroicon-o-envelope')
            ->body("From {$this->message->name} ({$this->message->email}): " . \Illuminate\Support\Str::limit($this->message->message, 80))
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(\App\Filament\Resources\Messages\MessageResource::getUrl('view', ['record' => $this->message->id]))
            ])
            ->getDatabaseMessage();
    }
}
