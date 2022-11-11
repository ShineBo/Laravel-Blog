@extends('layouts.app')

@section('content')
    <div class="container">

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
            </div>
        @endif


        <form action="" method="post">
            @csrf
            <div class="mb-2">
                <label for="">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="mb-2">
                <label for="">Body</label>
                <textarea class="form-control" name="body"></textarea>
            </div>
            <div class="mb-2">
                <label for="">Category</label>
                <select name="category_id" id="" class="form-select">
                    @foreach ( $categories as $category )
                        <option value="{{ $category->id }}"
                        @if ($category->id === $article->category_id)
                            selected
                        @endif>
                            {{ $category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Add Article</button>
        </form>
    </div>
@endsection
