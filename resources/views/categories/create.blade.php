<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-splade-form :action="route('categories.store')" class="max-w-md mx-auto p-4 bg-white rounded-md">
                <x-splade-input name="name" label="Name" autocomplete="off" />
                <x-splade-input name="slug" label="Slug" autocomplete="off" class="mt-2" />
                <x-splade-submit class="mt-4" />
            </x-splade-form>
        </div>
    </div>
</x-app-layout>
