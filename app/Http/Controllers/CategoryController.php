<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => SpladeTable::for(Category::class)
                ->column('name', canBeHidden: false, sortable: true)
                ->withGlobalSearch(columns: ['name'])
                ->column('slug')
                ->column('action')
                ->paginate(5),
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());
        Toast::title('새 카테고리를 저장했습니다!');

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryStoreRequest $request, Category $category)
    {
        $category->update($request->validated());
        Toast::title('카테고리를 수정했습니다!');

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Toast::success('카테고리를 삭제했습니다!');

        return redirect()->back();
    }
}
