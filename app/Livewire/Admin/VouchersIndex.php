<?php

namespace App\Livewire\Admin;

use App\Models\Voucher;
use Livewire\Component;
use Livewire\WithPagination;

class VouchersIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function generateBulk()
    {
        // Mock method for bulk generation
        $this->dispatch('notify', message: 'Vouchers 100 zimetengenezwa kikamilifu!');
    }

    public function render()
    {
        $vouchers = Voucher::with('package')
            ->where(function($query) {
                $query->where('code', 'like', '%'.$this->search.'%')
                    ->orWhere('mac_address', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(15);

        // Calculate Real Stats for the dashboard cards
        $stats = [
            'active' => Voucher::where('status', 'active')->count(),
            'pending' => Voucher::where('status', 'pending')->count(),
            'expired' => Voucher::where('status', 'expired')->count(),
        ];

        return view('livewire.admin.vouchers-index', [
            'vouchers' => $vouchers,
            'stats' => $stats
        ])->layout('layouts.app', ['header' => 'Usimamizi wa Vouchers na Watumiaji']);
    }
}
