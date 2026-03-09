<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-black uppercase tracking-widest text-mobilex-white">Vouchers (Namba za Siri)</h2>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-mobilex-textSoft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tafuta Voucher, MAC, au Simu..." class="pl-10 block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-white focus:ring-2 focus:ring-mobilex-accent focus:border-mobilex-accent sm:text-sm h-10 transition-shadow">
            </div>
            
            <button wire:click="generateBulk" class="flex items-center justify-center px-4 py-2 bg-mobilex-accent hover:bg-mobilex-accentHover text-black font-black uppercase text-xs tracking-widest rounded-xl transition-all shadow-[0_0_10px_rgba(57,255,20,0.4)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-bg focus:ring-mobilex-accent">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Tengeneza / Print PDF
            </button>
        </div>
    </div>

    <!-- Stats summary specific to vouchers -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <div class="bg-mobilex-panel rounded-xl p-4 border border-mobilex-border flex justify-between items-center shadow-lg">
            <span class="text-[10px] text-mobilex-primary font-black uppercase tracking-[0.2em]">Active Sasa</span>
            <span class="text-2xl font-black text-mobilex-accent">{{ number_format($stats['active']) }}</span>
        </div>
        <div class="bg-mobilex-panel rounded-xl p-4 border border-mobilex-border flex justify-between items-center shadow-lg">
            <span class="text-[10px] text-mobilex-textSoft font-black uppercase tracking-[0.2em]">Hazijatumika / Pen.</span>
            <span class="text-2xl font-black text-mobilex-white">{{ number_format($stats['pending']) }}</span>
        </div>
        <div class="bg-mobilex-panel rounded-xl p-4 border border-mobilex-border flex justify-between items-center shadow-lg">
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-red-500/80">Zilizoisha (Expired)</span>
            <span class="text-2xl font-black text-red-500">{{ number_format($stats['expired']) }}</span>
        </div>
    </div>

    <!-- Table content -->
    <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-mobilex-bg/50 border-b border-mobilex-border uppercase tracking-widest text-[10px] font-black text-mobilex-textSoft">
                    <tr>
                        <th scope="col" class="px-6 py-4">Code</th>
                        <th scope="col" class="px-6 py-4">Kifurushi</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Phone / MAC</th>
                        <th scope="col" class="px-6 py-4 text-center">Inaisha Muda?</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mobilex-border">
                    @forelse ($vouchers as $voucher)
                        <tr class="hover:bg-mobilex-panelHover transition-colors">
                            <td class="px-6 py-4 font-black text-mobilex-white tracking-[0.2em] text-lg">{{ $voucher->code }}</td>
                            <td class="px-6 py-4 text-mobilex-primary text-xs font-bold uppercase tracking-wider">{{ $voucher->package->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                @if($voucher->status === 'active')
                                    <span class="bg-mobilex-accent text-black text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest">ACTIVE</span>
                                @elseif($voucher->status === 'pending')
                                    <span class="bg-mobilex-bg text-mobilex-white border border-mobilex-border text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest">PENDING</span>
                                @else
                                    <span class="bg-red-900/40 text-red-400 border border-red-900/50 text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest">EXPIRED</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-mobilex-textSoft tracking-wider">
                                <div>{{ $voucher->phone ?? 'HAKUNA' }}</div>
                                <div class="mt-1 text-[10px] text-mobilex-border tracking-[0.1em]">{{ $voucher->mac_address ?? 'MAC: NOT BOUND' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-mobilex-white text-xs font-bold uppercase">
                                {{ $voucher->expires_at ? $voucher->expires_at->diffForHumans() : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-mobilex-textSoft/40">Hakuna Voucher Zinazolingana.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($vouchers, 'hasPages') && $vouchers->hasPages())
            <div class="px-6 py-4 border-t border-mobilex-border bg-mobilex-bg/50">
                {{ $vouchers->links() }}
            </div>
        @endif
    </div>
</div>
