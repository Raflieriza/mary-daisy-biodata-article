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

        return redirect()->route('mary-ui.users.index');
    }
};
?>

<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('mary-ui.users.index') }}">Users</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl p-4">
        <h2 class="card-title">Edit User</h2>

        <form wire:submit.prevent="update" class="flex flex-col gap-4 mt-4">

            <input type="text" wire:model="name" class="input input-bordered" placeholder="Name"/>

            <input type="email" wire:model="email" class="input input-bordered" placeholder="Email"/>

            <input type="number" wire:model="age" class="input input-bordered" placeholder="Age"/>

            <div class="flex gap-4 items-center">
                <label class="label-text font-semibold">Gender:</label>
                <label class="cursor-pointer">
                    <input type="radio" wire:model="gender" value="Pria" class="radio"/>
                    <span class="ml-2">Pria</span>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" wire:model="gender" value="Wanita" class="radio"/>
                    <span class="ml-2">Wanita</span>
                </label>
            </div>

            <input type="date" wire:model="birth" class="input input-bordered"/>

            <select wire:model="degree" class="select select-bordered">
                <option disabled>Select Degree</option>
                <option value="Bachelor">Bachelor</option>
                <option value="Diploma">Diploma</option>
            </select>

            <select wire:model="position" class="select select-bordered">
                <option disabled>Select Position</option>
                <option value="HR">HR</option>
                <option value="Manajer">Manajer</option>
                <option value="Admin">Admin</option>
            </select>

            <textarea wire:model="address" class="textarea textarea-bordered" placeholder="Address"></textarea>

            <input type="number" wire:model="contract" class="input input-bordered"
                   placeholder="Contract Duration (months)"/>

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-600 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-4">Update</button>

        </form>
    </div>
</div>

