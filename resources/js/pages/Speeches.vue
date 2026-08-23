<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import SpeechCard from '../Components/SpeechCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Speech {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    delivered_at: string | null;
    location: string | null;
}

interface PaginatedSpeeches {
    data: Speech[];
    links: any[];
}

const props = defineProps<{
    speeches: PaginatedSpeeches;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const performSearch = () => {
    router.get('/speeches', {
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
    <PublicLayout title="Speeches & Addresses">
        <SectionHeader
            title="Official Speeches & Transcripts"
            subtitle="Verified address transcripts, keynote speeches, and official statements delivered by the Speaker."
        />

        <!-- Filter Bar -->
        <div class="flex justify-between items-center mb-8">
            <SearchInput v-model="search" placeholder="Search speeches..." @search="performSearch" />
        </div>

        <!-- Speeches Grid -->
        <div v-if="speeches.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <SpeechCard
                    v-for="speech in speeches.data"
                    :key="speech.id"
                    :speech="speech"
                />
            </div>
            
            <Pagination :links="speeches.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Address Transcripts"
                message="No speeches matched your parameters. Official speech transcripts are indexed upon authorization."
            />
        </div>
    </PublicLayout>
</template>
