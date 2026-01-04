<!-- Global Loading Overlay -->
<div id="globalLoadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 mb-0 text-white">Memproses...</p>
    </div>
</div>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-content {
    text-align: center;
}
</style>

<script>
// Show loading overlay
function showLoading(message = 'Memproses...') {
    const overlay = document.getElementById('globalLoadingOverlay');
    if (overlay) {
        const messageEl = overlay.querySelector('p');
        if (messageEl) messageEl.textContent = message;
        overlay.style.display = 'flex';
    }
}

// Hide loading overlay
function hideLoading() {
    const overlay = document.getElementById('globalLoadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Auto-attach to forms
document.addEventListener('DOMContentLoaded', function() {
    // Add loading to all forms with data-loading attribute
    document.querySelectorAll('form[data-loading]').forEach(function(form) {
        form.addEventListener('submit', function() {
            const message = form.dataset.loadingMessage || 'Memproses...';
            showLoading(message);
        });
    });

    // Add loading to links with data-loading attribute
    document.querySelectorAll('a[data-loading]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!link.hasAttribute('data-bs-toggle')) { // Skip Bootstrap modals/dropdowns
                const message = link.dataset.loadingMessage || 'Memuat...';
                showLoading(message);
            }
        });
    });

    // Hide loading on page unload errors
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            hideLoading();
        }
    });
});
</script>
