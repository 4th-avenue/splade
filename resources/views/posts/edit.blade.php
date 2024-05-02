<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-splade-form :default="$post" method="PUT" :action="route('posts.update', $post->id)" class="max-w-md mx-auto p-4 bg-white rounded-md">
                <x-splade-select name="category_id" label="Category" :options="$categories" />
                <x-splade-input name="title" label="Title" class="mt-2" />
                <x-splade-input name="slug" label="Slug" class="mt-2" />
                <x-splade-textarea name="description" label="Description" autosize class="mt-2" />
                <x-splade-submit class="mt-4" />
            </x-splade-form>
        </div>
    </div>
</x-app-layout>
