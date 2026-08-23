<script setup lang="ts">
defineProps<{
    label: string;
    value: string | number;
    description?: string;
    iconBg?: string;
}>();
</script>

<template>
    <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex items-center space-x-4">
        <div :class="[iconBg || 'bg-[#008751]/10 text-[#008751]', 'w-12 h-12 rounded-lg flex items-center justify-center text-lg font-extrabold']">
            #
        </div>
        <div>
            <span class="block text-xs font-semibold text-[#64748B] uppercase tracking-wider">{{ label }}</span>
            <span class="block text-xl font-extrabold text-[#172033]">{{ value }}</span>
            <span v-if="description" class="block text-[10px] text-slate-400 mt-0.5">{{ description }}</span>
        </div>
    </div>
</template>
