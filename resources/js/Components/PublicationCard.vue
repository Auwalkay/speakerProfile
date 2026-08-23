<script setup lang="ts">
interface Publication {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    document_path: string | null;
    published_at: string | null;
}

defineProps<{
    publication: Publication;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <div class="p-6 space-y-3">
            <span class="inline-block bg-[#172033]/5 text-[#172033] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                Official Document
            </span>
            <h3 class="text-base font-bold text-[#172033] hover:text-[#008751] transition">
                {{ publication.title }}
            </h3>
            <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                {{ publication.summary || 'No summary description available for this publication.' }}
            </p>
        </div>
        <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
            <span>Published: {{ publication.published_at ? new Date(publication.published_at).toLocaleDateString() : 'N/A' }}</span>
            <a 
                :href="publication.document_path || '#'" 
                target="_blank"
                class="inline-flex items-center space-x-1 text-[#008751] font-bold hover:underline"
            >
                <span>Download PDF (DEMO)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </a>
        </div>
    </div>
</template>
