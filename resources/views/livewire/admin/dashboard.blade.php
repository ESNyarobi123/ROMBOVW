<!-- Using tailwind classes initialized in layout -->
<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Stat Card 1 -->
        <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg hover:border-mobilex-accent/50 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-mobilex-accent/10 rounded-full blur-xl group-hover:bg-mobilex-accent/20 transition-colors"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <h3 class="text-xs font-black text-mobilex-primary uppercase tracking-widest">Mapato (Leo)</h3>
                    <p class="text-3xl font-black text-mobilex-white mt-2 drop-shadow-md">TSh {{ number_format($stats['revenue_today']) }}</p>
                </div>
                <div class="p-3 bg-mobilex-accent/10 border border-mobilex-accent/20 rounded-xl text-mobilex-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg hover:border-mobilex-accent/50 transition-all duration-300 relative overflow-hidden group">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <h3 class="text-xs font-black text-mobilex-primary uppercase tracking-widest">Wapo Mtandaoni</h3>
                    <div class="flex items-center gap-3 mt-2">
                        <p class="text-3xl font-black text-mobilex-white">{{ $stats['active_users'] }}</p>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mobilex-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-mobilex-accent shadow-[0_0_8px_rgba(57,255,20,0.8)]"></span>
                        </span>
                    </div>
                </div>
                <div class="p-3 bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg hover:border-mobilex-accent/50 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xs font-black text-mobilex-primary uppercase tracking-widest">Jumla ya Vouchers</h3>
                    <p class="text-3xl font-black text-mobilex-white mt-2">{{ $stats['total_vouchers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg hover:border-mobilex-accent/50 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xs font-black text-mobilex-textSoft uppercase tracking-widest">Zilizoisha Leo</h3>
                    <p class="text-3xl font-black text-zinc-400 mt-2">{{ $stats['expired_today'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Area -->
        <div class="lg:col-span-2 bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg">
            <h3 class="text-sm font-black text-mobilex-white uppercase tracking-widest mb-6">Mapato Siku 7 Zilizopita</h3>
            
            <div class="relative h-64 w-full flex items-end justify-between space-x-2 pt-6 pb-2 px-2 border-l border-b border-mobilex-border">
                @foreach($chartHeights as $index => $height)
                    <div class="relative w-full group flex justify-center h-full items-end">
                        <div class="w-full max-w-[40px] bg-mobilex-bg border border-mobilex-accent group-hover:bg-mobilex-accent rounded-t-sm transition-all duration-300 relative shadow-[0_0_10px_rgba(57,255,20,0.1)] group-hover:shadow-[0_0_20px_rgba(57,255,20,0.6)]" style="height: {{ max($height, 5) }}%">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-mobilex-bg border border-mobilex-accent text-mobilex-accent font-bold text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                Tsh{{ number_format($chartData[$index]) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between w-full mt-3 text-[10px] font-bold text-mobilex-textSoft uppercase tracking-widest px-4">
                @foreach($chartLabels as $label)
                    <span>{{ $label }}</span>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity Logs / Connected -->
        <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl p-6 shadow-lg flex flex-col">
            <h3 class="text-sm font-black text-mobilex-white uppercase tracking-widest mb-6 border-b border-mobilex-border pb-3">Wanaotumia Intaneti Sasa</h3>
            
            <div class="flex-1 overflow-auto space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-mobilex-bg border border-mobilex-border hover:border-mobilex-accent/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-mobilex-accent/20 flex items-center justify-center text-mobilex-accent border border-mobilex-accent/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-mobilex-white tracking-widest">{{ $user['user'] ?? 'Mteja' }}</p>
                                <p class="text-[9px] font-black text-black bg-mobilex-accent px-1.5 py-0.5 rounded-sm inline-block mt-1 uppercase tracking-wider">Active</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-[10px] font-black tracking-widest uppercase text-mobilex-textSoft/50 text-center py-4">
                        Hakuna mtu mtandaoni kwasasa.
                    </div>
                @endforelse
            </div>

            <a wire:navigate href="{{ route('admin.live-users') }}" class="w-full mt-4 py-3 text-center text-xs font-black bg-transparent border-2 border-mobilex-accent text-mobilex-accent hover:bg-mobilex-accent hover:text-black rounded-xl transition-all uppercase tracking-widest shadow-[inset_0_0_10px_rgba(57,255,20,0.2)] hover:shadow-[0_0_15px_rgba(57,255,20,0.6)]">
                Tazama Wote (Live)
            </a>
        </div>
    </div>
</div>
