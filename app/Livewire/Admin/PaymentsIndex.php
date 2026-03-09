<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentsIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.payments-index', [
            'payments' => Payment::where('mpesa_receipt', 'like', '%'.$this->search.'%')
                ->orWhere('phone', 'like', '%'.$this->search.'%')
                ->latest()
                ->paginate(15)
        ])->layout('layouts.app', ['header' => 'M-Pesa Payments History']);
    }
}
