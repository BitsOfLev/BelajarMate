@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pending Blogs</h2>
            <p class="text-sm text-gray-500 mt-1">Review and moderate flagged blog posts</p>
        </div>
        <a href="{{ route('admin.blog-moderation.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $blogs->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Banned Words</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $blogs->where('flag_reason', 'like', '%banned words%')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">With Images</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $blogs->where('flag_reason', 'like', '%image%')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Filter Tabs -->
        <div class="px-5 py-3 bg-white border-b border-gray-200">
            <div class="flex gap-2 overflow-x-auto">
                <a href="{{ route('admin.blog-moderation.pending-blogs') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ !request('filter') ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Pending
                </a>
                
                <a href="{{ route('admin.blog-moderation.pending-blogs', ['filter' => 'banned_words']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('filter') == 'banned_words' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Banned Words
                    </span>
                </a>
                
                <a href="{{ route('admin.blog-moderation.pending-blogs', ['filter' => 'images']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ request('filter') == 'images' ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        With Images
                    </span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blog Title</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flag Reason</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($blogs as $blog)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            #{{ $blog->blogID }}
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ Str::limit($blog->blogTitle, 50) }}</div>
                            @if($blog->blogImg)
                                <span class="inline-flex items-center mt-1 text-xs text-blue-600">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Has Image
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-xs">
                                    {{ strtoupper(substr($blog->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $blog->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $blog->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $blog->category->categoryName ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            @if(str_contains($blog->flag_reason, 'banned words'))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Banned Words
                                </span>
                            @endif
                            @if(str_contains($blog->flag_reason, 'image'))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 ml-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Image Review
                                </span>
                            @endif
                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($blog->flag_reason, 40) }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $blog->posted_at ? $blog->posted_at->format('M d, Y') : 'N/A' }}
                            <div class="text-xs text-gray-400">{{ $blog->posted_at ? $blog->posted_at->format('H:i A') : '' }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- View Details -->
                                <a href="{{ route('admin.blog-moderation.show-blog', $blog->blogID) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors text-sm font-medium"
                                   title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- Quick Approve -->
                                <form action="{{ route('admin.blog-moderation.approve-blog', $blog->blogID) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium"
                                            onclick="return confirm('Approve this blog?')"
                                            title="Approve">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Reject (with modal) -->
                                <button type="button"
                                        onclick="openRejectModal({{ $blog->blogID }}, '{{ addslashes($blog->blogTitle) }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm font-medium"
                                        title="Reject">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 font-medium">No pending blogs</p>
                            <p class="mt-1 text-xs text-gray-400">All blogs have been reviewed</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            {{ $blogs->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>

<!-- Reject Blog Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Reject Blog</h3>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Blog Title</label>
                    <p id="rejectBlogTitle" class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg"></p>
                </div>
                
                <div>
                    <label for="rejection_reason_select" class="block text-sm font-medium text-gray-700 mb-2">
                        Rejection Reason <span class="text-red-500">*</span>
                    </label>
                    <select id="rejection_reason_select" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select a reason...</option>
                        <option value="Inappropriate Content">Inappropriate Content</option>
                        <option value="Spam">Spam</option>
                        <option value="Offensive Language">Offensive Language</option>
                        <option value="Misleading Information">Misleading Information</option>
                        <option value="Copyright Violation">Copyright Violation</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea id="rejection_reason" 
                              name="rejection_reason" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Provide additional details about the rejection..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeRejectModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Reject Blog
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(blogId, blogTitle) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectBlogTitle').textContent = blogTitle;
    document.getElementById('rejectForm').action = `/admin/blog-moderation/blogs/${blogId}/reject`;
    document.getElementById('rejection_reason_select').value = '';
    document.getElementById('rejection_reason').value = '';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Auto-fill textarea when predefined reason is selected
document.getElementById('rejection_reason_select').addEventListener('change', function() {
    const select = this;
    const textarea = document.getElementById('rejection_reason');
    
    if (select.value && select.value !== 'Other') {
        textarea.value = select.value + ': ';
        textarea.focus();
    } else if (select.value === 'Other') {
        textarea.value = '';
        textarea.focus();
    }
});

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>

@endsection