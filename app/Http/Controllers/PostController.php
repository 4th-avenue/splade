<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => SpladeTable::for(Post::class)
                ->column('title', canBeHidden: false, sortable: true)
                ->withGlobalSearch(columns: ['title'])
                ->column('slug')
                ->paginate(5),
        ]);
    }
}
