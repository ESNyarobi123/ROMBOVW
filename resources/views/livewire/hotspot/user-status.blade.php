use Livewire\Volt\Component;
use App\Services\MikrotikService;

new class extends Component {
    public string $timeRemaining = '--:--:--';
    public string $dataRemaining = 'NA';
    
    public function mount(\App\Services\MikrotikService $mikrotik)
    {
        $this->updateStatus($mikrotik);
    }

    public function updateStatus(\App\Services\MikrotikService $mikrotik)
    {
        // Try to find the user session in Mikrotik based on IP (Simplest way for browser)
        $ip = request()->ip();
        
        try {
            $activeUsers = $mikrotik->getConnectedUsers();
            $me = collect($activeUsers)->firstWhere('address', $ip);
            
            if ($me) {
                // time-left is usually what we want (it comes from limit-uptime - uptime)
                $this->timeRemaining = $me['session-time-left'] ?? 'ACTIVE';
                
                // data-limit
                $this->dataRemaining = isset($me['limit-bytes-total']) 
                    ? round($me['limit-bytes-total'] / 1048576, 2) . ' MB' 
                    : 'UNLIMITED';
            } else {
                $this->timeRemaining = 'DISCONNECTED';
            }
        } catch (\Exception $e) {
            $this->timeRemaining = 'OFFLINE';
        }
    }
    
    public function disconnect(\App\Services\MikrotikService $mikrotik)
    {
        $ip = request()->ip();
        $activeUsers = $mikrotik->getConnectedUsers();
        $me = collect($activeUsers)->firstWhere('address', $ip);

        if ($me && isset($me['user'])) {
            $mikrotik->forceDisconnect($me['user']);
        }
        
        return redirect()->route('hotspot.packages');
    }
};
?>

<div class="max-w-md mx-auto p-8 bg-mobilex-panel rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-mobilex-border text-center relative overflow-hidden z-10 w-full" wire:poll.10s="updateStatus">
    <?php ?> <!-- Opening PHP tag was closed prematurely in previous view, ensuring layout works -->
    
    <!-- Background futuristic pulse effect mapping MobileX vibes -->
    <div class="absolute top-[-50px] right-[-50px] w-48 h-48 bg-mobilex-accent/20 rounded-full blur-[80px] animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-[-50px] left-[-50px] w-48 h-48 bg-mobilex-primary/10 rounded-full blur-[80px] animate-pulse pointer-events-none" style="animation-delay: 1.5s;"></div>
    
    <div class="relative z-10">
        <div class="inline-flex items-center justify-center px-4 py-2 bg-mobilex-bg border border-mobilex-accent/50 rounded-full mb-8 shadow-[0_0_15px_rgba(57,255,20,0.2)]">
            <span class="flex h-3 w-3 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mobilex-accent opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-mobilex-accent shadow-[0_0_5px_rgba(57,255,20,1)]"></span>
            </span>
            <span class="ml-3 text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-accent">MobiLex Connected</span>
        </div>

        <h2 class="text-2xl font-black uppercase tracking-widest text-mobilex-white mb-8 drop-shadow-md">STATUS YAKO</h2>

        <!-- Central Circular Radar / Time Display (Futuristic UX) -->
        <div class="w-48 h-48 mx-auto bg-mobilex-bg rounded-full border-4 border-dashed border-mobilex-border flex flex-col items-center justify-center relative mb-10 shadow-[inset_0_0_30px_rgba(0,0,0,0.8)]">
            <div class="absolute inset-0 border-4 border-mobilex-accent rounded-full border-t-transparent animate-[spin_4s_linear_infinite] opacity-50"></div>
            <div class="absolute inset-2 border-2 border-mobilex-primary rounded-full border-b-transparent animate-[spin_3s_linear_infinite_reverse] opacity-20"></div>
            
            <div class="text-[9px] text-mobilex-textSoft font-black uppercase tracking-[0.3em] mb-2 opacity-70">Muda Uliobaki</div>
            <div class="text-3xl font-black text-mobilex-white font-mono tracking-widest drop-shadow-[0_0_8px_rgba(255,255,255,0.4)]">{{ $timeRemaining }}</div>
        </div>

        <!-- Secondary Stat / Data -->
        <div class="bg-mobilex-bg rounded-2xl p-4 border border-mobilex-border/50 mb-8 inline-block min-w-[200px] shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
            <div class="text-[9px] text-mobilex-primary font-black uppercase tracking-[0.3em] mb-1">Data / Bundle Limit</div>
            <div class="text-lg font-black text-mobilex-accent uppercase tracking-widest drop-shadow-[0_0_5px_rgba(57,255,20,0.5)]">{{ $dataRemaining }}</div>
        </div>

        <!-- Disconnect Button -->
        <button wire:click="disconnect" class="w-full flex justify-center items-center py-4 px-4 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] text-white bg-red-600/20 border-2 border-red-500/50 hover:bg-red-600 hover:border-red-600 transition-all shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:shadow-[0_0_20px_rgba(220,38,38,0.6)]">
            <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            DISCONNECT / KATA
        </button>
    </div>
</div>