<?php

namespace App\Filament\Widgets;

use App\Models\Profile;
use Filament\Widgets\Widget;

class ProfileSummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.profile-summary-widget';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public ?Profile $profile = null;

    public function mount(): void
    {
        $this->profile = Profile::first();
    }
}
