@extends('esport.admin.layouts.app')

@section('title', 'Add News - E-sport Admin')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <a href="{{ route('esport.admin.news.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to News List
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Add New Article</h1>
        <p class="text-gray-600">Create a new announcement or news item for E-sport</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl">
        <form action="{{ route('esport.admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select id="category" name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            @foreach(config('esport.news.categories') ?? config('esport.news_categories') as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Excerpt (Optional)</label>
                    <textarea id="excerpt" name="excerpt" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="8" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700 font-medium">Pin as Featured News</label>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('esport.admin.news.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Publish News</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
