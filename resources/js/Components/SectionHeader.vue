<script setup lang="ts">
defineProps<{
    title: string;
    subtitle?: string;
}>();
</script>

<template>
    <div class="border-b border-[#E2E8F0] pb-5 mb-8">
        <h2 class="text-2xl font-extrabold text-[#172033] tracking-tight">
            {{ title }}
        </h2>
        <p v-if="subtitle" class="mt-1.5 text-xs sm:text-sm text-[#64748B] font-medium">
            {{ subtitle }}
        </p>
    </div>
</template>
