<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-black uppercase tracking-widest text-mobilex-white">Malipo (M-Pesa)</h2>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-mobilex-textSoft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tafuta Receipt au Simu..." class="pl-10 block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-white focus:ring-2 focus:ring-mobilex-accent focus:border-mobilex-accent sm:text-sm h-10 transition-shadow">
            </div>
            
            <button class="flex items-center justify-center px-4 py-2 bg-transparent border-2 border-mobilex-primary text-mobilex-primary hover:bg-mobilex-primary hover:text-black font-black uppercase text-xs tracking-widest rounded-xl transition-all shadow-[inset_0_0_10px_rgba(134,239,172,0.2)]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Excel
            </button>
        </div>
    </div>

    <!-- Table content -->
    <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-mobilex-bg/50 border-b border-mobilex-border uppercase tracking-widest text-[10px] font-black text-mobilex-textSoft">
                    <tr>
                        <th scope="col" class="px-6 py-4">Receipt</th>
                        <th scope="col" class="px-6 py-4 text-right">Kiasi</th>
                        <th scope="col" class="px-6 py-4">Namba Iliyolipa</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mobilex-border">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-mobilex-panelHover transition-colors">
                            <td class="px-6 py-4 font-black tracking-[0.2em] text-mobilex-white text-lg">{{ $payment->mpesa_receipt }}</td>
                            <td class="px-6 py-4 text-right text-mobilex-accent font-black tracking-widest drop-shadow-[0_0_4px_rgba(57,255,20,0.8)]">+ TSh {{ number_format($payment->amount) }}</td>
                            <td class="px-6 py-4 text-mobilex-primary font-bold text-xs tracking-[0.2em]">{{ $payment->phone }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status === 'completed')
                                    <span class="bg-mobilex-accent text-black text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest shadow-[0_0_8px_rgba(57,255,20,0.5)]">COMPLETED</span>
                                @elseif($payment->status === 'pending')
                                    <span class="bg-mobilex-bg text-mobilex-white border border-mobilex-border text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest">PENDING</span>
                                @else
                                    <span class="bg-red-900/40 text-red-400 border border-red-900/50 text-[10px] font-black px-2.5 py-1 rounded-sm uppercase tracking-widest">FAILED</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-mobilex-textSoft text-[10px] font-bold uppercase tracking-widest">
                                {{ $payment->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-mobilex-textSoft/40">Hakuna Historia ya Malipo.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($payments, 'hasPages') && $payments->hasPages())
            <div class="px-6 py-4 border-t border-mobilex-border bg-mobilex-bg/50">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
