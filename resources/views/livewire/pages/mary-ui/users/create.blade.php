<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?int $age = null;
    public string $gender = '';
    public string $birth = '';
    public string $degree = '';
    public string $position = '';
    public bool $married = false;
    public string $address = '';
    public ?int $contract = null;

    public array $degree_all = [];
    public array $position_all = [];
    public array $gender_all = [];

    public function mount()
    {
        $this->degree_all = [
            [
                'id' => 'Bachelor',
                'name' => 'bachelor'
            ],
            [
                'id' => 'Diploma',
                'name' => 'diploma'
            ]
        ];
        $this->position_all = [
            [
                'id' => 'HR',
                'name' => 'HR'
            ],
            [
                'id' => 'Manajer',
                'name' => 'Manajer'
            ],
            [
                'id' => 'Admin',
                'name' => 'Admin'
            ]
        ];
        $this->gender_all = [
            [
                'id' => 'Pria',
                'name' => 'Pria'
            ],
            [
                'id' => 'Wanita',
                'name' => 'Wanita'
            ]
        ];
    }

    public function create()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'age' => 'required|integer|min:1',
            'gender' => 'required|in:Pria,Wanita',
            'position' => 'required|in:HR,Manajer,Admin',
            'married' => 'nullable',
            'degree' => 'required|in:Bachelor,Diploma',
            'birth' => 'required|date',
            'address' => 'required|string|max:255',
            'contract' => 'required|integer|min:1',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'position' => $validated['position'],
            'married' => $validated['married'] ? 1 : 0,
            'degree' => $validated['degree'],
            'birth' => $validated['birth'],
            'address' => $validated['address'],
            'contract' => $validated['contract'],
        ]);

        $this->success('Data created successfully!');
        $this->toast(type: 'info', title: 'Data Berhasil Dibuat');

        $this->reset(['name', 'email', 'password', 'age', 'gender', 'degree', 'position', 'married', 'birth', 'address', 'contract']);

        session()->flash('message', 'User created successfully!');

        return redirect()->route('users.index');
    }
};
?>


<div>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Create</li>
        </ul>
    </div>
    <x-mary-card title="Create User" shadow>
        <form wire:submit.prevent="create" class="flex flex-col gap-4">
            <x-mary-input label="Name" placeholder="Type here" wire:model="name"/>
            <x-mary-input label="Email" placeholder="Type here" wire:model="email"/>
            <x-mary-input label="Password" type="password" placeholder="Type here" wire:model="password"/>
            <x-mary-radio label="Gender" :options="$gender_all" wire:model="gender" class="w-full"/>
            <x-mary-input label="Age" type="number" placeholder="Enter age" wire:model="age"/>
            <x-mary-input label="Birth Date" type="date" wire:model="birth"/>
            <x-mary-select label="Degree" wire:model="degree" :options="$degree_all" placeholder="Select one"/>
            <x-mary-select label="Position" wire:model="position" :options="$position_all" placeholder="Select one"/>
            <x-mary-checkbox label="Sudah" wire:model="married" hint="Already married?"/>
            <x-mary-textarea label="Adress" wire:model="address" placeholder="Type Here"/>
            <x-mary-input label="Contract Duration (months)" type="number" placeholder="Enter contract duration"
                          wire:model="contract"/>

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-600 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-mary-button label="Create" type="submit" class="btn-primary mt-4"/>

        </form>
    </x-mary-card>
    @if (session()->has('message'))
        <p>{{ session('message') }}</p>
    @endif
</div>
