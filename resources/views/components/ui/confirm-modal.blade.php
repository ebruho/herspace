<div
    x-data="confirmModal()"
    x-on:confirm-delete.window="open($event.detail)"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
>
    <div class="mx-4 w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
        <h3 class="font-serif text-lg font-semibold text-[#3d2b22]" x-text="title"></h3>
        <p class="mt-2 text-sm text-[#6b5b52]" x-text="message"></p>

        <div class="mt-6 flex justify-end gap-3">
            <button
                @click="isOpen = false"
                class="btn btn-ghost btn-sm rounded-full text-[#6b5b52]"
            >
                Cancel
            </button>
            <button
                @click="confirm"
                class="btn btn-sm rounded-full border-0 bg-red-500 text-white hover:bg-red-600"
            >
                Delete
            </button>
        </div>
    </div>
</div>