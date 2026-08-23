<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
    modelValue: string;
    placeholder?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
    (e: 'search', value: string): void;
}>();

const localValue = ref(props.modelValue);

watch(() => props.modelValue, (newVal) => {
    localValue.value = newVal;
});

const onInput = () => {
    emit('update:modelValue', localValue.value);
};

const onSubmit = () => {
    emit('search', localValue.value);
};
</script>

<template>
    <form @submit.prevent="onSubmit" class="relative w-full max-w-xs sm:max-w-sm">
        <label for="search-input" class="sr-only">Search portal content</label>
        <div class="relative">
            <input
                id="search-input"
                type="search"
                v-model="localValue"
                @input="onInput"
                :placeholder="placeholder || 'Search...'"
                class="w-full bg-[#F8FAFC] border border-slate-300 text-sm pl-10 pr-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033]"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </form>
</template>
