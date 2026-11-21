<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectType: string implements HasLabel, HasColor
{
    case COMPANY = 'company';
    case FREELANCE = 'freelance';
    case PERSONAL = 'personal';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::COMPANY => __('Company Experience Project'),
            self::FREELANCE => __('Freelance Project'),
            self::PERSONAL => __('Personal Project'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::COMPANY => 'info',
            self::FREELANCE => 'warning',
            self::PERSONAL => 'success',
        };
    }
}
