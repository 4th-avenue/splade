<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            <Link href="{{ route('categories.create') }}" class="px-4 py-2 bg-indigo-400 hover:bg-indigo-600 text-white text-sm font-medium rounded-md">
                New Category
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            Form
        </div>
    </div>
</x-app-layout>
