<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class LiveUsers extends Component
{
    // Normally injected via MikrotikService
    public $activeUsers = [];

    public function mount(MikrotikService $mikrotik)
    {
        $this->loadUsers($mikrotik);
    }

    public function loadUsers(MikrotikService $mikrotik)
    {
        try {
            $this->activeUsers = $mikrotik->getConnectedUsers();
        } catch (\Exception $e) {
            $this->activeUsers = [];
            // Log::error($e->getMessage());
        }
    }

    public function forceDisconnect($userId, MikrotikService $mikrotik)
    {
        try {
            // Execute disconnection via service
            $mikrotik->forceDisconnect($userId);
            
            $this->loadUsers($mikrotik);
            $this->dispatch('notify', message: 'Mtumiaji amesitishwa (Disconnected)');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Kuna hitilafu ya kuwasiliana na Router');
        }
    }

    public function render()
    {
        return view('livewire.admin.live-users')->layout('layouts.app', ['header' => 'Wanaotumia Intaneti Sasa Hivi']);
    }
}
