<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Album {
    id: number;
    title: string;
    slug: string;
    description: string | null;
}

interface MediaItem {
    id: number;
    title: string;
    caption: string | null;
    type: 'image' | 'video';
    date: string | null;
    url: string;
}

defineProps<{
    album: Album;
    items: MediaItem[];
}>();

const activeModalItem = ref<MediaItem | null>(null);

const openLightbox = (item: MediaItem) => {
    activeModalItem.value = item;
};

const closeLightbox = () => {
    activeModalItem.value = null;
};
</script>

<template>
    <PublicLayout :title="album.title">
        <Head>
            <meta name="description" :content="album.description || ''" />
        </Head>

        <div class="max-w-5xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/media" class="hover:text-[#008751]">Media Gallery</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ album.title }}</span>
            </nav>

            <!-- Album Header Info -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    Gallery Album
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ album.title }}
                </h1>
                <p v-if="album.description" class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-2xl font-medium">
                    {{ album.description }}
                </p>
            </div>

            <!-- Items Grid -->
            <div v-if="items.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="item in items" 
                    :key="item.id" 
                    class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition cursor-pointer"
                    @click="openLightbox(item)"
                >
                    <div class="bg-slate-100 aspect-video overflow-hidden flex items-center justify-center relative">
                        <img v-if="item.type === 'image' && item.url" :src="item.url" alt="Media item preview" class="object-cover w-full h-full" />
                        <video v-else-if="item.type === 'video' && item.url" :src="item.url" class="object-cover w-full h-full" muted></video>
                        <span v-else class="text-[9px] font-bold text-slate-300">File missing</span>
                        
                        <!-- Overlay icon for video play -->
                        <span v-if="item.type === 'video'" class="absolute inset-0 flex items-center justify-center bg-black/20">
                            <span class="w-10 h-10 rounded-full bg-white/80 flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-[#172033] fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div v-else class="text-xs text-slate-400 text-center py-12 bg-white border border-slate-100 rounded-lg">
                No items have been uploaded to this album.
            </div>

            <!-- Lightbox Modal -->
            <div v-if="activeModalItem" class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4">
                <button @click="closeLightbox" class="absolute top-4 right-4 text-white hover:text-slate-300 text-2xl font-bold">&times;</button>
                <div class="max-w-4xl w-full text-center space-y-4">
                    <div class="bg-black border border-white/10 rounded-lg overflow-hidden flex items-center justify-center max-h-[70vh]">
                        <img v-if="activeModalItem.type === 'image' && activeModalItem.url" :src="activeModalItem.url" alt="Lightbox display image" class="max-w-full max-h-[70vh] object-contain" />
                        <video v-else-if="activeModalItem.type === 'video' && activeModalItem.url" :src="activeModalItem.url" controls class="max-w-full max-h-[70vh]" autoplay></video>
                    </div>
                    <div class="text-white text-left space-y-1 px-2">
                        <h3 class="text-sm font-bold">{{ activeModalItem.title }}</h3>
                        <p v-if="activeModalItem.caption" class="text-xs text-slate-400">{{ activeModalItem.caption }}</p>
                        <span class="text-[10px] text-slate-500 font-semibold block">{{ activeModalItem.date ? new Date(activeModalItem.date).toLocaleDateString() : '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
