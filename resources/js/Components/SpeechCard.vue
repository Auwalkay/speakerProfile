<script setup lang="ts">
interface Speech {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    delivered_at: string | null;
    location: string | null;
}

defineProps<{
    speech: Speech;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <div class="p-6 space-y-3">
            <span class="inline-block bg-[#D4AF37]/15 text-[#D4AF37] border border-[#D4AF37]/30 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                Official Address
            </span>
            <h3 class="text-base font-bold text-[#172033] hover:text-[#008751] transition">
                {{ speech.title }}
            </h3>
            <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                {{ speech.summary || 'No summary available.' }}
            </p>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
            <span>Delivered: {{ speech.delivered_at ? new Date(speech.delivered_at).toLocaleDateString() : 'N/A' }}</span>
            <span class="text-[#008751] font-bold">{{ speech.location || 'Nigeria' }}</span>
        </div>
    </div>
</template>
