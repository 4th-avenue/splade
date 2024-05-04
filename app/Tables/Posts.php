<?php

namespace App\Tables;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;

class Posts extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Post::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
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
            ->allowedSorts(['id', 'title', 'slug'])
            ->allowedFilters(['title', 'slug', 'category_id', $globalSearch]);

        $categories = Category::pluck('name', 'id')->toArray();

        $table
            ->column('id', sortable: true)
            ->column('title', canBeHidden: false, sortable: true)
            ->withGlobalSearch(columns: ['title'])
            ->column('slug', sortable: true)
            ->column('updated_at')
            ->column('action', exportAs: false)
            ->bulkAction(
                label: 'Touch timestamp',
                each: fn (Post $post) => $post->touch(),
                before: fn () => info('Touching the selected posts'),
                after: fn () => Toast::info('Timestamps updated!')
            )
            ->bulkAction(
                label: 'Delete Posts',
                each: fn (Post $post) => $post->delete(),
                confirm: 'Delete Posts',
                confirmText: 'Are you sure you want to delete the posts?',
                confirmButton: 'Yes',
                cancelButton: 'No',
                after: fn () => Toast::info('Posts Deleted!')
            )
            ->export(label: 'CSV Export', filename: 'posts.csv',  type: Excel::CSV)
            ->selectFilter('category_id', $categories)
            ->paginate(5);
    }
}
