@php
    $isArabic = app()->getLocale() === 'ar';
    $displayName = ($isArabic && filled($profile?->name_ar)) ? $profile->name_ar : ($profile?->name ?? 'Ahmed Wael');
    $displayTitle = ($isArabic && filled($profile?->title_ar)) ? $profile->title_ar : ($profile?->title ?? 'Backend Developer');
    $displayLocation = ($isArabic && filled($profile?->location_ar)) ? $profile->location_ar : ($profile?->location ?? __('Not specified'));
    $displayBio = ($isArabic && filled($profile?->bio_ar)) ? $profile->bio_ar : ($profile?->bio ?? __('No bio provided yet.'));
@endphp

<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-m-user" icon-color="primary">
        <x-slot name="heading">
            {{ __('Profile Data Summary') }}
        </x-slot>

        <x-slot name="headerEnd">
            @if ($profile)
                <x-filament::button
                    href="{{ \App\Filament\Resources\Profiles\ProfileResource::getUrl('edit', ['record' => $profile->id]) }}"
                    tag="a" color="primary" size="sm" icon="heroicon-m-pencil-square">
                    {{ __('Edit Profile Data') }}
                </x-filament::button>
            @else
                <x-filament::button
                    href="{{ \App\Filament\Resources\Profiles\ProfileResource::getUrl('create') }}"
                    tag="a" color="primary" size="sm" icon="heroicon-m-plus">
                    {{ __('Create Profile') }}
                </x-filament::button>
            @endif
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-1">
            <!-- Col 1: Avatar & Identity -->
            <div
                class="flex items-center gap-4 border-b md:border-b-0 md:border-e border-gray-100 dark:border-gray-800 pb-4 md:pb-0 md:pe-4">
                @if ($profile?->hero_image_url || $profile?->avatar_url)
                    <img src="{{ $profile->hero_image_url ?? $profile->avatar_url }}" alt="{{ $displayName }}"
                        class="h-16 w-16 rounded-xl object-cover ring-2 ring-indigo-500/20 shadow-sm shrink-0" />
                @else
                    <div
                        class="h-16 w-16 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-xl font-bold shrink-0">
                        {{ mb_substr($displayName, 0, 1) }}
                    </div>
                @endif

                <div class="space-y-1">
                    <h3 class="text-base font-bold text-gray-950 dark:text-white">
                        {{ $displayName }}
                    </h3>
                    <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400">
                        {{ $displayTitle }}
                    </p>
                    <span class="inline-flex items-center gap-1 text-[11px] text-gray-500 dark:text-gray-400">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $displayLocation }}
                    </span>
                </div>
            </div>

            <!-- Col 2: Contact & Social Info -->
            <div
                class="space-y-2 border-b md:border-b-0 md:border-e border-gray-100 dark:border-gray-800 pb-4 md:pb-0 md:pe-4">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Contact & Links') }}</h4>
                <div class="space-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <p class="flex items-center gap-2">
                        <span class="font-medium text-gray-400">{{ __('Email') }}:</span>
                        <span>{{ $profile?->email ?? 'N/A' }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-medium text-gray-400">{{ __('Phone') }}:</span>
                        <span dir="ltr">{{ $profile?->phone ?? 'N/A' }}</span>
                    </p>
                    @if ($profile?->github_url)
                        <p class="flex items-center gap-2">
                            <span class="font-medium text-gray-400">GitHub:</span>
                            <a href="{{ $profile->github_url }}" target="_blank"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline truncate max-w-[180px]">{{ $profile->github_url }}</a>
                        </p>
                    @endif
                    @if ($profile?->linkedin_url)
                        <p class="flex items-center gap-2">
                            <span class="font-medium text-gray-400">LinkedIn:</span>
                            <a href="{{ $profile->linkedin_url }}" target="_blank"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline truncate max-w-[180px]">{{ $profile->linkedin_url }}</a>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Col 3: Bio & CV Status -->
            <div class="space-y-2">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Bio & CV Link') }}</h4>
                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">
                    {{ $displayBio }}
                </p>
                <div class="pt-1">
                    @if ($profile?->cv_url)
                        <a href="{{ $profile->cv_url }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 px-2.5 py-1 rounded-md hover:bg-emerald-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5h6m0 0v6m0-6-9 9M5 7v12h12v-5"></path>
                            </svg>
                            <span>{{ __('Open CV') }}</span>
                        </a>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 px-2.5 py-1 rounded-md">
                            <span>{{ __('No CV Link') }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
