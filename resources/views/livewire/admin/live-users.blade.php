<div wire:poll.10s="loadUsers">
    <div class="bg-mobilex-panel border border-mobilex-accent/30 rounded-2xl overflow-hidden shadow-[0_0_20px_rgba(57,255,20,0.1)] relative pt-4">
        <!-- Live status indicator -->
        <div class="absolute top-4 right-6 flex items-center gap-2">
            <span class="flex h-2.5 w-2.5 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mobilex-accent opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-mobilex-accent shadow-[0_0_8px_rgba(57,255,20,0.8)]"></span>
            </span>
            <span class="text-[10px] font-black text-mobilex-accent uppercase tracking-[0.2em]">Live Sync</span>
        </div>

        <div class="px-6 py-4 flex items-center gap-4 border-b border-mobilex-border">
            <svg class="w-10 h-10 text-mobilex-accent drop-shadow-[0_0_5px_rgba(57,255,20,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <div>
                <h3 class="text-2xl font-black uppercase tracking-widest text-mobilex-white">{{ count($activeUsers) }} Watu Mtandaoni</h3>
                <p class="text-[10px] font-bold tracking-widest uppercase text-mobilex-textSoft/50 mt-1">Data inajirudia (ping) kila sec 10</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-mobilex-bg/50 border-b border-mobilex-border uppercase tracking-widest text-[10px] font-black text-mobilex-textSoft">
                    <tr>
                        <th scope="col" class="px-6 py-4">Voucher</th>
                        <th scope="col" class="px-6 py-4">IP Address</th>
                        <th scope="col" class="px-6 py-4">MAC Address</th>
                        <th scope="col" class="px-6 py-4 text-center">Uptime</th>
                        <th scope="col" class="px-6 py-4 text-right">Kitendo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mobilex-border">
                    @forelse ($activeUsers as $user)
                        <tr class="hover:bg-mobilex-panelHover transition-colors">
                            <td class="px-6 py-4 font-black text-mobilex-accent tracking-[0.2em] text-lg">{{ $user['user'] }}</td>
                            <td class="px-6 py-4 text-mobilex-white font-bold text-xs tracking-widest">{{ $user['address'] }}</td>
                            <td class="px-6 py-4 text-mobilex-textSoft font-bold text-[10px] tracking-[0.2em]">{{ $user['mac-address'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-mobilex-bg border border-mobilex-accent/50 text-mobilex-accent text-[10px] rounded-sm px-2 py-1 font-black uppercase tracking-widest shadow-[0_0_10px_rgba(57,255,20,0.1)]">
                                    {{ $user['uptime'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right border-l border-mobilex-border">
                                <button wire:click="forceDisconnect('{{ $user['user'] }}')" class="inline-flex items-center text-black font-black uppercase tracking-widest text-[9px] bg-red-500 px-3 py-1.5 rounded hover:bg-red-400 transition-colors shadow-[0_0_10px_rgba(239,68,68,0.5)]" wire:confirm="Katia huyu mtumiaji sasa hivi?">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    FORCE CUT
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-mobilex-textSoft bg-mobilex-bg/50">
                                <svg class="w-12 h-12 mx-auto text-mobilex-border mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs font-black uppercase tracking-widest">Hakuna watumiaji mtandaoni</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
