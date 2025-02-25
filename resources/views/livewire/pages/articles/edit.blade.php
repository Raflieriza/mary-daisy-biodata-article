<?php

use Livewire\Volt\Component;
use App\Models\Article;
use Livewire\Attributes\On;

new class extends Component {
    public $article;
    public $title;
    public $description;
    public $body;

    public function mount($id)
    {
        $this->article = Article::findOrFail($id);
        $this->title = $this->article->title;
        $this->description = $this->article->description;
        $this->body = $this->article->body;
    }

    public function updateArticle()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'body' => 'required|string',
        ]);

        $this->article->update([
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
        ]);

        session()->flash('success', 'Article updated successfully!');
    }
};
?>


<div class="max-w-3xl mx-auto my-10 p-6 bg-base-100 shadow-xl rounded-xl card">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('articles.index') }}">Articles</a></li>
            <li>{{ $article->title }}</li>
        </ul>
    </div>
    <div class="card-body">
        <h2 class="card-title text-2xl">Edit Article</h2>

        @if(session()->has('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="updateArticle">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Title</span>
                </label>
                <input type="text" wire:model="title" class="input input-bordered" placeholder="Enter title">
                @error('title') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div wire:ignore class="form-control mt-4">
                <label class="label">
                    <span class="label-text">Description</span>
                </label>
                <textarea id="description-editor" class="textarea textarea-bordered h-32">{{ $description }}</textarea>
                @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div wire:ignore class="form-control mt-4">
                <label class="label">
                    <span class="label-text">Body</span>
                </label>
                <textarea id="markdown-editor" class="textarea textarea-bordered h-32"
                          placeholder="Enter article content">{{ $body }}</textarea>
                @error('body') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="card-actions justify-end mt-6">
                <a href="{{ route('articles.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endpush

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi SimpleMDE untuk Body
            var simplemde = new SimpleMDE({
                element: document.getElementById("markdown-editor"),
                previewRender: function (plainText, preview) {
                    setTimeout(() => {
                        preview.classList.add("prose max-w-none");
                    }, 10);
                    return simplemde.markdown(plainText);
                }
            });
            simplemde.codemirror.on("change", function () {
                @this.
                set('body', simplemde.value());
            });

            // Inisialisasi CKEditor untuk Description
            var descriptionEditor = CKEDITOR.replace('description-editor');
            descriptionEditor.on('change', function () {
                @this.
                set('description', descriptionEditor.getData());
            });
        });
    </script>
@endpush

