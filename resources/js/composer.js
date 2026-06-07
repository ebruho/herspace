export function initComposer() {
    const imageBtn     = document.getElementById('image-btn');
    const imageInput   = document.getElementById('post-image');
    const imagePreview = document.getElementById('image-preview');
    const form         = imageInput?.closest('form');

    if (!imageBtn || !imageInput || !imagePreview || !form) return;

    let fileList = [];

    imageBtn.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function () {
        Array.from(this.files).forEach(newFile => {
            const exists = fileList.some(f => f.name === newFile.name && f.size === newFile.size);
            if (!exists) fileList.push(newFile);
        });

        if (fileList.length > 5) fileList = fileList.slice(0, 5);

        renderPreviews(fileList);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const invalidFiles = fileList.filter(f => !allowedTypes.includes(f.type));

        if (invalidFiles.length > 0) {
            showAlert(`Unsupported file type: ${invalidFiles.map(f => f.name).join(', ')}. Please use JPG, PNG, GIF or WebP.`, 'error');
            return;
        }

        const formData = new FormData(form);
        formData.delete('images[]');
        fileList.forEach(file => formData.append('images[]', file));

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    ?? form.querySelector('input[name="_token"]')?.value,
            },
        })
        .then(res => {
            if (res.status === 422) {
                return res.json().then(data => {
                    const errors = Object.values(data.errors).flat();
                    showAlert(errors.join('\n'), 'error');
                });
            }
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }
            window.location.reload();
        })
        .catch(err => console.error('Upload error:', err));
    });

    function renderPreviews(files) {
        imagePreview.innerHTML = '';

        if (files.length === 0) {
            imagePreview.classList.add('hidden');
            return;
        }

        imagePreview.classList.remove('hidden');

        files.forEach((file, index) => {
            const reader  = new FileReader();
            const wrapper = document.createElement('div');
            wrapper.className = 'relative group';

            reader.onload = function (e) {
                wrapper.innerHTML = `
                    <img src="${e.target.result}" class="h-32 w-full rounded-xl object-cover">
                    <input
                        type="text"
                        name="captions[${index}]"
                        placeholder="Caption (optional)"
                        class="mt-1 w-full rounded-lg border border-[#ebe4dc] bg-[#f5efe8] px-2 py-1 text-xs text-[#6b5b52]"
                    >
                    <button
                        type="button"
                        data-index="${index}"
                        class="remove-img absolute top-1 right-1 flex h-6 w-6 items-center justify-center rounded-full bg-black/60 text-white opacity-0 group-hover:opacity-100 transition"
                        aria-label="Remove image"
                    >
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M18 6 6 18M6 6l12 12"/>
                        </svg>
                    </button>
                `;

                wrapper.querySelector('.remove-img').addEventListener('click', function () {
                    files.splice(parseInt(this.dataset.index), 1);
                    renderPreviews(files);
                });
            };

            reader.readAsDataURL(file);
            imagePreview.appendChild(wrapper);
        });
    }

    function showAlert(message, type = 'success') {
        document.getElementById('composer-alert')?.remove();

        const el = document.createElement('div');
        el.id = 'composer-alert';
        el.className = type === 'error'
            ? 'mb-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700'
            : 'mb-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700';
        el.textContent = message;

        form.insertBefore(el, form.firstChild);
        setTimeout(() => el.remove(), 4000);
    }
}