<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\Attributes\{Layout};

new class extends Component {
    public $id;
    public $data;

    public $name;
    public $email;
    public $age;
    public $gender;
    public $birth;
    public $degree;
    public $position;
    public $address;
    public $contract;

    public function mount($id)
    {
        $this->id = $id;
        $this->data = User::findOrFail($id);

        $this->name = $this->data->name;
        $this->email = $this->data->email;
        $this->age = $this->data->age;
        $this->gender = $this->data->gender;
        $this->birth = $this->data->birth;
        $this->degree = $this->data->degree;
        $this->position = $this->data->position;
        $this->address = $this->data->address;
        $this->contract = $this->data->contract;
    }

}; ?>

<div>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('mary-ui.users.index') }}">Users</a></li>
            <li>Biodata</li>
        </ul>
    </div>


    <form>
        <x-mary-card title="Biodata" shadow>
            <x-mary-input label="Name" wire:model="name" readonly/>
            <x-mary-input label="Email" wire:model="email" readonly/>
            <x-mary-input label="Age" wire:model="age" readonly/>
            <x-mary-input label="Gender" wire:model="gender" readonly/>
            <x-mary-input label="Birth" type="date" wire:model="birth" readonly/>
            <x-mary-input label="Degree" wire:model="degree" readonly/>
            <x-mary-input label="Position" wire:model="position" readonly/>
            <x-mary-input label="Address" wire:model="address" readonly/>
            <x-mary-input label="Contract Duration (months)" wire:model="contract" readonly/>
        </x-mary-card>
    </form>

</div>
