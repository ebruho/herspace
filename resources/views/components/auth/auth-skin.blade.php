@once
    @push('styles')
        <style>
            .auth-grid-2 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.1rem 1.25rem;
            }
            @media (max-width: 640px) {
                .auth-grid-2 { grid-template-columns: 1fr; }
            }
            .auth-input-shell { position: relative; }
            .auth-input-shell > input,
            .auth-input-shell > select,
            .auth-input-shell > textarea {
                width: 100%;
                padding-right: 2.75rem;
            }
            .auth-input-shell > input.pr-4,
            .auth-input-shell > textarea { padding-right: 1rem; }
            .auth-input-shell .auth-input-icon {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                display: none;
            }
            .auth-input-shell.show-ok .auth-input-icon.auth-icon-ok { display: block; }
            .auth-input-shell.show-warn .auth-input-icon.auth-icon-warn { display: block; }
            .auth-input-shell.has-server-err .auth-input-icon { display: none !important; }
            .auth-input-shell.has-error input,
            .auth-input-shell.has-error textarea,
            .auth-input-shell.has-error select,
            .auth-input-shell.has-server-err input,
            .auth-input-shell.has-server-err textarea,
            .auth-input-shell.has-server-err select {
                border-color: #C73E3E !important;
                background: #fffbfb !important;
            }
            .auth-select-wrap select { appearance: none; cursor: pointer; padding-right: 2.5rem; }
            .auth-select-wrap .auth-chevron {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                color: #6b6560;
            }
            .auth-photo-ring {
                position: relative;
                width: 104px;
                height: 104px;
                border-radius: 9999px;
                background: #d8d4ce;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 24px rgba(58, 53, 50, 0.08);
            }
            .auth-photo-edit {
                position: absolute;
                right: 2px;
                bottom: 2px;
                width: 32px;
                height: 32px;
                border-radius: 9999px;
                background: #e8b4bc;
                border: 3px solid #f7f4ef;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #fff;
            }
            input.auth-file-hidden {
                position: absolute;
                width: 1px;
                height: 1px;
                opacity: 0;
                pointer-events: none;
            }
        </style>
    @endpush
@endonce
