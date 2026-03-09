<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-mobilex-panel border-r border-mobilex-border transition-transform duration-300 md:translate-x-0 -translate-x-full h-screen flex flex-col">
    <!-- Branding Header -->
    <div class="h-16 flex items-center px-6 border-b border-mobilex-border bg-mobilex-bg relative overflow-hidden">
        <div class="absolute -left-4 -bottom-4 w-12 h-12 bg-mobilex-accent/30 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-center gap-3 relative z-10">
            <!-- MobileX Styled Logo 'X' representation -->
            <div class="w-8 h-8 rounded-lg bg-mobilex-accent font-black text-black flex items-center justify-center text-xl shadow-[0_0_15px_rgba(57,255,20,0.5)]">
                X
            </div>
            <span class="font-black text-mobilex-white tracking-widest uppercase text-sm">Rombo WiFi</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        
        <div class="px-3 text-[10px] font-black text-mobilex-primary opacity-60 uppercase tracking-[0.2em] mb-3">General</div>
        <a wire:navigate href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        
        <a wire:navigate href="{{ route('admin.live-users') }}" class="{{ request()->routeIs('admin.live-users') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.live-users') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Live Monitor
            <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-black tracking-widest rounded-full bg-mobilex-accent text-black uppercase shadow-[0_0_10px_rgba(57,255,20,0.5)]">Live</span>
        </a>

        <div class="px-3 text-[10px] font-black text-mobilex-primary opacity-60 uppercase tracking-[0.2em] mb-3 mt-8">Management</div>
        <a wire:navigate href="{{ route('admin.packages') }}" class="{{ request()->routeIs('admin.packages') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.packages') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Packages
        </a>
        <a wire:navigate href="{{ route('admin.vouchers') }}" class="{{ request()->routeIs('admin.vouchers') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.vouchers') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            Vouchers
        </a>
        <a wire:navigate href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.payments') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Payments
        </a>
        <a wire:navigate href="{{ route('admin.routers') }}" class="{{ request()->routeIs('admin.routers') ? 'bg-mobilex-panelHover border-l-4 border-mobilex-accent text-mobilex-white' : 'text-mobilex-textSoft hover:bg-mobilex-panelHover hover:text-mobilex-white border-l-4 border-transparent' }} flex items-center px-3 py-2 text-sm font-bold rounded-r-lg transition-all">
            <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.routers') ? 'text-mobilex-accent' : 'opacity-70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Settings
        </a>
    </div>

    <!-- User Log Out -->
    <div class="p-4 border-t border-mobilex-border bg-mobilex-bg/50">
        <button wire:click="logout" class="flex w-full justify-center items-center px-3 py-3 text-sm font-black text-white hover:text-black border border-mobilex-border hover:bg-mobilex-accent hover:border-mobilex-accent rounded-xl transition-all uppercase tracking-widest shadow-[0_0_0_rgba(57,255,20,0)] hover:shadow-[0_0_15px_rgba(57,255,20,0.5)]">
            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </button>
    </div>
</aside>
