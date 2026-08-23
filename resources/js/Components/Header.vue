<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const page = usePage();
const currentPath = computed(() => page.url);

const mainNavigation = [
    { name: 'Home', href: '/' },
    { name: 'About', href: '/about' },
    { name: 'Appointees', href: '/appointees' },
    { name: 'Legislative Work', href: '/legislative-work' },
    { name: 'Projects', href: '/projects' },
];

const mediaDropdown = [
    { name: 'News & Updates', href: '/news' },
    { name: 'Speeches', href: '/speeches' },
    { name: 'Publications', href: '/publications' },
    { name: 'Media Gallery', href: '/media' },
];
</script>

<template>
    <header class="bg-white border-b border-[#E2E8F0] sticky top-0 z-50 py-3" role="banner">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center h-14">
            <!-- Branding Text & Logo -->
            <Link href="/" class="flex items-center space-x-3 text-left focus:outline-none" aria-label="Home page">
                <div class="w-10 h-10 flex-shrink-0">
                    <svg viewBox="0 0 100 100" class="w-full h-full text-[#008751]" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="48" stroke="#D4AF37" stroke-width="1.5" />
                        <circle cx="50" cy="50" r="45" stroke="#008751" stroke-width="2" fill="#008751" fill-opacity="0.03" />
                        <path d="M42 22C42 22 45 15 50 15C55 15 58 22 58 22C58 22 54 21 50 21C46 21 42 22 42 22Z" fill="#D4AF37" />
                        <path d="M45 22.5L50 17L55 22.5H45Z" fill="#D4AF37" />
                        <path d="M42 32C42 30 58 30 58 32V48C58 53 50 56 50 56C50 56 42 53 42 48V32Z" fill="#172033" stroke="#D4AF37" stroke-width="1.5" />
                        <path d="M50 32V42L44 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M50 42L56 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M30 48C30 42 35 34 38 34C37 38 35 44 38 48C40 51 38 56 36 58C34 56 30 54 30 48Z" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="0.75" />
                        <path d="M70 48C70 42 65 34 62 34C63 38 65 44 62 48C60 51 62 56 64 58C66 56 70 54 70 48Z" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="0.75" />
                        <path d="M32 58C40 60 60 60 68 58C62 61 38 61 32 58Z" fill="#008751" stroke="#008751" stroke-width="2" />
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <span class="block text-[8px] font-black tracking-widest text-[#008751] uppercase leading-tight">OFFICE OF THE SPEAKER</span>
                    <span class="block text-[11px] font-extrabold text-[#172033] leading-none uppercase">House of Representatives</span>
                    <span class="block text-[8px] font-medium text-[#64748B] leading-none mt-0.5">Federal Republic of Nigeria</span>
                </div>
            </Link>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex space-x-6 items-center" aria-label="Main Navigation">
                <Link
                    v-for="item in mainNavigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href))
                            ? 'text-[#008751] border-[#008751]'
                            : 'text-[#475569] border-transparent hover:text-[#008751]',
                        'text-xs font-bold uppercase tracking-wider border-b-2 py-1.5 transition duration-150'
                    ]"
                >
                    {{ item.name }}
                </Link>

                <!-- Grouped Media Dropdown -->
                <div class="relative group py-3">
                    <button 
                        :class="[
                            mediaDropdown.some(d => currentPath.startsWith(d.href))
                                ? 'text-[#008751]'
                                : 'text-[#475569] hover:text-[#008751]',
                            'text-xs font-bold uppercase tracking-wider transition flex items-center space-x-1 focus:outline-none'
                        ]"
                    >
                        <span>Media Center</span>
                        <svg class="w-3 h-3 transform group-hover:rotate-180 transition-transform duration-150 fill-current" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <!-- Hover Dropdown Menu -->
                    <div class="absolute left-0 top-full w-48 bg-white border border-slate-100 rounded-xl shadow-lg py-2 hidden group-hover:block z-50">
                        <Link 
                            v-for="sub in mediaDropdown"
                            :key="sub.name"
                            :href="sub.href"
                            :class="[
                                currentPath.startsWith(sub.href) ? 'text-[#008751] bg-slate-50' : 'text-[#475569] hover:bg-slate-50 hover:text-[#008751]',
                                'block px-4 py-2 text-xs font-bold transition'
                            ]"
                        >
                            {{ sub.name }}
                        </Link>
                    </div>
                </div>

                <!-- Contact link -->
                <Link
                    href="/contact"
                    :class="[
                        currentPath === '/contact'
                            ? 'text-[#008751] border-[#008751]'
                            : 'text-[#475569] border-transparent hover:text-[#008751]',
                        'text-xs font-bold uppercase tracking-wider border-b-2 py-1.5 transition duration-150'
                    ]"
                >
                    Contact
                </Link>
            </nav>


        </div>
    </header>
</template>
