<x-filament::page>
    <div class="mx-auto w-full max-w-5xl space-y-6">
        {{-- Profile Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Profile Information
                </h3>
            </x-slot>
            
            <x-slot name="description">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Update your account's profile information and photo.
                </p>
            </x-slot>

            <form wire:submit.prevent="saveProfile" class="space-y-6">
                {{-- Name Field --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Full Name
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="text" 
                            wire:model.defer="name" 
                            required 
                            placeholder="Enter your full name"
                        />
                    </x-filament::input.wrapper>
                    @error('name')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="email" 
                            wire:model.defer="email" 
                            required 
                            placeholder="your@email.com"
                        />
                    </x-filament::input.wrapper>
                    @error('email')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- User ID (Read-only) --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        User ID
                    </label>
                    <x-filament::input.wrapper class="bg-gray-50 dark:bg-gray-800">
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                {{ auth()->id() }}
                            </span>
                            <x-filament::icon 
                                icon="heroicon-o-clipboard-document" 
                                class="h-4 w-4 cursor-pointer text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400"
                                x-data
                                x-on:click="navigator.clipboard.writeText('{{ auth()->id() }}')"
                                x-tooltip="'Copy to clipboard'"
                            />
                        </div>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Your unique identifier. This cannot be changed.
                    </p>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end border-t border-gray-200 pt-6 dark:border-gray-700">
                    <x-filament::button 
                        type="submit" 
                        color="primary"
                        icon="heroicon-o-check-circle"
                        icon-position="after"
                        class="px-6 py-2.5"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="saveProfile">
                            Save Changes
                        </span>
                        <span wire:loading wire:target="saveProfile" class="flex items-center gap-2">
                            <x-filament::loading-indicator class="h-4 w-4" />
                            Saving...
                        </span>
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Change Password Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Update Password
                </h3>
            </x-slot>
            
            <x-slot name="description">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </x-slot>

            <form wire:submit.prevent="savePassword" class="space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Current Password
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="password" 
                            wire:model.defer="current_password" 
                            required 
                            placeholder="Enter your current password"
                        />
                    </x-filament::input.wrapper>
                    @error('current_password')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        New Password
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="password" 
                            wire:model.defer="password" 
                            required 
                            placeholder="Enter new password"
                        />
                    </x-filament::input.wrapper>
                    @error('password')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirm New Password
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="password" 
                            wire:model.defer="password_confirmation" 
                            required 
                            placeholder="Confirm new password"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                    <div class="flex items-start gap-2">
                        <x-filament::icon icon="heroicon-o-key" class="mt-0.5 h-4 w-4 text-gray-500" />
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                Password requirements:
                            </p>
                            <ul class="text-xs text-gray-600 dark:text-gray-400">
                                <li class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-o-check-circle" class="h-3 w-3 text-green-500" />
                                    At least 8 characters
                                </li>
                                <li class="flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-o-check-circle" class="h-3 w-3 text-green-500" />
                                    Mix of letters, numbers, and symbols
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-6 dark:border-gray-700">
                    <x-filament::button 
                        type="submit" 
                        color="primary"
                        icon="heroicon-o-lock-closed"
                        icon-position="after"
                        class="px-6 py-2.5"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="savePassword">
                            Update Password
                        </span>
                        <span wire:loading wire:target="savePassword" class="flex items-center gap-2">
                            <x-filament::loading-indicator class="h-4 w-4" />
                            Updating...
                        </span>
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Delete Account Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Delete Account
                </h3>
            </x-slot>
            
            <x-slot name="description">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Permanently delete your account and all associated data.
                </p>
            </x-slot>

            <form wire:submit.prevent="deleteAccount" class="space-y-4">
                <div class="rounded-lg border border-danger-200 bg-danger-50 p-4 dark:border-danger-800 dark:bg-danger-900/20">
                    <div class="flex items-start gap-3">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="mt-0.5 h-5 w-5 text-danger-600 dark:text-danger-400" />
                        <div>
                            <h4 class="text-sm font-semibold text-danger-700 dark:text-danger-300">
                                Warning: Irreversible Action
                            </h4>
                            <ul class="mt-2 space-y-1 text-xs text-danger-600 dark:text-danger-400">
                                <li class="flex items-start gap-1">
                                    <x-filament::icon icon="heroicon-o-x-circle" class="mt-0.5 h-3 w-3" />
                                    All your tickets and replies will be permanently deleted
                                </li>
                                <li class="flex items-start gap-1">
                                    <x-filament::icon icon="heroicon-o-x-circle" class="mt-0.5 h-3 w-3" />
                                    Your profile information will be removed
                                </li>
                                <li class="flex items-start gap-1">
                                    <x-filament::icon icon="heroicon-o-x-circle" class="mt-0.5 h-3 w-3" />
                                    This action cannot be undone
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Current Password
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="password" 
                            wire:model.defer="delete_password" 
                            required 
                            placeholder="Enter your password to confirm"
                        />
                    </x-filament::input.wrapper>
                    @error('delete_password')
                        <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end border-t border-gray-200 pt-6 dark:border-gray-700">
                    <x-filament::button 
                        type="submit" 
                        color="danger"
                        icon="heroicon-o-trash"
                        icon-position="after"
                        class="px-6 py-2.5"
                        wire:loading.attr="disabled"
                        x-data
                        x-on:click="if (!confirm('⚠️  Are you absolutely sure?\n\nThis will permanently delete your account and all associated data.\n\nThis action cannot be undone!')) $event.preventDefault()"
                    >
                        <span wire:loading.remove wire:target="deleteAccount">
                            Delete Account
                        </span>
                        <span wire:loading wire:target="deleteAccount" class="flex items-center gap-2">
                            <x-filament::loading-indicator class="h-4 w-4" />
                            Deleting...
                        </span>
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>
    </div>
</x-filament::page>

@push('styles')
<style>
    /* Fix for Filament avatar display */
    .fi-topbar-user-avatar img,
    .fi-user-avatar img,
    .fi-ta-avatar img,
    [class*="fi-avatar"] img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 9999px !important;
    }
    
    /* Custom styling for better visual feedback */
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide success messages after 5 seconds
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('profile-updated', () => {
            setTimeout(() => {
                const notices = document.querySelectorAll('[data-filament-notification]');
                notices.forEach(notice => {
                    if (notice.textContent.includes('success') || notice.textContent.includes('Success')) {
                        notice.style.opacity = '0';
                        setTimeout(() => notice.remove(), 300);
                    }
                });
            }, 5000);
        });
    });
</script>
@endpush
