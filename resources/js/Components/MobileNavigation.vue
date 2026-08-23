<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface NavItem {
    name: string;
    href: string;
}

defineProps<{
    items: NavItem[];
    isOpen: boolean;
    currentPath: string;
}>();

defineEmits<{
    (e: 'close'): void;
}>();
</script>

<template>
    <div 
        v-show="isOpen" 
        class="xl:hidden border-t border-[#E2E8F0] bg-white shadow-lg animate-fade-in"
        role="dialog"
        aria-label="Mobile Navigation"
    >
        <div class="px-4 pt-2 pb-6 space-y-1 sm:px-6">
            <Link
                v-for="item in items"
                :key="item.name"
                :href="item.href"
                @click="$emit('close')"
                :class="[
                    currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href))
                        ? 'bg-[#008751]/10 text-[#008751] font-bold'
                        : 'text-[#172033] hover:bg-slate-50 hover:text-[#008751]',
                    'block px-3 py-2.5 rounded-md text-base font-semibold transition'
                ]"
            >
                {{ item.name }}
            </Link>
            <a
                href="/admin"
                class="block w-full text-center bg-[#008751] text-white hover:bg-[#008751]/90 px-4 py-3 rounded font-bold uppercase tracking-wider transition text-sm mt-4 shadow-sm"
            >
                Portal Admin
            </a>
        </div>
    </div>
</template>
