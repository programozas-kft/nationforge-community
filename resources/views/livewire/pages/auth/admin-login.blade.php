<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.admin-guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        if (!auth()->user()->isAdmin()) {
            auth()->logout();
            $this->addError('form.email', 'Nincs jogosultsága az admin felülethez.');
            return;
        }

        Session::regenerate();

        $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Jelszó -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div x-data="{ show: false }" style="position:relative; margin-top:0.25rem;">
                <x-text-input wire:model="form.password"
                              id="password"
                              class="block w-full"
                              style="padding-right:2.5rem;"
                              x-bind:type="show ? 'text' : 'password'"
                              name="password"
                              required
                              autocomplete="current-password" />
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        style="position:absolute; top:50%; right:8px; transform:translateY(-50%); background:none; border:none; padding:0; cursor:pointer; line-height:0; color:#9ca3af;">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Emlékezz rám -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-5 pt-4 border-t border-gray-200 text-center">
        <a href="{{ route('public.changelog') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            {{ __('changelog.title') }}
        </a>
    </div>

    @if(env('DEMO_USER_EMAIL'))
    <div class="mt-4 pt-4 border-t border-gray-200">
        <a href="{{ route('demo.login') }}"
           class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-lg transition-colors"
           style="background-color: #16a34a;"
           onmouseover="this.style.backgroundColor='#15803d'"
           onmouseout="this.style.backgroundColor='#16a34a'">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Demó belépés
        </a>
    </div>
    @endif
</div>
