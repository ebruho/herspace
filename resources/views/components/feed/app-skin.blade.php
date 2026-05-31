@once
    @push('styles')
        <style>
            .app-shell {
                --app-header-h: 4rem;
                --app-sidebar-left: 17rem;
                --app-sidebar-right: 19rem;
                --app-cream: #f9f7f2;
                --app-brown: #5c4033;
                --app-brown-dark: #3d2b22;
                --app-pink: #f3d6d8;
                --app-pink-active: #e8b4bc;
            }
            .app-main-scroll {
                min-height: calc(100vh - var(--app-header-h));
            }
            @media (min-width: 1024px) {
                .app-main-scroll {
                    margin-left: var(--app-sidebar-left);
                }
            }
            @media (min-width: 1280px) {
                .app-main-scroll {
                    margin-right: var(--app-sidebar-right);
                }
            }
        </style>
    @endpush
@endonce
