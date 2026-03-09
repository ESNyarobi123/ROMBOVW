<?php

namespace App\Livewire\Admin;

use App\Models\Router;
use Livewire\Component;
use App\Services\MikrotikService;

class RoutersIndex extends Component
{
    public $routers;
    public $showModal = false;
    
    // Form fields
    public $routerId, $name, $ip, $username, $password, $port = 8728, $is_active = false;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'ip' => 'required|string|max:255',
            'username' => 'required|string',
            'password' => 'required|string',
            'port' => 'required|integer',
            'is_active' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->loadRouters();
    }

    public function loadRouters()
    {
        $this->routers = Router::all();
    }

    public function create()
    {
        $this->reset(['routerId', 'name', 'ip', 'username', 'password', 'port', 'is_active']);
        $this->showModal = true;
    }

    public function edit(Router $router)
    {
        $this->routerId = $router->id;
        $this->name = $router->name;
        $this->ip = $router->ip;
        $this->username = $router->username;
        $this->password = $router->password; // decrypts automatically in model
        $this->port = $router->port;
        $this->is_active = $router->is_active;
        $this->showModal = true;
    }

    public function testConnection($id)
    {
        $router = Router::find($id);
        if (!$router) {
            $this->dispatch('notify', message: "Imefeli! Router haijapatikana.");
            return;
        }
        
        try {
            $service = new \App\Services\MikrotikService($router);
            if ($service->isConnected()) {
                $this->dispatch('notify', message: "Kimefanikiwa! Router {$router->name} imekubali na kuunganishwa kikamilifu.");
            } else {
                $this->dispatch('notify', message: "Imefeli! Mkaguzi ameshindwa kufikia Router. Angalia IP au Port.");
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', message: "Imefeli! Mkaguzi anasema: " . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate();

        // If this one is set to active, deactivate all others
        if ($this->is_active) {
            Router::where('id', '!=', $this->routerId)->update(['is_active' => false]);
        }

        Router::updateOrCreate(
            ['id' => $this->routerId],
            [
                'name' => $this->name,
                'ip' => $this->ip,
                'username' => $this->username,
                'password' => $this->password, // encrypts automatically in model
                'port' => $this->port,
                'is_active' => $this->is_active,
            ]
        );

        $this->showModal = false;
        $this->loadRouters();
        $this->dispatch('notify', message: 'Router imehifadhiwa kikamilifu!');
    }

    public function delete(Router $router)
    {
        $router->delete();
        $this->loadRouters();
        $this->dispatch('notify', message: 'Router imefutwa.');
    }

    public function render()
    {
        return view('livewire.admin.routers-index')->layout('layouts.app', ['header' => 'Marekebisho ya MikroTik Routers']);
    }
}
