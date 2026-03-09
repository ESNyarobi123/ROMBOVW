<?php

namespace App\Livewire\Admin;

use App\Services\MikrotikService;
use Livewire\Component;

class LiveUsers extends Component
{
    public $activeUsers = [];

    /**
     * @param MikrotikService $mikrotik
     */
    public function mount(MikrotikService $mikrotik)
    {
        $this->loadUsers($mikrotik);
    }

    /**
     * @param MikrotikService $mikrotik
     */
    public function loadUsers(MikrotikService $mikrotik)
    {
        try {
            $this->activeUsers = $mikrotik->getConnectedUsers();
        } catch (\Exception $e) {
            $this->activeUsers = [];
        }
    }

    /**
     * @param string $userId
     * @param MikrotikService $mikrotik
     */
    public function forceDisconnect($userId, MikrotikService $mikrotik)
    {
        try {
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
