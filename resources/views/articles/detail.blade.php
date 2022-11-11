@extends("layouts.app")

@section("content")
    <div class="container">

            @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            <div class="card mb-3 border-2 border-secondary rounded">
                <div class="card-body">
                    <h3>{{ $article->title }}</h3>
                    <small class="text-muted">{{ $article->created_at->diffForHumans()}}</small>
                    <b class="text-success">{{ $article->user->name }}</b>
                    <i class="me-2">{{ $article->category->name }}</i>
                    <div>{{ $article->body }}</div>
                </div>
                <div class="card-footer">
                @auth
                    <a href="{{ url("/articles/edit/$article->id")}}"
                    class="btn btn-success">Edit
                    </a>
                    @can('article-delete', $article)
                        <a href="{{ url("/articles/delete/$article->id")}}"
                        class="btn btn-danger">Delete
                        </a>
                    @endcan
                @endauth
                </div>
            </div>

            <h4 class="ms-1 h5">Comments ({{ count($article->comments) }})</h4>
            <ul class="list-group">
                @foreach ($article->comments as $comment)
                    <li class="list-group-item">
                        @can('comment-delete', $comment)
                        <a href="{{ "/comments/delete/$comment->id" }}"
                            class="btn-close float-end"></a>
                        @endcan
                        {{ $comment->content }}
                        <div>
                            <small>
                                <b class="text-success">
                                    {{ $article->user->name }}
                                </b>
                                {{ $article->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </li>
                @endforeach
            </ul>

            @auth
                <form action="{{ url("/comments/add") }}" method="post">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea name="content"  class="form-control my-2"></textarea>
                    <button class="btn btn-secondary">Add Comment</button>
                </form>
            @endauth

    </div>
@endsection
