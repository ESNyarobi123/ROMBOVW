<?php

use Livewire\Volt\Component;
use App\Models\Package;
use Illuminate\Support\Collection;

new class extends Component {
    public Collection $packages;

    public function mount()
    {
        // Load all active packages from DB
        $this->packages = Package::all();
    }

    public function selectPackage($packageId)
    {
        return redirect()->route('hotspot.payment', ['package_id' => $packageId]);
    }
};
?>

<div class="max-w-md mx-auto p-6 bg-mobilex-panel rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-mobilex-border relative overflow-hidden z-10 w-full">
    <!-- internal glow -->
    <div class="absolute -top-32 -right-32 w-64 h-64 bg-mobilex-accent/10 rounded-full blur-[80px] pointer-events-none"></div>

    <!-- Header with MobileX Inspired Branding -->
    <div class="text-center mb-10 relative z-10">
        <div class="mx-auto w-20 h-20 rounded-2xl bg-mobilex-bg border-4 border-mobilex-accent flex items-center justify-center text-4xl font-black text-mobilex-accent mb-6 shadow-[0_0_20px_rgba(57,255,20,0.5)] transform -rotate-3 hover:rotate-0 transition-transform duration-300">
            X
        </div>
        <h1 class="text-3xl font-black uppercase tracking-widest text-mobilex-white mb-2 leading-tight">MOBILEX<br/><span class="text-mobilex-primary opacity-80 text-xl">WIFI PORTAL</span></h1>
        <p class="text-mobilex-textSoft/80 font-bold text-[10px] tracking-[0.2em] uppercase">Chagua kifurushi, unganishwa spidi ya radi.</p>
    </div>

    <!-- Package List -->
    <div class="space-y-4 relative z-10">
        @foreach($packages as $package)
            <div wire:click="selectPackage({{ $package->id }})" class="cursor-pointer group relative bg-mobilex-bg border-2 border-mobilex-border hover:border-mobilex-accent rounded-2xl p-5 transition-all duration-300 flex items-center justify-between overflow-hidden shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] hover:shadow-[0_0_25px_rgba(57,255,20,0.3)] transform hover:-translate-y-1">
                <!-- Hover scanline effect -->
                <div class="absolute inset-x-0 -bottom-full h-full bg-gradient-to-t from-mobilex-accent/10 to-transparent group-hover:bottom-0 transition-all duration-500 ease-out z-0"></div>
                
                <div class="relative z-10">
                    <h3 class="font-black text-lg uppercase tracking-widest text-mobilex-white group-hover:text-mobilex-accent drop-shadow-md transition-colors">{{ $package->name }}</h3>
                    <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-mobilex-textSoft flex items-center gap-1 mt-1 opacity-80">
                        <svg class="w-3 h-3 text-mobilex-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        MUDA: {{ $package->time_limit < 60 ? $package->time_limit . ' MINS' : ($package->time_limit / 60) . ' HR' . ($package->time_limit >= 1440 ? 'S' : '') }}
                    </p>
                </div>
                
                <div class="text-right relative z-10">
                    <div class="text-xl font-black text-mobilex-accent tracking-widest drop-shadow-[0_0_5px_rgba(57,255,20,0.5)]">TZS {{ number_format($package->price) }}</div>
                    <button class="mt-2 text-[9px] uppercase tracking-widest font-black bg-mobilex-primary/10 text-mobilex-primary group-hover:bg-mobilex-accent group-hover:text-black border border-mobilex-primary/30 group-hover:border-mobilex-accent px-4 py-2 rounded-lg transition-all shadow-sm">
                        CHAGUA
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 text-center text-[9px] font-black tracking-[0.3em] uppercase text-mobilex-textSoft/40 relative z-10">
        &copy; {{ date('Y') }} MOBILEX WIFI HOTSPOT
    </div>
</div>