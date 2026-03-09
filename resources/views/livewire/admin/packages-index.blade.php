<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-black uppercase tracking-widest text-mobilex-white">Mfumo wa Vifurushi (Packages)</h2>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-mobilex-textSoft" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tafuta kifurushi..." class="pl-10 block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-white sm:text-sm h-10 transition-shadow focus:ring-2 focus:ring-mobilex-accent focus:border-mobilex-accent">
            </div>
            
            <button wire:click="create" class="flex items-center justify-center px-4 py-2 bg-mobilex-accent hover:bg-mobilex-accentHover text-black font-black uppercase text-xs tracking-widest rounded-xl transition-all shadow-[0_0_10px_rgba(57,255,20,0.4)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-bg focus:ring-mobilex-accent">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ongeza Kifurushi
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-mobilex-panel border border-mobilex-border rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-mobilex-bg/50 border-b border-mobilex-border uppercase tracking-widest text-[10px] font-black text-mobilex-textSoft">
                    <tr>
                        <th scope="col" class="px-6 py-4">Jina</th>
                        <th scope="col" class="px-6 py-4 text-right">Bei (TZS)</th>
                        <th scope="col" class="px-6 py-4 text-center">Muda</th>
                        <th scope="col" class="px-6 py-4 text-center">Data Lmt</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mobilex-border">
                    @forelse ($packages as $pkg)
                        <tr class="hover:bg-mobilex-panelHover transition-colors">
                            <td class="px-6 py-4 font-black uppercase tracking-widest text-mobilex-white">{{ $pkg->name }}</td>
                            <td class="px-6 py-4 text-right font-black tracking-widest text-mobilex-accent drop-shadow-[0_0_4px_rgba(57,255,20,0.6)]">{{ number_format($pkg->price) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-mobilex-primary/20 text-mobilex-primary border border-mobilex-primary/30 text-[10px] uppercase font-black px-2.5 py-1 rounded-sm tracking-widest">
                                    {{ $pkg->time_limit < 60 ? $pkg->time_limit . ' Min' : head(explode('.', $pkg->time_limit / 60)) . ' Hr' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-mobilex-textSoft/70">
                                {{ $pkg->bytes_limit ? round($pkg->bytes_limit / 1048576) . ' MB' : 'UNLIMITED' }}
                            </td>
                            <td class="px-6 py-4 text-right border-l border-mobilex-border/50">
                                <button wire:click="edit({{ $pkg->id }})" class="text-mobilex-textSoft hover:text-mobilex-primary mx-2 transition-colors">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="delete({{ $pkg->id }})" class="text-mobilex-textSoft hover:text-red-500 transition-colors" wire:confirm="Una uhakika unataka kufuta hiki kifurushi?">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-mobilex-textSoft bg-mobilex-bg/50 uppercase tracking-widest font-bold text-[10px]">
                                Hakuna vifurushi vilivyopatikana. Gusa 'Ongeza Kifurushi' kuanza.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-mobilex-border bg-mobilex-bg/50">
            {{ $packages->links() }}
        </div>
    </div>

    <!-- Form Modal matching MobileX aesthetic -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-mobilex-panel rounded-2xl text-left overflow-hidden shadow-[0_0_30px_rgba(57,255,20,0.15)] border border-mobilex-accent/30 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form wire:submit="save">
                        <div class="bg-mobilex-panel px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                            <!-- Glow internal -->
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-mobilex-accent/10 rounded-full blur-2xl pointer-events-none"></div>
                            
                            <h3 class="text-lg leading-6 font-black tracking-widest uppercase text-mobilex-white mb-6 border-b border-mobilex-border pb-3" id="modal-title">
                                {{ $packageId ? 'Badilisha Kifurushi' : 'Ongeza Kifurushi Kipya' }}
                            </h3>
                            <div class="mt-4 space-y-5 relative z-10">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-primary mb-2">Jina La Kifurushi</label>
                                    <input wire:model="name" type="text" class="block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-accent font-bold tracking-widest uppercase sm:text-sm h-12 px-4 focus:ring-mobilex-accent focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]">
                                    @error('name') <span class="text-[10px] font-bold text-red-400 uppercase">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-primary mb-2">Bei (TZS)</label>
                                        <input wire:model="price" type="number" step="0.01" class="block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-white font-mono font-bold sm:text-sm h-12 px-4 focus:ring-mobilex-accent focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]">
                                        @error('price') <span class="text-[10px] font-bold text-red-400 uppercase">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-primary mb-2">Muda (Dk)</label>
                                        <input wire:model="time_limit" type="number" class="block w-full rounded-xl border-mobilex-border bg-mobilex-bg text-mobilex-white font-mono font-bold sm:text-sm h-12 px-4 focus:ring-mobilex-accent focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]">
                                        @error('time_limit') <span class="text-[10px] font-bold text-red-400 uppercase">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-mobilex-bg/80 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-mobilex-border backdrop-blur-md">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-[0_0_10px_rgba(57,255,20,0.3)] px-6 py-3 bg-mobilex-accent text-xs tracking-widest uppercase font-black text-black hover:bg-mobilex-accentHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-bg focus:ring-mobilex-accent sm:ml-3 sm:w-auto transition-all">
                                Hifadhi Sasa
                            </button>
                            <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-xl border border-mobilex-border shadow-sm px-6 py-3 bg-mobilex-panel text-xs tracking-widest uppercase font-black text-mobilex-textSoft hover:text-mobilex-white hover:bg-mobilex-panelHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-bg focus:ring-mobilex-border sm:mt-0 sm:ml-3 sm:w-auto transition-all">
                                Funga Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
