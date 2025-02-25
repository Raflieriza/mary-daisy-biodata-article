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

        return redirect()->route('daisy-ui.users.index');
    }
};
?>


<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('daisy-ui.users.index') }}">Users</a></li>
            <li>Create</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl p-4">
        <h2 class="card-title">Create User</h2>

        <form wire:submit.prevent="create" class="flex flex-col gap-4 mt-4">
            <input type="text" placeholder="Name" wire:model="name" class="input input-bordered"/>

            <input type="email" placeholder="Email" wire:model="email" class="input input-bordered"/>

            <input type="password" placeholder="Password" wire:model="password" class="input input-bordered"/>

            <div class="flex gap-4 items-center">
                <label class="label-text font-semibold">Gender:</label>
                @foreach ($gender_all as $gender)
                    <label class="label cursor-pointer">
                        <input type="radio" wire:model="gender" value="{{ $gender['id'] }}" class="radio"/>
                        <span class="ml-2">{{ $gender['name'] }}</span>
                    </label>
                @endforeach
            </div>

            <input type="number" placeholder="Age" wire:model="age" class="input input-bordered"/>

            <input type="date" wire:model="birth" class="input input-bordered"/>

            <select wire:model="degree" class="select select-bordered">
                <option disabled selected>Select Degree</option>
                @foreach ($degree_all as $degree)
                    <option value="{{ $degree['id'] }}">{{ $degree['name'] }}</option>
                @endforeach
            </select>

            <select wire:model="position" class="select select-bordered">
                <option disabled selected>Select Position</option>
                @foreach ($position_all as $position)
                    <option value="{{ $position['id'] }}">{{ $position['name'] }}</option>
                @endforeach
            </select>

            <label class="label cursor-pointer gap-2">
                <input type="checkbox" wire:model="married" class="checkbox"/>
                <span>Sudah Menikah?</span>
            </label>

            <textarea placeholder="Address" wire:model="address" class="textarea textarea-bordered"></textarea>

            <input type="number" placeholder="Contract Duration (months)" wire:model="contract"
                   class="input input-bordered"/>

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-600 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-4">Create</button>

        </form>

        @if (session()->has('message'))
            <div class="alert alert-success mt-4">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>

