<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-2xl font-black uppercase tracking-widest text-mobilex-white mb-6 text-center border-b border-mobilex-border pb-4">Karibu Ndani</h2>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-mobilex-accent text-[10px] font-black uppercase tracking-widest" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-primary mb-2">Barua Pepe (Email)</label>
            <div class="relative group">
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" 
                    class="block w-full rounded-2xl border-2 border-mobilex-border bg-mobilex-bg text-mobilex-white font-black tracking-widest h-14 px-4 focus:ring-0 focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.8)] transition-all">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-[10px] font-black tracking-widest uppercase text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-primary mb-2">Neno La Siri</label>
            <div class="relative group">
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full rounded-2xl border-2 border-mobilex-border bg-mobilex-bg text-mobilex-accent font-black tracking-widest h-14 px-4 focus:ring-0 focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.8)] transition-all">
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-[10px] font-black tracking-widest uppercase text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-sm bg-mobilex-bg border-mobilex-border text-mobilex-accent focus:ring-mobilex-accent focus:ring-offset-mobilex-panel shadow-[inset_0_1px_3px_rgba(0,0,0,0.6)]" name="remember">
                <span class="ms-3 text-[10px] font-black uppercase tracking-widest text-mobilex-textSoft">{{ __('Kumbuka Kifaa Hiki') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8 pt-4 border-t border-mobilex-border">
            @if (Route::has('password.request'))
                <a class="text-[9px] font-black uppercase tracking-widest text-mobilex-textSoft hover:text-mobilex-accent transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Umesahau Nenosiri?') }}
                </a>
            @endif

            <button type="submit" class="flex justify-center items-center py-3 px-8 rounded-xl shadow-[0_0_15px_rgba(57,255,20,0.3)] hover:shadow-[0_0_25px_rgba(57,255,20,0.6)] text-xs tracking-[0.2em] uppercase font-black text-black bg-mobilex-accent hover:bg-mobilex-accentHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-panel focus:ring-mobilex-accent transition-all transform hover:-translate-y-1 active:scale-95">
                {{ __('Ingia') }}
                <svg class="ml-2 w-4 h-4 ml-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>
</div>
