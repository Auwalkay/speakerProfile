<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Album {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    media_items_count: number;
}

interface PaginatedAlbums {
    data: Album[];
    links: any[];
}

const props = defineProps<{
    albums: PaginatedAlbums;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const performSearch = () => {
    router.get('/media', {
        search: search.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch(search, () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Media Albums">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <span class="text-slate-600">Media Gallery</span>
        </nav>

        <SectionHeader
            title="Media Gallery"
            subtitle="View photo albums and video records covering official conferences, constituency tours, and assembly engagements."
        />

        <!-- Filters Bar -->
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8 max-w-md">
            <SearchInput v-model="search" placeholder="Search albums..." @search="performSearch" />
        </div>

        <!-- Albums Grid -->
        <div v-if="albums.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="album in albums.data" 
                    :key="album.id" 
                    class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition"
                >
                    <div class="space-y-4">
                        <div class="bg-slate-100 aspect-video overflow-hidden relative flex items-center justify-center">
                            <img :src="album.cover_url" alt="Album Cover" class="object-cover w-full h-full" />
                            <span class="absolute top-3 left-3 bg-[#008751]/95 text-white px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                {{ album.media_items_count }} Photos
                            </span>
                        </div>
                        <div class="p-6 space-y-2">
                            <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition">
                                <Link :href="`/media/${album.slug}`">{{ album.title }}</Link>
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-2">
                                {{ album.description || 'No description summary available.' }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold bg-slate-50">
                        <span>Official Archive</span>
                        <Link :href="`/media/${album.slug}`" class="text-[#008751] font-bold hover:underline">Explore Album &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="albums.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Albums Found"
                message="No media albums match the search criteria. All media files are verified public records."
            />
        </div>
    </PublicLayout>
</template>
