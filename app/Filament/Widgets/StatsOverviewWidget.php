<?php

namespace App\Filament\Widgets;

use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $projectsCount = Project::count();
        $skillsCount = Skill::count();
        $experiencesCount = Experience::count();
        $messagesCount = Message::count();

        return [
            Stat::make('Total Projects', $projectsCount)
                ->description('Published portfolio projects')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('indigo'),

            Stat::make('Total Skills', $skillsCount)
                ->description('Technical skills cataloged')
                ->descriptionIcon('heroicon-m-code-bracket')
                ->color('cyan'),

            Stat::make('Work Experiences', $experiencesCount)
                ->description('Career history entries')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('purple'),

            Stat::make('Received Messages', $messagesCount)
                ->description('Contact form submissions')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('emerald'),
        ];
    }
}
