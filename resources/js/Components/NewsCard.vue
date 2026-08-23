<script setup lang="ts">
interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    category?: {
        name: string;
    };
    published_at: string | null;
}

defineProps<{
    news: News;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <div class="p-6 space-y-3">
            <span class="inline-block bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                {{ news.category?.name || 'General Update' }}
            </span>
            <h3 class="text-base font-bold text-[#172033] hover:text-[#008751] transition">
                {{ news.title }}
            </h3>
            <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                {{ news.summary || 'No summary available.' }}
            </p>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
            <span>{{ news.published_at ? new Date(news.published_at).toLocaleDateString() : 'N/A' }}</span>
            <span class="text-[#008751] font-bold">Official News</span>
        </div>
    </div>
</template>
