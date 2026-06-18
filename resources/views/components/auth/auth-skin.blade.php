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
            #city-select-wrap .ts-wrapper {
                width: 100%;
            }
            #city-select-wrap .ts-wrapper.loading {
                display: block !important;
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                aspect-ratio: auto !important;
                background: transparent !important;
                color: inherit !important;
                pointer-events: auto !important;
                mask: none !important;
                -webkit-mask: none !important;
                animation: none !important;
            }
            #city-select-wrap .ts-control {
                min-height: 3.25rem;
                padding: 0.65rem 1rem;
                border-radius: 1.5rem;
                border: 1.5px solid transparent;
                background: #ebe8e2;
                box-shadow: 0 2px 8px rgba(58, 53, 50, 0.04);
                font-family: "DM Sans", system-ui, sans-serif;
                font-size: 0.9rem;
            }
            #city-select-wrap .ts-control.focus {
                border-color: #3a9b9b;
                background: #fdfcf9;
                box-shadow: 0 0 0 3px rgba(58, 155, 155, 0.15);
            }
            #city-select-wrap.has-server-err .ts-control,
            .auth-select-wrap.has-server-err .ts-control {
                border-color: #c73e3e !important;
                background: #fffbfb !important;
            }
            #city-select-wrap .ts-dropdown {
                border-radius: 1rem;
                border-color: rgba(58, 155, 155, 0.22);
                overflow: hidden;
            }
            #city-select-wrap .ts-dropdown .option.active {
                background: rgba(58, 155, 155, 0.12);
                color: #2e7d7d;
            }
            #city-select-wrap .ts-dropdown .spinner {
                display: flex;
                width: 1rem;
                height: 1rem;
                margin: 0.65rem auto;
                align-items: center;
                justify-content: center;
            }
            #city-select-wrap .ts-dropdown .spinner::after {
                width: 0.85rem;
                height: 0.85rem;
                margin: 0;
                border-width: 2px;
                border-color: #8b7355 transparent #8b7355 transparent;
            }
        </style>
    @endpush
@endonce
