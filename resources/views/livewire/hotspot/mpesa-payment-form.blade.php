<?php

use Livewire\Volt\Component;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Voucher;
use App\Services\SnippeService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

new class extends Component {
    public $packageId;
    public $package;
    public string $phone = '';
    public string $mac = '';
    public bool $isProcessing = false;
    public ?string $paymentReference = null;
    public string $errorMessage = '';

    public function mount($package_id)
    {
        $this->packageId = $package_id;
        $this->package = Package::find($package_id) ?? (object)['id' => $package_id, 'name' => '1 FULL DAY', 'price' => 2000];
        $this->phone = session('user_phone', '');
        $this->mac = request()->query('mac', session('user_mac', ''));
        
        if ($this->mac) {
            session(['user_mac' => $this->mac]);
        }
    }

    public function initiatePayment(SnippeService $snippeService)
    {
        $this->validate([
            'phone' => ['required', 'string', 'min:9', 'max:13'],
        ]);

        $this->isProcessing = true;
        $this->errorMessage = '';
        session(['user_phone' => $this->phone]);
        
        // Generate a unique reference for our database vs Snippe API
        $this->paymentReference = 'REF_' . strtoupper(Str::random(12));
        
        // Save initial pending payment to database
        Payment::create([
            'phone' => $this->phone,
            'amount' => $this->package->price,
            'mpesa_receipt' => $this->paymentReference, // Using this field as our Reference ID temporarily
            'mac_address' => $this->mac,
            'status' => 'pending',
            'package_id' => $this->package->id
        ]);

        // Attempt Snippe API Call
        $response = $snippeService->initiateMobileMoneyPush($this->phone, $this->package->price, $this->paymentReference);

        if (isset($response['success']) && $response['success'] === false) {
            // Revert state if API threw hard error
            $this->isProcessing = false;
            $this->errorMessage = $response['message'] ?? 'API Error Hapa.';
            return;
        }

        $this->dispatch('payment-initiated');
    }

    public function checkPaymentStatus()
    {
        if (!$this->paymentReference) return;

        $payment = Payment::where('mpesa_receipt', $this->paymentReference)->first();
        
        if ($payment && $payment->status === 'completed') {
            // The WebhookController has already generated the Voucher and Saved it.
            // Let's find that voucher. We assume the Webhook created a voucher mapping the same phone & package
            // But to be precise, we get latest voucher for this phone
            $voucher = Voucher::where('phone', $payment->phone)->latest()->first();
            
            if ($voucher) {
                return redirect()->route('hotspot.success', ['code' => $voucher->code]);
            }
        } elseif ($payment && $payment->status === 'failed') {
            $this->isProcessing = false;
            $this->errorMessage = 'Malipo yamekataliwa (Failed). Tafadhali jaribu tena.';
        }
    }
};
?>

<div class="max-w-md mx-auto p-6 bg-mobilex-panel rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-mobilex-border z-10 relative overflow-hidden w-full">
    <!-- Glow -->
    <div class="absolute -top-32 -left-32 w-64 h-64 bg-mobilex-primary/10 rounded-full blur-[80px] pointer-events-none"></div>

    <button wire:navigate href="{{ route('hotspot.packages') }}" class="text-[10px] uppercase tracking-[0.2em] font-black text-mobilex-textSoft hover:text-mobilex-accent flex items-center mb-8 transition-colors group relative z-10">
        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Rudi Nyuma
    </button>

    <div class="mb-8 text-center relative z-10">
        <div class="mb-4 inline-block p-4 rounded-full bg-mobilex-bg border-2 border-mobilex-border text-mobilex-accent">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>
        <h2 class="text-2xl font-black uppercase tracking-widest text-mobilex-white">M-PESA CHECKOUT</h2>
        <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-mobilex-textSoft mt-2">Kifurushi: <strong class="text-mobilex-accent">{{ $package->name }}</strong></p>
    </div>

    <!-- Bill Summary Panel -->
    <div class="bg-mobilex-bg rounded-2xl p-6 mb-8 border border-mobilex-accent/30 relative overflow-hidden shadow-[inset_0_2px_15px_rgba(0,0,0,0.8)] z-10">
        <div class="absolute -right-6 -top-6 opacity-5 rotate-12">
            <svg class="w-40 h-40 text-mobilex-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        </div>
        <div class="flex flex-col items-center justify-center relative z-10">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-mobilex-primary mb-2">Kiasi Cha Kulipa</span>
            <span class="text-4xl font-black text-mobilex-accent tracking-widest drop-shadow-[0_0_10px_rgba(57,255,20,0.8)]">TZS {{ number_format($package->price) }}</span>
        </div>
    </div>

    <form wire:submit="initiatePayment" class="space-y-6 relative z-10">
        <div>
            <label for="phone" class="block text-[10px] font-black uppercase tracking-[0.2em] text-mobilex-textSoft mb-3">Namba Ya Simu Yako (M-Pesa)</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-mobilex-textSoft font-black">255</span>
                </div>
                <input wire:model="phone" type="text" id="phone" placeholder="75XXXXXXX" class="pl-14 block w-full rounded-2xl border-2 border-mobilex-border bg-mobilex-bg text-mobilex-white font-mono font-black text-lg tracking-widest h-14 focus:ring-0 focus:border-mobilex-accent shadow-[inset_0_2px_4px_rgba(0,0,0,0.8)] transition-all uppercase" {{ $isProcessing ? 'disabled' : '' }}>
            </div>
            @error('phone') <span class="text-[10px] font-black tracking-widest uppercase text-red-500 mt-2 block">{{ $message }}</span> @enderror
            @if($errorMessage)
                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/50 rounded-xl">
                    <span class="text-[10px] font-black tracking-widest uppercase text-red-500">{{ $errorMessage }}</span>
                </div>
            @endif
        </div>

        @if(!$isProcessing)
            <button type="submit" class="w-full flex justify-center items-center py-4 px-4 rounded-xl shadow-[0_0_20px_rgba(57,255,20,0.3)] hover:shadow-[0_0_30px_rgba(57,255,20,0.6)] text-xs tracking-[0.2em] uppercase font-black text-black bg-mobilex-accent hover:bg-mobilex-accentHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-mobilex-bg focus:ring-mobilex-accent transition-all transform hover:-translate-y-1 active:scale-95">
                TUMA OMBI LA MALIPO Sasa
                <svg class="ml-3 w-5 h-5 animate-pulse" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        @else
            <!-- Loading State -->
            <div class="flex flex-col items-center justify-center p-8 border-2 border-mobilex-accent/30 rounded-2xl bg-mobilex-bg shadow-[0_0_20px_rgba(57,255,20,0.1)]" wire:poll.3s="checkPaymentStatus">
                <div class="relative w-20 h-20 mb-6">
                    <div class="absolute top-0 left-0 w-full h-full border-4 border-mobilex-border rounded-full"></div>
                    <div class="absolute top-0 left-0 w-full h-full border-4 border-mobilex-accent rounded-full border-t-transparent animate-spin drop-shadow-[0_0_10px_rgba(57,255,20,0.8)]"></div>
                </div>
                <h3 class="font-black text-mobilex-white uppercase tracking-widest text-lg">Inasubiri Malipo...</h3>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-mobilex-primary text-center mt-3 leading-relaxed">Weka PIN yako kwenye simu muda huu.<br/>M-Pesa inawasiliana na Mfumo.</p>
                <button type="button" wire:click="$set('isProcessing', false)" class="mt-6 text-[9px] text-mobilex-textSoft hover:text-white uppercase font-black underline tracking-widest cursor-pointer">Ghairi Malipo</button>
            </div>
        @endif
    </form>
</div>