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
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li>Users</li>
        </ul>
    </div>

    <x-mary-card title="Users" shadow>

        <div class="flex justify-between items-center">
            <x-mary-input type="text" placeholder="Cari Nama" wire:model.lazy="search"/>
            <a href="{{ route('mary-ui.users.create') }}" class="btn btn-primary">Create</a>
        </div>

        <form wire:submit.prevent="deleteSelected">
            <x-mary-table :headers="$headers" :rows="$users">
                @scope('cell_select', $item)
                <input type="checkbox" wire:model="selected" value="{{ $item->id }}"/>
                @endscope

                @scope('cell_name',$item)
                {{ $item->name }}
                @endscope

                @scope('cell_actions',$item)
                <div class="flex gap-1">
                    <x-mary-button link="{{ route('mary-ui.users.biodata', $item->id) }}" label="Lihat"
                                   class="btn-xs btn-primary"/>
                    <x-mary-button link="{{ route('mary-ui.users.edit', $item->id) }}" label="Edit"
                                   class="btn-xs btn-warning"/>
                    <x-mary-button spinner wire:confirm="Yakin ingin menghapus?" wire:click="delete({{ $item->id }})"
                                   icon="o-trash" class="btn-xs btn-error"/>
                </div>
                @endscope

            </x-mary-table>

            <div class="mt-4">
                <x-mary-button type="submit" label="Hapus Data Terpilih" class="btn-error"/>
            </div>
        </form>

        {{ $users->links() }}

    </x-mary-card>
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
