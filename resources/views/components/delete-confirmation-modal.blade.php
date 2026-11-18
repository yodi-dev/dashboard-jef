<div x-data="{
    open: false,
    action: '',
    title: '',
    itemType: 'item',
    confirmText: 'Move to Trash'
}"
@confirm-delete.window="
    action = $event.detail.action || '';
    title = $event.detail.title || 'this item';
    itemType = $event.detail.itemType || 'item';
    confirmText = $event.detail.confirmText || 'Move to Trash';
    open = true;
"
x-show="open"
x-cloak
class="fixed inset-0 z-50 overflow-y-auto"
aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-zinc-950/75 backdrop-blur-sm transition-opacity"
         @click="open = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="open"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6">
             
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-900/60 flex items-center justify-center text-red-600 dark:text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100" id="modal-title">
                        Confirm Deletion
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Are you sure you want to move <span class="font-medium text-zinc-900 dark:text-zinc-200" x-text="'&ldquo;' + title + '&rdquo;'"></span> to trash?
                    </p>
                    <p class="mt-1 text-xs text-zinc-400 dark:text-zinc-500">
                        You can restore it anytime from the Recycle Bin.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="open = false"
                    class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 rounded-lg text-sm font-medium border border-stone-200 dark:border-zinc-700 transition">
                    Cancel
                </button>
                <form :action="action" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition shadow-sm"
                        x-text="confirmText">
                        Move to Trash
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
