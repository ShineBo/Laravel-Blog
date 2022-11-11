@extends("layouts.app")

@section("content")
    <div class="container">

        @if (session("info"))
            <div class="alert alert-success">
                {{ session("info") }}
            </div>
        @endif

        {{ $articles->links() }}

        @foreach($articles as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <h3>{{ $article->title }}</h3>
                    <small class="text-muted">
                    {{ $article->created_at->diffForHumans()}}
                    Category: <i class="me-2">{{ $article->category->name }}</i>
                    Username <b class="text-success">{{ $article->user->name }}</b>
                    Comments: <b>{{ count($article->comments)}}</b>
                    </small>
                    <div>{{ $article->body }}</div>
                </div>
                <div class="card-footer">
                    <a href="{{ url("/articles/detail/$article->id")}}"
                    class="card-link">View Details...
                    </a>
                </div>
            </div>

        @endforeach
    </div>
@endsection
