<script setup lang="ts">
interface Option {
    value: string | number;
    label: string;
}

defineProps<{
    modelValue: string | number;
    options: Option[];
    label?: string;
    placeholder?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number): void;
}>();

const onChange = (event: Event) => {
    const value = (event.target as HTMLSelectElement).value;
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="flex flex-col space-y-1.5 w-full max-w-xs">
        <label v-if="label" class="text-xs font-bold text-[#172033] uppercase tracking-wider">{{ label }}</label>
        <select
            :value="modelValue"
            @change="onChange"
            class="bg-white border border-slate-300 text-xs px-3.5 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033] font-semibold"
        >
            <option value="">{{ placeholder || 'Select option' }}</option>
            <option v-for="opt in options" :key="opt.value" :value="opt.value">
                {{ opt.label }}
            </option>
        </select>
    </div>
</template>
