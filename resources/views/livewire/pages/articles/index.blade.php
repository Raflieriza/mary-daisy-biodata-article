<?php

use Livewire\Volt\Component;
use App\Models\Article;

new class extends Component {

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        session()->flash('success', 'Artikel berhasil dihapus.');
    }

}; ?>




<div class="p-4">
    <!-- Breadcrumbs -->
    <div class="text-sm breadcrumbs">
        <ul>
            <li><a href="/">Home</a></li>
            <li>Articles</li>
        </ul>
    </div>

    <h1 class="text-2xl font-bold mb-4">Daftar Artikel</h1>

    <!-- Notifikasi Sukses -->
    @if(session()->has('success'))
        <div class="alert alert-success shadow-lg mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tombol Create -->
    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-5">Create</a>

    <!-- Tabel Artikel -->
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full border border-gray-200 shadow-lg rounded-lg">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">No</th>
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\Article::latest()->get() as $article)
                <tr class="hover">
                    <td class="p-3 text-center">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $article->title }}</td>
                    <td class="p-3">{{ $article->description }}</td>
                    <td class="p-3 text-center">
                        <div class="flex flex-row gap-2 justify-center">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <button type="button"
                                    wire:click="delete({{ $article->id }})"
                                    onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()"
                                    class="btn btn-sm btn-error">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

