@php
    $isArabic = app()->getLocale() === 'ar';
    $targetLocale = $isArabic ? 'en' : 'ar';
    $label = $isArabic ? 'EN' : 'العربية';
@endphp

<a
    href="{{ route('locale.switch', ['locale' => $targetLocale]) }}"
    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-white/10 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/5"
    title="{{ $isArabic ? 'Switch to English' : 'التبديل إلى العربية' }}"
>
    <x-filament::icon
        icon="heroicon-m-language"
        class="h-4 w-4 text-primary-600 dark:text-primary-400"
    />
    <span>{{ $label }}</span>
</a>
