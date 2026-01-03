@extends('admin.layouts.admin-layout')

@section('content')
<div class="p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Review Comment</h2>
            <p class="text-sm text-gray-500 mt-1">Review and moderate flagged comment</p>
        </div>
        <a href="{{ route('admin.blog-moderation.pending-comments') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Pending Comments
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content (Left - 2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Comment Content Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Comment Content</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pending Review
                        </span>
                    </div>
                </div>

                <!-- Comment Details -->
                <div class="p-6 space-y-4">
                    
                    <!-- Comment Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Comment Text</label>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-gray-900 leading-relaxed">{{ $comment->commentText }}</p>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $comment->created_at->format('M d, Y H:i A') }}
                        </span>
                    </div>

                </div>

            </div>

            <!-- Parent Blog Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Parent Blog</h3>
                </div>

                <!-- Blog Preview -->
                <div class="p-6 space-y-4">
                    
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $comment->blog->blogTitle }}</h4>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-100 text-purple-800 font-medium">
                                {{ $comment->blog->category->categoryName ?? 'Uncategorized' }}
                            </span>
                            <span>By {{ $comment->blog->user->name }}</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-700 leading-relaxed">
                            {{ Str::limit($comment->blog->blogContent, 300) }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <!-- <a href="{{ route('blog.show', $comment->blog->blogID) }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Full Blog
                        </a> -->

                        @if($comment->blog->status === 'pending')
                            <a href="{{ route('admin.blog-moderation.show-blog', $comment->blog->blogID) }}" 
                               class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Blog Also Pending
                            </a>
                        @endif
                    </div>

                </div>

            </div>

            <!-- Flag Reason Card -->
            @if($comment->flag_reason)
            <div class="bg-red-50 rounded-lg border border-red-200 overflow-hidden">
                <div class="px-6 py-4 bg-red-100 border-b border-red-200">
                    <h3 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Flagged Issues
                    </h3>
                </div>
                <div class="p-6">
                    @if(str_contains($comment->flag_reason, 'banned words'))
                        @php
                            preg_match('/Detected banned words: (.+?)$/', $comment->flag_reason, $matches);
                            $bannedWords = isset($matches[1]) ? explode(', ', trim($matches[1])) : [];
                        @endphp
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-red-200 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-red-900 mb-2">Banned Words Detected</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($bannedWords as $word)
                                        <span class="px-2 py-1 bg-red-200 text-red-900 rounded text-sm font-medium">
                                            {{ trim($word) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        <!-- Sidebar (Right - 1 column) -->
        <div class="space-y-6">
            
            <!-- Author Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Author Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-2xl flex-shrink-0">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 truncate">{{ $comment->user->name }}</h4>
                            <p class="text-sm text-gray-500 truncate">{{ $comment->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">User ID:</span>
                            <span class="font-medium text-gray-900">#{{ $comment->user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Comments:</span>
                            <span class="font-medium text-gray-900">{{ $comment->user->blogComments()->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pending:</span>
                            <span class="font-medium text-yellow-600">{{ $comment->user->blogComments()->where('status', 'pending')->count() }}</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.index') }}?search={{ $comment->user->email }}" 
                       class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View User Profile
                    </a>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Moderation Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    
                    <!-- Approve Button -->
                    <form action="{{ route('admin.blog-moderation.approve-comment', $comment->commentID) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to approve this comment? It will be published immediately.')"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Approve Comment
                        </button>
                    </form>

                    <!-- Reject Button -->
                    <button type="button"
                            onclick="openRejectModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reject Comment
                    </button>

                    <!-- Delete Button -->
                    <button type="button"
                            onclick="openDeleteModal()"
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Comment
                    </button>

                </div>
            </div>

            <!-- Info Note -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Note</p>
                        <p class="text-blue-700">Comments on pending blogs will remain hidden until the parent blog is approved.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Reject Comment Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Reject Comment</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.reject-comment', $comment->commentID) }}" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
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
                        <option value="Harassment">Harassment</option>
                        <option value="Off-Topic">Off-Topic</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Detailed Explanation <span class="text-red-500">*</span>
                    </label>
                    <textarea id="rejection_reason" 
                              name="rejection_reason" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Explain why this comment is being rejected. The user will see this message."></textarea>
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
                    Reject Comment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Comment Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Delete Comment</h3>
        </div>
        <form action="{{ route('admin.blog-moderation.delete-comment', $comment->commentID) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="px-6 py-4 space-y-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <strong>Warning:</strong> This will permanently delete this comment. This action cannot be undone.
                    </p>
                </div>
                
                <div>
                    <label for="deletion_reason_select" class="block text-sm font-medium text-gray-700 mb-2">
                        Deletion Reason <span class="text-red-500">*</span>
                    </label>
                    <select id="deletion_reason_select" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select a reason...</option>
                        <option value="Severe Policy Violation">Severe Policy Violation</option>
                        <option value="Hate Speech">Hate Speech</option>
                        <option value="Harassment or Threats">Harassment or Threats</option>
                        <option value="Spam">Spam</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label for="deletion_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Detailed Explanation <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deletion_reason" 
                              name="deletion_reason" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Explain why this comment is being deleted. The user will see this message."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Delete Permanently
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Reject Modal
    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    document.getElementById('rejection_reason_select').addEventListener('change', function() {
        const textarea = document.getElementById('rejection_reason');
        if (this.value && this.value !== 'Other') {
            textarea.value = this.value + ': ';
            textarea.focus();
        } else if (this.value === 'Other') {
            textarea.value = '';
            textarea.focus();
        }
    });

    // Delete Modal
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.getElementById('deletion_reason_select').addEventListener('change', function() {
        const textarea = document.getElementById('deletion_reason');
        if (this.value && this.value !== 'Other') {
            textarea.value = this.value + ': ';
            textarea.focus();
        } else if (this.value === 'Other') {
            textarea.value = '';
            textarea.focus();
        }
    });

    // Close modals on outside click
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>

@endsection