<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mary\Traits\Toast;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    use Toast;

    public $search;
    public array $selected = [];

    public function with(): array
    {
        $data = User::where('name', 'like', "%{$this->search}%")->latest()->paginate(10);
        $headers = [
            ['key' => 'select', 'label' => 'Select'],
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nama'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'actions', 'label' => 'Actions'],
        ];
        return [
            'users' => $data,
            'headers' => $headers
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->toast(type: 'warning', title: 'Tidak ada data yang dipilih!');
            return;
        }

        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];

        $this->success('Data yang dipilih berhasil dihapus');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->success('Berhasil Menghapus Data');
        } else {
            $this->error('Error!');
        }
    }
};
?>

<div class="p-4">
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a href="/">Home</a></li>
            <li>Users</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl p-4">
        <h2 class="card-title">Users</h2>

        <div class="flex justify-between items-center my-4">
            <input type="text" placeholder="Cari Nama" wire:model.lazy="search"
                   class="input input-bordered w-full max-w-xs"/>
            <a href="{{ route('daisy-ui.users.create') }}" class="btn btn-primary">Create</a>
        </div>

        <form wire:submit.prevent="deleteSelected">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>
                                <input type="checkbox" wire:model="selected" value="{{ $item->id }}" class="checkbox"/>
                            </td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('daisy-ui.users.biodata', $item->id) }}"
                                       class="btn btn-xs btn-primary">Lihat</a>
                                    <a href="{{ route('daisy-ui.users.edit', $item->id) }}"
                                       class="btn btn-xs btn-warning">Edit</a>
                                    <button type="button" wire:click="delete({{ $item->id }})"
                                            onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()"
                                            class="btn btn-xs btn-error">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-error">Hapus Data Terpilih</button>
            </div>
        </form>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('sweetalert2'))
        <script>
            Swal.fire({
                title: '{{ session('sweetalert2')['title'] }}',
                text: '{{ session('sweetalert2')['text'] }}',
                icon: '{{ session('sweetalert2')['icon'] }}',
            })
        </script>
    @endif
@endpush

