<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $code;
    public $macAddress = null;

    public function mount($code)
    {
        $this->code = $code;
    }

    public function loginNow()
    {
        return redirect()->route('hotspot.status');
    }
};
?>

<div class="max-w-md mx-auto p-8 bg-mobilex-panel rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-mobilex-border text-center overflow-hidden relative z-10 w-full">
    
    <!-- Extreme success glow behind icon -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-mobilex-accent/30 rounded-full blur-[60px] pointer-events-none"></div>

    <div class="w-24 h-24 mx-auto bg-mobilex-bg border-4 border-mobilex-accent rounded-full flex items-center justify-center mb-8 shadow-[0_0_30px_rgba(57,255,20,0.6)] relative z-10">
        <svg class="w-12 h-12 text-mobilex-accent" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
    </div>

    <h2 class="text-3xl font-black uppercase tracking-widest text-mobilex-white mb-3 relative z-10">Hongera!</h2>
    <p class="text-mobilex-primary font-bold text-[10px] tracking-[0.2em] uppercase mb-10 opacity-80 relative z-10">Malipo yamethibitishwa.<br/>MobiLex WiFi yako iko tayari.</p>

    <!-- Voucher Code Box -->
    <div class="bg-mobilex-bg py-8 px-4 rounded-2xl border-2 border-dashed border-mobilex-accent/50 mb-8 relative shadow-[inset_0_0_20px_rgba(57,255,20,0.05)] z-10">
        <span class="uppercase tracking-[0.3em] text-[9px] font-black text-mobilex-accent absolute -top-3 left-1/2 -translate-x-1/2 bg-mobilex-panel px-4 py-1 rounded-sm border border-mobilex-border shadow-[0_0_10px_rgba(57,255,20,0.2)]">VOUCHER CODE YAKO</span>
        <div class="text-5xl font-black text-mobilex-white tracking-[0.1em] font-mono drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">{{ $code }}</div>
    </div>

    <!-- Instructions / Action Button -->
    <button wire:click="loginNow" class="w-full flex justify-center items-center py-4 px-4 rounded-xl shadow-[0_0_20px_rgba(57,255,20,0.4)] text-[11px] uppercase tracking-[0.2em] font-black text-black bg-mobilex-accent hover:bg-white focus:outline-none transition-all transform hover:-translate-y-1 active:scale-95 mb-4 relative z-10">
        <svg class="w-5 h-5 mr-3 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        INGIA MTANDAONI SASA HIVI
    </button>
    
    <button class="w-full flex justify-center items-center py-4 px-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-mobilex-white border-2 border-mobilex-border hover:border-mobilex-accent hover:text-mobilex-accent hover:bg-mobilex-bg transition-all relative z-10">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
        COPY CODE
    </button>

    <p class="text-[9px] font-black tracking-[0.2em] text-mobilex-textSoft/50 mt-8 relative z-10 uppercase">Tumekuhifadhia Copy Katika SMS.</p>
</div>