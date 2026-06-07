export function initModal() {
    const modal     = document.getElementById('post-modal');
    const openBtn   = document.getElementById('open-post-modal');
    const closeBtn  = document.getElementById('close-post-modal');

    if (!modal) return;

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);

    // Затвори при клик извън модала
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // Затвори с Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
}