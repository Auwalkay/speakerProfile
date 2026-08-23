<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div class="flex flex-col items-center justify-center py-16 space-y-4">
        <div class="w-10 h-10 border-4 border-[#008751]/20 border-t-[#008751] rounded-full animate-spin"></div>
        <p class="text-xs font-semibold text-[#64748B] tracking-wide uppercase">{{ message || 'Loading verified database records...' }}</p>
    </div>
</template>
