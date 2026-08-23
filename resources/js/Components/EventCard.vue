<script setup lang="ts">
interface Event {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    starts_at: string | null;
    ends_at: string | null;
    location: string | null;
}

defineProps<{
    event: Event;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <div class="p-6 space-y-4">
            <span class="inline-block bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                Event
            </span>
            <div class="space-y-2">
                <h3 class="text-base font-bold text-[#172033] hover:text-[#008751] transition">
                    {{ event.title }}
                </h3>
                <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                    {{ event.description || 'No description provided.' }}
                </p>
            </div>
            
            <div class="pt-3 border-t border-slate-100 text-[10px] text-[#64748B] space-y-1">
                <div class="flex items-center space-x-2">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-bold text-[#172033]">
                        {{ event.starts_at ? new Date(event.starts_at).toLocaleString() : 'N/A' }}
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-bold text-[#172033]">{{ event.location || 'N/A' }}</span>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
            <span>Verified Official Event</span>
            <span class="text-[#008751] font-bold">Upcoming</span>
        </div>
    </div>
</template>
