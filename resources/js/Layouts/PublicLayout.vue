<script setup lang="ts">
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Header from '../Components/Header.vue';
import Footer from '../Components/Footer.vue';

defineProps<{
    title?: string;
}>();

const page = usePage();
const currentPath = computed(() => page.url);
</script>

<template>
    <Head :title="title ? `${title} - Office of the Speaker` : 'Office of the Speaker of the House of Representatives'" />

    <div class="min-h-screen flex flex-col bg-[#F8FAFC] text-[#172033] font-sans antialiased selection:bg-[#008751] selection:text-white">
        <!-- Top Institutional Bar -->
        <div class="bg-[#172033] text-white py-2 px-4 sm:px-6 lg:px-8 border-b-2 border-[#D4AF37] text-[11px] font-semibold tracking-wider flex justify-between items-center">
            <div class="hidden md:flex space-x-4">
                <a href="https://nass.gov.ng" target="_blank" class="hover:text-[#D4AF37] transition duration-150">National Assembly</a>
                <span class="text-gray-500">|</span>
                <a href="https://statehouse.gov.ng" target="_blank" class="hover:text-[#D4AF37] transition duration-150">State House</a>
            </div>
        </div>

        <!-- Modular Header -->
        <Header />

        <!-- Page Content Wrapper -->
        <main class="flex-grow w-full" id="main-content">
            <!-- Full width layout for welcome page -->
            <div v-if="currentPath === '/'" class="w-full">
                <slot />
            </div>
            <!-- Padded container layout for standard sub-pages -->
            <div v-else class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
                <slot />
            </div>
        </main>

        <!-- Modular Footer -->
        <Footer />
    </div>
</template>
