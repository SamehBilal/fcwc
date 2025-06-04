<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $phone = '';
    public string $phone_number = '';
    public string $country_code = '+20';
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->phone = $this->country_code . $this->phone_number;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if (empty($this->phone_number)) {
            $this->addError('phone_number', 'Phone number is required.');
            return;
        }

        $validated['password']  = Hash::make($validated['password']);
        $validated['phone']     =  $this->phone;

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-80 max-w-80 space-y-6">
    <div class="flex justify-center opacity-50">
        <a href="/" class="group flex items-center gap-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 text-zinc-800 dark:text-white" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M6.00014 11H10.0001M8.00014 9V13M15.0001 12H15.0101M18.0001 10H18.0101M10.4491 5H13.5512C16.1761 5 17.4885 5 18.5187 5.49743C19.4257 5.9354 20.1793 6.63709 20.6808 7.51059C21.2503 8.5027 21.3438 9.81181 21.5309 12.43L21.7769 15.8745C21.8975 17.5634 20.5599 19 18.8667 19C18.0008 19 17.1796 18.6154 16.6253 17.9502L16.2501 17.5C15.907 17.0882 15.7354 16.8823 15.54 16.7159C15.1305 16.3672 14.6346 16.1349 14.1045 16.0436C13.8516 16 13.5836 16 13.0476 16H10.9527C10.4167 16 10.1487 16 9.89577 16.0436C9.36563 16.1349 8.86981 16.3672 8.46024 16.7159C8.26487 16.8823 8.09329 17.0882 7.75013 17.5L7.37497 17.9502C6.82064 18.6154 5.99949 19 5.13359 19C3.44037 19 2.10275 17.5634 2.22339 15.8745L2.46942 12.43C2.65644 9.81181 2.74994 8.5027 3.31951 7.51059C3.82098 6.63709 4.57458 5.9354 5.48159 5.49743C6.51176 5 7.8242 5 10.4491 5Z"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <span class="text-xl font-semibold text-zinc-800 dark:text-white">AHW Gaming</span>
        </a>
    </div>
    <x-auth-header :title="__('Create an account')" :description="__('')" />
    {{-- <flux:heading class="text-center" size="xl">Welcome back</flux:heading> --}}
    <div class="space-y-4">
        <flux:button class="w-full cursor-pointer" {{-- variant="google" --}} {{-- wire:click="loginWithGoogle" --}}>
            <x-slot name="icon">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M23.06 12.25C23.06 11.47 22.99 10.72 22.86 10H12.5V14.26H18.42C18.16 15.63 17.38 16.79 16.21 17.57V20.34H19.78C21.86 18.42 23.06 15.6 23.06 12.25Z"
                        fill="#4285F4" />
                    <path
                        d="M12.4997 23C15.4697 23 17.9597 22.02 19.7797 20.34L16.2097 17.57C15.2297 18.23 13.9797 18.63 12.4997 18.63C9.63969 18.63 7.20969 16.7 6.33969 14.1H2.67969V16.94C4.48969 20.53 8.19969 23 12.4997 23Z"
                        fill="#34A853" />
                    <path
                        d="M6.34 14.0899C6.12 13.4299 5.99 12.7299 5.99 11.9999C5.99 11.2699 6.12 10.5699 6.34 9.90995V7.06995H2.68C1.93 8.54995 1.5 10.2199 1.5 11.9999C1.5 13.7799 1.93 15.4499 2.68 16.9299L5.53 14.7099L6.34 14.0899Z"
                        fill="#FBBC05" />
                    <path
                        d="M12.4997 5.38C14.1197 5.38 15.5597 5.94 16.7097 7.02L19.8597 3.87C17.9497 2.09 15.4697 1 12.4997 1C8.19969 1 4.48969 3.47 2.67969 7.07L6.33969 9.91C7.20969 7.31 9.63969 5.38 12.4997 5.38Z"
                        fill="#EA4335" />
                </svg>
            </x-slot>
            Continue with Google
        </flux:button>
    </div>
    <flux:separator text="or" />
<div class="flex flex-col gap-6">
    {{-- <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" /> --}}

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Phone -->
        <flux:input.group :label="__('Phone')">
            <flux:select wire:model="country_code" class="max-w-fit">
                <!-- Arabic Countries -->
                <flux:select.option value="+20">Egypt (+20)</flux:select.option>
            </flux:select>

            <flux:input wire:model="phone_number" type="tel" required placeholder="Enter phone number" />

        </flux:input.group>
        <flux:error name="phone_number" class="text-red-600 mt-1 text-sm" />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
</div>
