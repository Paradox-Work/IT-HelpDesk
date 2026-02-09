<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Profile extends Page
{
    use WithFileUploads;

    protected string $view = 'filament.pages.profile';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Account';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $delete_password = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
    }

    public static function getLabel(): string
    {
        return 'Account';
    }

    public function saveProfile(): void
    {
        $user = auth()->user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        Notification::make()
            ->title('Profile updated')
            ->success()
            ->send();
    }

    public function savePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        Notification::make()
            ->title('Password updated')
            ->success()
            ->send();
    }

    public function deleteAccount(): void
    {
        $this->validate([
            'delete_password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();
        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        redirect('/')->send();
    }

}
