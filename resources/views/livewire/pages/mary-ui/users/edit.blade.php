<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $id;
    public $user;

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
        $this->user = User::findOrFail($id);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->age = $this->user->age;
        $this->gender = $this->user->gender;
        $this->birth = $this->user->birth;
        $this->degree = $this->user->degree;
        $this->position = $this->user->position;
        $this->address = $this->user->address;
        $this->contract = $this->user->contract;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'age' => 'required|integer|min:1',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|in:HR,Manajer,Admin',
            'degree' => 'required|in:Bachelor,Diploma',
            'birth' => 'required|date',
            'address' => 'required|string|max:255',
            'contract' => 'required|integer|min:1',
        ]);

        $this->user->update($validated);

        $this->success('Data updated successfully!');
        $this->toast(type: 'info', title: 'Data Berhasil Diupdate');

        return redirect()->route('users.index');
    }
};
?>

<div>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <form wire:submit.prevent="update">
        <x-mary-card title="Edit User" shadow>
            <x-mary-input label="Name" wire:model="name"/>
            <x-mary-input label="Email" wire:model="email"/>
            <x-mary-input label="Age" type="number" wire:model="age"/>

            <div class="mt-4">
                <label>Gender</label>
                <div class="flex gap-4">
                    <label><input type="radio" wire:model="gender" value="Pria"> Pria</label>
                    <label><input type="radio" wire:model="gender" value="Wanita"> Wanita</label>
                </div>
            </div>

            <x-mary-input label="Birth Date" type="date" wire:model="birth" class="mt-4"/>

            <div class="mt-4">
                <label>Degree</label>
                <select wire:model="degree" class="select select-bordered w-full">
                    <option value="">Select Degree</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Diploma">Diploma</option>
                </select>
            </div>

            <div class="mt-4">
                <label>Position</label>
                <select wire:model="position" class="select select-bordered w-full">
                    <option value="">Select Position</option>
                    <option value="HR">HR</option>
                    <option value="Manajer">Manajer</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="mt-4">
                <label>Address</label>
                <textarea wire:model="address" class="textarea textarea-bordered w-full"></textarea>
            </div>

            <x-mary-input label="Contract Duration (months)" type="number" wire:model="contract"/>

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-600 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-mary-button type="submit" label="Update" class="btn-primary mt-4"/>
        </x-mary-card>
    </form>
</div>
