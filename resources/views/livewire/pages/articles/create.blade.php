<?php

use Livewire\Volt\Component;
use App\Models\Article;

new class extends Component {
    public $title = '';
    public $description = '';
    public $body = '';

    public function submit()
    {
        Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
        ]);

        session()->flash('success', 'Artikel berhasil disimpan.');

        $this->reset(['title', 'description', 'body']);
    }
}; ?>

<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('articles.index') }}">Users</a></li>
            <li>Create</li>
        </ul>
    </div>
    <div>
        <form wire:submit="submit" class="flex flex-col gap-4">


            <div wire:ignore>
                <label class="font-semibold w-full">Title:</label>
                <textarea id="ckeditor-title" class="w-full"></textarea>
            </div>


            <div wire:ignore>
                <label class="font-semibold w-full">Description:</label>
                <textarea id="ckeditor-description" class="w-full"></textarea>
            </div>

            {{-- SimpleMDE untuk Body --}}
            <div wire:ignore>
                <label class="font-semibold w-full">Body:</label>
                <textarea id="markdown-editor" class="w-full"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Submit</button>

        </form>

        @if(session()->has('success'))
            <div class="mt-4 text-green-500">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var ckeditorTitle = CKEDITOR.replace('ckeditor-title');
            ckeditorTitle.on('change', function () {
                @this.
                set('title', ckeditorTitle.getData());
            });


            var ckeditorDescription = CKEDITOR.replace('ckeditor-description');
            ckeditorDescription.on('change', function () {
                @this.
                set('description', ckeditorDescription.getData());
            });


            var simplemde = new SimpleMDE({
                element: document.getElementById("markdown-editor"),
                previewRender: function (plainText, preview) {
                    setTimeout(() => {
                        preview.classList.add("prose max-w-auto");
                    }, 10);
                    return simplemde.markdown(plainText);
                }
            });

            simplemde.codemirror.on("change", function () {
                @this.
                set('body', simplemde.value());
            });
        });
    </script>
@endpush
