<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PostController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('title', 'LIKE', "%{$value}%")
                        ->orWhere('slug', 'LIKE', "%{$value}%");
                });
            });
        });

        $posts = QueryBuilder::for(Post::class)
        ->defaultSort('title')
        ->allowedSorts(['title', 'slug'])
        ->allowedFilters(['title', 'slug', $globalSearch]);

        return view('posts.index', [
            'posts' => SpladeTable::for($posts)
                ->column('title', canBeHidden: false, sortable: true)
                ->withGlobalSearch(columns: ['title'])
                ->column('slug', sortable: true)
                ->paginate(5),
        ]);
    }
}
