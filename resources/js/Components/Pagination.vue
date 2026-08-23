<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface LinkItem {
    url: string | null;
    label: string;
    active: boolean;
}

defineProps<{
    links: LinkItem[];
}>();
</script>

<template>
    <nav v-if="links.length > 3" class="flex justify-center mt-10" aria-label="Pagination Navigation">
        <div class="inline-flex rounded-lg border border-[#E2E8F0] bg-white p-1 space-x-1 shadow-sm">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="px-3.5 py-1.5 text-xs text-slate-300 font-medium select-none cursor-default"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :href="link.url"
                    :class="[
                        link.active
                            ? 'bg-[#008751] text-white font-bold'
                            : 'text-[#172033] hover:bg-slate-50',
                        'px-3.5 py-1.5 rounded-md text-xs font-semibold transition focus:outline-none focus:ring-1 focus:ring-[#008751]'
                    ]"
                    v-html="link.label"
                />
            </template>
        </div>
    </nav>
</template>
