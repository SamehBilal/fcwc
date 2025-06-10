<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public $phone = '';
    public string $phone_number = '';
    public string $country_code = '+20';

    public function mount()
    {
        $this->phone = Auth::user()->phone;
    }

    function normalizeEgyptianPhone($text)
    {
        return preg_replace('/(\+20)0/', '$1', $text);
    }

    /**
     * Handle an incoming registration request.
     */
    public function completeProfile(): void
    {
        $this->phone = $this->country_code . $this->phone_number;

        $validated = $this->validate([
            'phone' => ['required', 'max:255', 'unique:' . User::class],
        ]);

        if (empty($this->phone_number)) {
            $this->addError('phone_number', 'Phone number is required.');
            return;
        }

        $user = Auth::user();
        $user->phone = $this->normalizeEgyptianPhone($this->phone);
        $user->save();

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
    <x-auth-header :title="__('Update Phone Number')" :description="__('')" />

    <flux:separator text="One More Step" />
    <div class="flex flex-col gap-6">
        {{-- <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" /> --}}

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="completeProfile" class="flex flex-col gap-6">

            <!-- Phone -->
            <flux:input.group :label="__('Phone')">
                <flux:select wire:model="country_code" class="max-w-fit">
                    <!-- Arabic Countries -->
                    <flux:select.option value="+20">Egypt (+20)</flux:select.option>
                </flux:select>

                <flux:input wire:model="phone_number" type="tel" required placeholder="Enter phone number" />

            </flux:input.group>
            <flux:error name="phone" class="text-red-600 mt-1 text-sm" />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                    {{ __('Update') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
