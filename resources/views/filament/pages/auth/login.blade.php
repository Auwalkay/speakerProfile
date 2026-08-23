<div style="display: flex; min-height: 100vh; flex-flow: row wrap; background-color: #F8FAFC;">
    <style>
        /* Force elegant light-mode styling on the form components to prevent dark mode color collision */
        .login-right-panel label, 
        .login-right-panel .fi-fo-field-wrp-label span,
        .login-right-panel .fi-fo-field-wrp-label {
            color: #172033 !important;
            font-weight: 700 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
        .login-right-panel .fi-input-wrp {
            background-color: #FFFFFF !important;
            border-color: #CBD5E1 !important;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05) !important;
            border-radius: 0.5rem !important;
        }
        .login-right-panel .fi-input-wrp:focus-within {
            border-color: #008751 !important;
            outline: 2px solid #008751 !important;
            outline-offset: -1px !important;
        }
        .login-right-panel input {
            color: #172033 !important;
            background-color: transparent !important;
            font-size: 0.875rem !important;
        }
        .login-right-panel a {
            color: #008751 !important;
            font-weight: 700 !important;
            font-size: 0.75rem !important;
        }
        .login-right-panel a:hover {
            text-decoration: underline !important;
        }
        .login-right-panel .fi-checkbox-label {
            color: #172033 !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
        }
        /* Style validation errors */
        .login-right-panel .fi-fo-error-message {
            color: #EF4444 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            margin-top: 0.25rem !important;
        }
    </style>

    <!-- Left Side Panel: Nigerian Government-Inspired Presentation (58% width on desktop) -->
    <div style="flex: 1 1 58%; min-width: 360px; display: flex; flex-direction: column; justify-content: space-between; padding: 4rem 3rem; color: #FFFFFF; position: relative; overflow: hidden; background-color: #172033;">
        <!-- High-Quality Cover Image -->
        <img 
            src="/images/national_assembly.png" 
            alt="National Assembly Complex, Abuja" 
            class="absolute inset-0 w-full h-full object-cover opacity-30 select-none pointer-events-none"
            style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;"
        />
        
        <!-- Subtle dark overlay and green/gold accent layers -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#172033] via-[#172033]/85 to-transparent pointer-events-none" style="position: absolute; inset: 0; pointer-events: none;"></div>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; bg-gradient-to-r: from-[#008751] via-[#D4AF37] to-[#008751]; background: linear-gradient(to right, #008751, #D4AF37, #008751); pointer-events: none;"></div>
        
        <!-- Geometric patterned overlays -->
        <div class="absolute inset-0 opacity-5 pointer-events-none mix-blend-overlay" style="position: absolute; inset: 0; opacity: 0.03; pointer-events: none;">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFFFFF" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <!-- Left Side Header Info -->
        <a href="/" class="flex items-center space-x-3 z-10 hover:opacity-90 transition" style="position: relative; z-index: 10; display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div class="w-12 h-12 bg-white/5 rounded-full border border-white/10 flex items-center justify-center flex-shrink-0" style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg viewBox="0 0 100 100" class="w-8 h-8 text-[#D4AF37]" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 2rem; height: 2rem;">
                    <circle cx="50" cy="50" r="48" stroke="#D4AF37" stroke-width="1.5" />
                    <path d="M42 22C42 22 45 15 50 15C55 15 58 22 58 22Z" fill="#D4AF37" />
                    <path d="M45 22.5L50 17L55 22.5H45Z" fill="#D4AF37" />
                    <path d="M42 32C42 30 58 30 58 32V48C58 53 50 56 50 56C50 56 42 53 42 48V32Z" fill="#FFFFFF" stroke="#D4AF37" stroke-width="1.5" />
                    <path d="M50 32V42L44 48" stroke="#008751" stroke-width="2" stroke-linecap="round" />
                    <path d="M50 42L56 48" stroke="#008751" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <div>
                <span class="block text-[11px] font-black tracking-widest text-[#D4AF37] uppercase" style="display: block; font-size: 11px; font-weight: 900; letter-spacing: 0.1em; color: #D4AF37; text-transform: uppercase; text-align: left;">Speaker Achievement Portal</span>
                <span class="block text-[9px] font-semibold text-slate-300 uppercase" style="display: block; font-size: 9px; font-weight: 600; color: #CBD5E1; text-transform: uppercase; text-align: left;">Federal Republic of Nigeria</span>
            </div>
        </a>

        <!-- Core Mission / Quote Statement Overlay -->
        <div class="space-y-6 max-w-xl z-10" style="position: relative; z-index: 10; margin-top: 4rem; margin-bottom: 4rem; max-width: 36rem;">
            <div style="margin-bottom: 1.5rem;">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight uppercase" style="font-size: 2rem; font-weight: 800; color: #FFFFFF; line-height: 1.2; text-transform: uppercase;">
                    Office of the Speaker
                </h1>
                <p style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.05em; color: #008751; text-transform: uppercase; margin-top: 0.25rem;">
                    House of Representatives
                </p>
            </div>
            <p style="font-size: 1rem; color: #E2E8F0; line-height: 1.6; font-style: italic;">
                "Secure access to the administration and management platform."
            </p>
        </div>

        <!-- Footer indicator label -->
        <div class="flex items-center space-x-2 text-[10px] text-slate-400 font-semibold tracking-wider uppercase z-10" style="position: relative; z-index: 10; display: flex; align-items: center; gap: 0.5rem; font-size: 10px; font-weight: 600; letter-spacing: 0.05em; color: #94A3B8; text-transform: uppercase;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 9999px; background-color: #008751;"></span>
            <span>Official Administrative Portal</span>
        </div>
    </div>

    <!-- Right Side: White Authentication Panel (42% width on desktop) -->
    <div class="login-right-panel" style="flex: 1 1 42%; min-width: 360px; display: flex; align-items: center; justify-content: center; padding: 3rem 2rem;">
        <div class="w-full max-w-sm bg-white p-8 sm:p-10 rounded-2xl border border-slate-100 shadow-sm space-y-8" style="width: 100%; max-width: 400px; background-color: #FFFFFF; padding: 2.5rem; border-radius: 1rem; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);">
            <!-- Branding Header Logo -->
            <div class="space-y-4" style="text-align: center; margin-bottom: 2rem;">
                <a href="/" class="w-16 h-16 mx-auto block hover:opacity-90 transition" style="width: 4rem; height: 4rem; margin-left: auto; margin-right: auto; margin-bottom: 1rem; display: block;">
                    <svg viewBox="0 0 100 100" class="w-full h-full text-[#008751]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="48" stroke="#D4AF37" stroke-width="1.5" />
                        <circle cx="50" cy="50" r="45" stroke="#008751" stroke-width="2" fill="#008751" fill-opacity="0.03" />
                        <path d="M42 22C42 22 45 15 50 15C55 15 58 22 58 22C58 22 54 21 50 21C46 21 42 22 42 22Z" fill="#D4AF37" />
                        <path d="M45 22.5L50 17L55 22.5H45Z" fill="#D4AF37" />
                        <path d="M42 32C42 30 58 30 58 32V48C58 53 50 56 50 56C50 56 42 53 42 48V32Z" fill="#172033" stroke="#D4AF37" stroke-width="1.5" />
                        <path d="M50 32V42L44 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M50 42L56 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                </a>
                <div style="text-align: center;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #172033; letter-spacing: -0.025em; text-transform: uppercase; margin-bottom: 0.5rem;">Welcome Back</h2>
                    <p style="font-size: 0.75rem; color: #64748B; font-weight: 600;">
                        Sign in to access the administration portal.
                    </p>
                </div>
            </div>

            <!-- Login Form Fields -->
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form }}

                <div class="pt-4 space-y-4" style="margin-top: 1.5rem;">
                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="true"
                    />

                    <!-- Security indicators -->
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.375rem; font-size: 9px; color: #008751; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 1rem;">
                        <svg style="width: 0.875rem; height: 0.875rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                        </svg>
                        <span>Secure administrative access</span>
                    </div>

                    <div style="display: flex; align-items: center; margin-top: 1rem;">
                        <div style="flex-grow: 1; border-t: 1px solid #F1F5F9; height: 1px; background-color: #F1F5F9;"></div>
                        <span style="padding-left: 0.75rem; padding-right: 0.75rem; font-size: 8px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.1em;">Authorized personnel only</span>
                        <div style="flex-grow: 1; border-t: 1px solid #F1F5F9; height: 1px; background-color: #F1F5F9;"></div>
                    </div>
                </div>
            </x-filament-panels::form>
        </div>
    </div>
</div>
