@extends('esport.admin.layouts.app')

@section('title', 'News Management - E-sport Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">News Management</h1>
            <p class="text-gray-600">Manage E-sport news and announcements</p>
        </div>
        <a href="{{ route('esport.admin.news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition inline-flex items-center">
            <i class="fas fa-plus mr-2"></i> Add News
        </a>
    </div>

    @if (session('success') || session('ok'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') ?? session('ok') }}
        </div>
    @endif

    <!-- News Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rows as $news)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($news->image)
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="h-12 w-20 object-cover rounded">
                                @else
                                    <div class="h-12 w-20 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $news->title }}</div>
                                <div class="text-xs text-gray-500 line-clamp-1">{{ $news->excerpt ?? Str::limit($news->content, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 capitalize">
                                    {{ $news->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($news->is_featured)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i> Featured
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $news->created_at ? $news->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('esport.admin.news.edit', $news) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('esport.admin.news.destroy', $news) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-newspaper text-3xl text-gray-300 mb-2"></i>
                                <p>No news articles found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rows->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $rows->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
