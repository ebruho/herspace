@once
    @push('styles')
        <style>
            .messages-shell {
                --app-header-h: 4rem;
                --app-sidebar-left: 17rem;
                --messages-contact-w: 18rem;
                --messages-list-w: 20rem;
            }
            .messages-main {
                min-height: calc(100vh - var(--app-header-h));
                margin-left: 0;
            }
            @media (min-width: 1024px) {
                .messages-main {
                    margin-left: var(--app-sidebar-left);
                }
            }
            .messages-grid {
                height: calc(100vh - var(--app-header-h));
            }
            @media (max-width: 1279px) {
                .messages-contact-panel { display: none; }
            }
            @media (max-width: 767px) {
                .messages-list-panel { display: none; }
            }
        </style>
    @endpush
@endonce
