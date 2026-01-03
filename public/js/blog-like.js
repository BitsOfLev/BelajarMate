// Blog Like Handler - Shared across all pages
function toggleLike(blogId, button) {
    // Prevent double clicks
    if (button.disabled) return;
    
    button.disabled = true;
    const icon = button.querySelector('i');
    const text = button.querySelector('.like-text, span');
    
    // Find the like count - it might be in different places
    let likeCount = null;
    const blogCard = button.closest('.blog-card');
    const blogContainer = button.closest('.blog-container');
    
    if (blogCard) {
        likeCount = blogCard.querySelector('.like-count');
    } else if (blogContainer) {
        likeCount = button.querySelector('span'); // In show.blade.php, count is inside button
    }
    
    // Show loading state
    const originalIconClass = icon.className;
    const originalText = text ? text.textContent : '';
    icon.className = 'bi bi-hourglass-split';
    
    fetch(`/blog/${blogId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.liked) {
            // Liked
            button.classList.add('liked');
            icon.className = 'bi bi-hand-thumbs-up-fill';
            if (text) {
                // Check if we're on show page (has count in text) or feed page
                if (originalText.includes('Like')) {
                    text.textContent = data.count + ' ' + (data.count === 1 ? 'Like' : 'Likes');
                } else {
                    text.textContent = 'Liked';
                }
            }
        } else {
            // Unliked
            button.classList.remove('liked');
            icon.className = 'bi bi-hand-thumbs-up';
            if (text) {
                if (originalText.includes('Like')) {
                    text.textContent = data.count + ' ' + (data.count === 1 ? 'Like' : 'Likes');
                } else {
                    text.textContent = 'Like';
                }
            }
        }
        
        // Update like count if it exists separately
        if (likeCount && !likeCount.closest('button')) {
            likeCount.classList.add('updating');
            likeCount.textContent = data.count;
            setTimeout(() => {
                likeCount.classList.remove('updating');
            }, 300);
        }
        
        // Add a small animation to the button
        button.style.transform = 'scale(1.1)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 200);
    })
    .catch(error => {
        console.error('Error:', error);
        // Restore original state on error
        icon.className = originalIconClass;
        if (text) text.textContent = originalText;
        
        // Show error message
        alert('Failed to like/unlike. Please try again.');
    })
    .finally(() => {
        button.disabled = false;
    });
}

function openReportModal(blogId, type, commentId = null) {
    if (type === 'blog') {
        document.getElementById('reportBlogID').value = blogId || '';
        document.getElementById('reportCommentID').value = '';
    } else {
        document.getElementById('reportCommentID').value = commentId || '';
        document.getElementById('reportBlogID').value = '';
    }
    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('reportModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeReportModal();
            }
        });
    }
});