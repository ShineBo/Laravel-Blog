<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\Category;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail' ]);
    }

    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view('articles.index', [ 'articles' => $data ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);

        return view('articles.detail', [ 'article' => $data ]);
    }

    public function add()
    {
        $categories = Category::all();

        return view('articles.add', [
            "categories" => $categories
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required"
        ] );

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles')->with('info', "An article created");
    }

    public function edit($id)
    {
        $categories = Category::all();

        return view('articles.add', [
            "categories" => $categories
        ]);

        $articles = Article::all();

        return view('articles.edit', [
            "articles" => $articles
        ]);
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required"
        ] );

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles/details/{id}')->with('info', "Article updated");
    }


    public function delete($id)
    {
        $article = Article::find($id);

        if(Gate::allows("article-delete", $article)) {
            $article->delete();
            return redirect("/articles")->with("info", "An Article has been deleted");
        }

        return back()->with("info", "Unauthorize to delete");
    }


}
