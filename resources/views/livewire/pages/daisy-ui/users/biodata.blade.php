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

<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('mary-ui.users.index') }}">Users</a></li>
            <li>Biodata</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl p-4">
        <h2 class="card-title">Biodata</h2>

        <form class="flex flex-col gap-4 mt-4">
            <input type="text" wire:model="name" class="input input-bordered" placeholder="Name" readonly/>

            <input type="email" wire:model="email" class="input input-bordered" placeholder="Email" readonly/>

            <input type="number" wire:model="age" class="input input-bordered" placeholder="Age" readonly/>

            <input type="text" wire:model="gender" class="input input-bordered" placeholder="Gender" readonly/>

            <input type="date" wire:model="birth" class="input input-bordered" readonly/>

            <input type="text" wire:model="degree" class="input input-bordered" placeholder="Degree" readonly/>

            <input type="text" wire:model="position" class="input input-bordered" placeholder="Position" readonly/>

            <textarea wire:model="address" class="textarea textarea-bordered" placeholder="Address" readonly></textarea>

            <input type="number" wire:model="contract" class="input input-bordered"
                   placeholder="Contract Duration (months)" readonly/>
        </form>
    </div>
</div>
