<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use Livewire\Component;

class PackagesIndex extends Component
{
    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $packageId, $name, $price, $time_limit, $bytes_limit;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'time_limit' => 'required|integer|min:1', // minutes
            'bytes_limit' => 'nullable|integer|min:0',
        ];
    }

    public function create()
    {
        $this->reset(['packageId', 'name', 'price', 'time_limit', 'bytes_limit']);
        $this->showModal = true;
    }

    public function edit(Package $package)
    {
        $this->packageId = $package->id;
        $this->name = $package->name;
        $this->price = $package->price;
        $this->time_limit = $package->time_limit;
        $this->bytes_limit = $package->bytes_limit;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Package::updateOrCreate(
            ['id' => $this->packageId],
            [
                'name' => $this->name,
                'price' => $this->price,
                'time_limit' => $this->time_limit,
                'bytes_limit' => $this->bytes_limit,
            ]
        );

        $this->showModal = false;
        // Optionally dispatch a success notification
        $this->dispatch('notify', message: 'Package saved successfully!');
    }

    public function delete(Package $package)
    {
        $package->delete();
    }

    public function render()
    {
        return view('livewire.admin.packages-index', [
            'packages' => Package::where('name', 'like', '%'.$this->search.'%')->paginate(10)
        ])->layout('layouts.app', ['header' => 'Packages Management']);
    }
}
