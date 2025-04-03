<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TryoutOnline extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tryout-online';

    public $packageId;

    public function mount($packageId)
    {
        $this->packageId = $packageId;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
