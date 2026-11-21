<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Experiences\ExperienceResource;
use App\Filament\Resources\Messages\MessageResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Skills\SkillResource;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $projectsCount = Project::count();
        $skillsCount = Skill::count();
        $experiencesCount = Experience::count();
        $messagesCount = Message::count();
        $unreadMessagesCount = Message::where('is_read', false)->count();

        return [
            Stat::make('Total Projects', $projectsCount)
                ->description('Published portfolio projects')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('primary')
                ->url(ProjectResource::getUrl('index')),

            Stat::make('Total Skills', $skillsCount)
                ->description('Technical skills cataloged')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info')
                ->url(SkillResource::getUrl('index')),

            Stat::make('Work Experiences', $experiencesCount)
                ->description('Career history entries')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning')
                ->url(ExperienceResource::getUrl('index')),

            Stat::make('Received Messages', $messagesCount)
                ->description($unreadMessagesCount > 0 ? "{$unreadMessagesCount} unread" : 'All messages read')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadMessagesCount > 0 ? 'danger' : 'success')
                ->url(MessageResource::getUrl('index')),
        ];
    }
}
