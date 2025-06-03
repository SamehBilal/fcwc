<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $phone_number = '';
    public string $country_code = '+20';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        if($this->phone != '')
        {
            $this->phone_number = preg_replace('/^\+20/', '', $this->phone);
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $this->phone = $this->country_code . $this->phone_number;
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', Rule::unique(User::class)->ignore($user->id)],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone -->
            <flux:input.group :label="__('Phone')">
                <flux:select wire:model="country_code" class="max-w-fit">
                    <!-- Arabic Countries -->
                    <flux:select.option value="+20">Egypt (+20)</flux:select.option>
                    <flux:select.option value="+213">Algeria (+213)</flux:select.option>
                    <flux:select.option value="+973">Bahrain (+973)</flux:select.option>
                    <flux:select.option value="+269">Comoros (+269)</flux:select.option>
                    <flux:select.option value="+253">Djibouti (+253)</flux:select.option>
                    <flux:select.option value="+964">Iraq (+964)</flux:select.option>
                    <flux:select.option value="+962">Jordan (+962)</flux:select.option>
                    <flux:select.option value="+965">Kuwait (+965)</flux:select.option>
                    <flux:select.option value="+961">Lebanon (+961)</flux:select.option>
                    <flux:select.option value="+218">Libya (+218)</flux:select.option>
                    <flux:select.option value="+222">Mauritania (+222)</flux:select.option>
                    <flux:select.option value="+212">Morocco (+212)</flux:select.option>
                    <flux:select.option value="+968">Oman (+968)</flux:select.option>
                    <flux:select.option value="+970">Palestine (+970)</flux:select.option>
                    <flux:select.option value="+974">Qatar (+974)</flux:select.option>
                    <flux:select.option value="+966">Saudi Arabia (+966)</flux:select.option>
                    <flux:select.option value="+249">Sudan (+249)</flux:select.option>
                    <flux:select.option value="+963">Syria (+963)</flux:select.option>
                    <flux:select.option value="+216">Tunisia (+216)</flux:select.option>
                    <flux:select.option value="+971">UAE (+971)</flux:select.option>
                    <flux:select.option value="+967">Yemen (+967)</flux:select.option>
                    <flux:select.option value="+1">US (+1)</flux:select.option>
                    <flux:select.option value="+44">UK (+44)</flux:select.option>
                    <flux:select.option value="+7">Russia (+7)</flux:select.option>
                    <flux:select.option value="+27">South Africa (+27)</flux:select.option>
                    <flux:select.option value="+33">France (+33)</flux:select.option>
                    <flux:select.option value="+34">Spain (+34)</flux:select.option>
                    <flux:select.option value="+39">Italy (+39)</flux:select.option>
                    <flux:select.option value="+49">Germany (+49)</flux:select.option>
                    <flux:select.option value="+52">Mexico (+52)</flux:select.option>
                    <flux:select.option value="+55">Brazil (+55)</flux:select.option>
                    <flux:select.option value="+61">Australia (+61)</flux:select.option>
                    <flux:select.option value="+81">Japan (+81)</flux:select.option>
                    <flux:select.option value="+86">China (+86)</flux:select.option>
                    <flux:select.option value="+91">India (+91)</flux:select.option>
                </flux:select>

                <flux:input wire:model="phone_number" type="tel" required placeholder="Enter phone number" />

            </flux:input.group>
            <flux:error name="phone_number" class="text-red-600 mt-1 text-sm" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full cursor-pointer">{{ __('Save') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
