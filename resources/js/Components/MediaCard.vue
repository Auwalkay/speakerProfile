<script setup lang="ts">
interface Media {
    id: number;
    title: string;
    file_path: string | null;
    type: string; // image, video, audio
    album?: {
        title: string;
    };
}

defineProps<{
    media: Media;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <!-- Media Type Wrapper/Placeholder -->
        <div class="bg-slate-100 aspect-video flex items-center justify-center relative border-b border-slate-100">
            <!-- Icon overlays -->
            <div class="absolute top-3 left-3 bg-[#172033]/80 backdrop-blur-sm text-white px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider">
                {{ media.type }}
            </div>
            
            <div class="text-slate-400 flex flex-col items-center space-y-1">
                <svg v-if="media.type === 'video'" class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg v-else-if="media.type === 'audio'" class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <svg v-else class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-[9px] font-bold tracking-wider uppercase">Official Media Resource</span>
            </div>
        </div>

        <div class="p-5 space-y-1">
            <span class="text-[9px] font-semibold text-slate-400 uppercase block">Album: {{ media.album?.title || 'General Gallery' }}</span>
            <h3 class="text-xs font-bold text-[#172033] line-clamp-2">
                {{ media.title }}
            </h3>
        </div>
    </div>
</template>
