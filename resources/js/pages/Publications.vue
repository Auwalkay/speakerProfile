<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import PublicationCard from '../Components/PublicationCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Publication {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    document_path: string | null;
    published_at: string | null;
}

interface PaginatedPublications {
    data: Publication[];
    links: any[];
}

const props = defineProps<{
    publications: PaginatedPublications;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const performSearch = () => {
    router.get('/publications', {
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
    <PublicLayout title="Official Publications">
        <SectionHeader
            title="Publications & Documents"
            subtitle="Browse and download official reports, policy documents, newsletters, and legislative guides."
        />

        <!-- Filter Bar -->
        <div class="flex justify-between items-center mb-8">
            <SearchInput v-model="search" placeholder="Search publications..." @search="performSearch" />
        </div>

        <!-- Publications Grid -->
        <div v-if="publications.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <PublicationCard
                    v-for="pub in publications.data"
                    :key="pub.id"
                    :publication="pub"
                />
            </div>
            
            <Pagination :links="publications.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Official Publications"
                message="No publications matches your search criteria. Validated PDF files are indexed upon release."
            />
        </div>
    </PublicLayout>
</template>
