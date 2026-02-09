<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use BackedEnum;

class AdminAccess extends Page
{
    // MUST be static (matches parent)
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    // MUST be non-static (matches parent)
    protected string $view = 'filament.pages.admin-access';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        if (! Auth::check() || ! Auth::user()->is_admin) {
            abort(403, 'Admin access only.');
        }

        $this->redirect('/admin');
    }
}
