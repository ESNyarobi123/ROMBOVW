<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-black uppercase tracking-widest text-mobilex-white">Vifaa vya MikroTik (Routers)</h2>
        <button wire:click="create" class="flex items-center justify-center px-4 py-2 bg-mobilex-accent hover:bg-mobilex-accentHover text-black font-black uppercase text-xs tracking-widest rounded-xl transition-all shadow-[0_0_10px_rgba(57,255,20,0.4)]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ongeza Router
        </button>
    </div>

    <!-- Alert for no active router -->
    @if(!App\Models\Router::where('is_active', true)->exists())
        <div class="p-4 bg-red-900/20 border-2 border-red-500/50 rounded-2xl flex items-center gap-4 text-red-500 shadow-[0_0_15px_rgba(220,38,38,0.15)]">
            <svg class="w-8 h-8 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div class="flex-1">
                <p class="text-xs font-black uppercase tracking-widest leading-relaxed">HALO: Hakuna Router iliyowashwa (Active). Mfumo wa malipo hautafanya kazi bila kuunganishwa na Router.</p>
            </div>
        </div>
    @endif

    <!-- Router Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($routers as $router)
            <div class="bg-mobilex-panel border {{ $router->is_active ? 'border-mobilex-accent/50 shadow-[0_0_20px_rgba(57,255,20,0.1)]' : 'border-mobilex-border' }} rounded-3xl p-6 transition-all relative overflow-hidden group">
                <!-- Status icon pulse -->
                <div class="absolute top-4 right-4">
                    @if($router->is_active)
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mobilex-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-mobilex-accent"></span>
                        </span>
                    @else
                        <span class="block h-2 w-2 rounded-full bg-mobilex-border"></span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-black uppercase tracking-widest text-mobilex-white mb-2">{{ $router->name }}</h3>
                    <p class="text-[10px] font-black tracking-widest uppercase text-mobilex-primary opacity-70">{{ $router->ip }} : {{ $router->port }}</p>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between text-[10px] uppercase font-bold text-mobilex-textSoft">
                        <span class="opacity-50">Username:</span>
                        <span class="font-mono tracking-widest">{{ $router->username }}</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="testConnection({{ $router->id }})" class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest bg-mobilex-bg border border-mobilex-border text-mobilex-primary hover:border-mobilex-accent hover:text-mobilex-accent rounded-xl transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)]">
                        Test Connect
                    </button>
                    <button wire:click="edit({{ $router->id }})" class="px-4 py-3 bg-mobilex-bg border border-mobilex-border text-mobilex-white hover:text-mobilex-accent rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button wire:click="delete({{ $router->id }})" wire:confirm="Futa hii router?" class="px-4 py-3 bg-mobilex-bg border border-mobilex-border text-mobilex-textSoft hover:text-red-500 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-mobilex-panel/50 rounded-3xl border-2 border-dashed border-mobilex-border">
                <p class="text-xs font-black uppercase tracking-[0.3em] text-mobilex-textSoft/30">Hujasajili Router yoyote bado.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-md" wire:click="$set('showModal', false)"></div>
            
            <div class="relative bg-mobilex-panel border border-mobilex-accent/30 rounded-3xl w-full max-w-lg overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.8)]">
                <form wire:submit="save">
                    <div class="p-8">
                        <h3 class="text-xl font-black uppercase tracking-widest text-mobilex-white mb-8 border-b border-mobilex-border pb-4">Sajili MikroTik</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-mobilex-primary mb-2">Jina la Kifa (Mf. Core Router)</label>
                                <input wire:model="name" type="text" class="w-full bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-white h-12 px-4 focus:border-mobilex-accent focus:ring-0">
                                @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-mobilex-textSoft mb-2">IP Address</label>
                                    <input wire:model="ip" type="text" class="w-full bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-white h-12 px-4 focus:border-mobilex-accent focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-mobilex-textSoft mb-2">API Port (Def: 8728)</label>
                                    <input wire:model="port" type="number" class="w-full bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-white h-12 px-4 focus:border-mobilex-accent focus:ring-0">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-mobilex-textSoft mb-2">API Username</label>
                                    <input wire:model="username" type="text" class="w-full bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-white h-12 px-4 focus:border-mobilex-accent focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-mobilex-textSoft mb-2">API Password</label>
                                    <input wire:model="password" type="password" class="w-full bg-mobilex-bg border border-mobilex-border rounded-xl text-mobilex-accent h-12 px-4 focus:border-mobilex-accent focus:ring-0">
                                </div>
                            </div>

                            <div class="pt-4">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="is_active" type="checkbox" class="w-5 h-5 bg-mobilex-bg border-mobilex-border text-mobilex-accent rounded focus:ring-mobilex-accent focus:ring-offset-mobilex-panel">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-mobilex-accent">Washa Iwe Router Kuu (Active)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-black/20 p-6 flex flex-row-reverse gap-4 border-t border-mobilex-border">
                        <button type="submit" class="px-8 py-3 bg-mobilex-accent text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-mobilex-accentHover shadow-[0_0_15px_rgba(57,255,20,0.3)]">
                            Hifadhi Router
                        </button>
                        <button type="button" wire:click="$set('showModal', false)" class="px-8 py-3 bg-transparent border border-mobilex-border text-mobilex-textSoft font-black uppercase text-xs tracking-widest rounded-xl hover:text-white">
                            Ghairi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
