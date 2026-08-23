<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    currentPath: string;
}>();
</script>

<template>
    <nav class="hidden xl:flex space-x-8 items-center" aria-label="Main Navigation">
        <!-- Home -->
        <Link
            href="/"
            :class="[
                currentPath === '/'
                    ? 'border-[#008751] text-[#008751]'
                    : 'border-transparent text-[#172033] hover:text-[#008751]',
                'text-[13px] font-bold border-b-2 py-2 transition duration-150 uppercase tracking-wider'
            ]"
        >
            Home
        </Link>

        <!-- Achievements -->
        <Link
            href="/achievements"
            :class="[
                currentPath.startsWith('/achievements')
                    ? 'border-[#008751] text-[#008751]'
                    : 'border-transparent text-[#172033] hover:text-[#008751]',
                'text-[13px] font-bold border-b-2 py-2 transition duration-150 uppercase tracking-wider'
            ]"
        >
            Achievements
        </Link>

        <!-- Projects -->
        <Link
            href="/projects"
            :class="[
                currentPath.startsWith('/projects')
                    ? 'border-[#008751] text-[#008751]'
                    : 'border-transparent text-[#172033] hover:text-[#008751]',
                'text-[13px] font-bold border-b-2 py-2 transition duration-150 uppercase tracking-wider'
            ]"
        >
            Projects
        </Link>

        <!-- News -->
        <Link
            href="/news"
            :class="[
                currentPath.startsWith('/news')
                    ? 'border-[#008751] text-[#008751]'
                    : 'border-transparent text-[#172033] hover:text-[#008751]',
                'text-[13px] font-bold border-b-2 py-2 transition duration-150 uppercase tracking-wider'
            ]"
        >
            News
        </Link>

        <!-- Dropdown: Legislation -->
        <div class="relative group py-2">
            <button
                class="flex items-center space-x-1 text-[13px] font-bold text-[#172033] hover:text-[#008751] uppercase tracking-wider focus:outline-none"
                :class="{ 'text-[#008751]': ['/legislative-work', '/speeches', '/publications'].some(p => currentPath.startsWith(p)) }"
            >
                <span>Legislation</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white border border-[#E2E8F0] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <Link
                        href="/legislative-work"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Bills & Motions
                    </Link>
                    <Link
                        href="/speeches"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Speeches & Addresses
                    </Link>
                    <Link
                        href="/publications"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Publications
                    </Link>
                </div>
            </div>
        </div>

        <!-- Dropdown: Activities -->
        <div class="relative group py-2">
            <button
                class="flex items-center space-x-1 text-[13px] font-bold text-[#172033] hover:text-[#008751] uppercase tracking-wider focus:outline-none"
                :class="{ 'text-[#008751]': ['/events', '/media'].some(p => currentPath.startsWith(p)) }"
            >
                <span>Media & Events</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white border border-[#E2E8F0] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <Link
                        href="/events"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Upcoming Events
                    </Link>
                    <Link
                        href="/media"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Media Gallery
                    </Link>
                </div>
            </div>
        </div>

        <!-- Dropdown: Information -->
        <div class="relative group py-2">
            <button
                class="flex items-center space-x-1 text-[13px] font-bold text-[#172033] hover:text-[#008751] uppercase tracking-wider focus:outline-none"
                :class="{ 'text-[#008751]': ['/about', '/contact'].some(p => currentPath.startsWith(p)) }"
            >
                <span>Information</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white border border-[#E2E8F0] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-1">
                    <Link
                        href="/about"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        About the Office
                    </Link>
                    <Link
                        href="/contact"
                        class="block px-4 py-2 text-xs font-bold text-[#172033] hover:bg-slate-50 hover:text-[#008751]"
                    >
                        Contact & Feedback
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
