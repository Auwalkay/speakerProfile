<script setup lang="ts">
defineProps<{
    title?: string;
    message?: string;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-12 text-center max-w-lg mx-auto my-10 flex flex-col items-center space-y-4">
        <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100 text-slate-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="space-y-1">
            <h3 class="text-base font-bold text-[#172033]">{{ title || 'No Records Found' }}</h3>
            <p class="text-xs text-[#64748B] max-w-sm leading-relaxed mx-auto">
                {{ message || 'There are no items currently published in this section. Please check back later for official verified data.' }}
            </p>
        </div>
    </div>
</template>
