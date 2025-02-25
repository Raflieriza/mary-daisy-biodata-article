<?php

use Livewire\Volt\Component;
use App\Models\Article;

new class extends Component {

    public $article;

    public function mount($id)
    {
        $this->article = Article::find($id);

        if (!$this->article) {
            abort(404);
        }
    }
};
?>


<div>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('articles.index') }}">Articles</a></li>
            <li>{{ $article->title ?? 'No Title Available' }}</li>
        </ul>
    </div>
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="prose-xl md:prose-sm max-w-none w-full gap-2">
                <x-markdown>
                    {{ $article->title }}
                </x-markdown>
                <div>
                    {!!  $article->description !!}
                </div>
                <x-markdown>
                    {{ $article->body }}
                </x-markdown>
            </div>
        </div>
    </div>
</div>




