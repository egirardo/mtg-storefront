<dialog id="delete-confirm-modal" class="rounded-2xl shadow-2xl p-8 w-full max-w-md backdrop:bg-black/50 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
    <h2 class="text-xl font-bold text-gray-900 mb-2">Delete Product</h2>
    <p id="delete-modal-description" class="text-sm text-gray-600 mb-6"></p>

    <div class="flex gap-3">
        <button id="delete-modal-cancel" type="button" autofocus
            class="flex-1 px-4 py-2.5 rounded-lg border-2 border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-blue-700">
            Cancel
        </button>
        <button id="delete-modal-confirm" type="button"
            class="flex-1 px-4 py-2.5 rounded-lg bg-red-700 text-sm font-semibold text-white hover:bg-red-800 focus:outline-2 focus:outline-offset-2 focus:outline-red-700">
            Yes, delete
        </button>
    </div>
</dialog>

<script>
    (function() {
        var modal = document.getElementById('delete-confirm-modal');
        var confirmBtn = document.getElementById('delete-modal-confirm');
        var cancelBtn = document.getElementById('delete-modal-cancel');
        var activeForm = null;

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('[data-delete-form]');
            if (!trigger) return;
            activeForm = document.getElementById(trigger.dataset.deleteForm);
            var name = trigger.dataset.productName;
            document.getElementById('delete-modal-description').textContent =
                name ? 'Are you sure you want to delete "' + name + '"? This cannot be undone.' :
                'Are you sure you want to delete this product? This cannot be undone.';
            modal.showModal();
        });

        cancelBtn.addEventListener('click', function() {
            modal.close();
        });
        confirmBtn.addEventListener('click', function() {
            modal.close();
            if (activeForm) activeForm.submit();
        });
    }());
</script>