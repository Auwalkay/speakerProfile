<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import MediaCard from '../Components/MediaCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Media {
    id: number;
    title: string;
    file_path: string | null;
    type: string;
    album?: {
        title: string;
    };
}

interface PaginatedMedia {
    data: Media[];
    links: any[];
}

const props = defineProps<{
    media: PaginatedMedia;
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
    <PublicLayout title="Media Albums & Gallery">
        <SectionHeader
            title="Media Gallery"
            subtitle="Browse through official photographs, audio records, and video recordings."
        />

        <!-- Filter Bar -->
        <div class="flex justify-between items-center mb-8">
            <SearchInput v-model="search" placeholder="Search media gallery..." @search="performSearch" />
        </div>

        <!-- Media Grid -->
        <div v-if="media.data.length > 0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <MediaCard
                    v-for="item in media.data"
                    :key="item.id"
                    :media="item"
                />
            </div>
            
            <Pagination :links="media.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Media Items Published"
                message="No media registry assets match your search parameters. Please explore other archives."
            />
        </div>
    </PublicLayout>
</template>
