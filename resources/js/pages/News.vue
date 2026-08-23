<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import NewsCard from '../Components/NewsCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    category?: { name: string };
    published_at: string | null;
}

interface PaginatedNews {
    data: News[];
    links: any[];
}

const props = defineProps<{
    news: PaginatedNews;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const performSearch = () => {
    router.get('/news', {
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
    <PublicLayout title="Official News & Updates">
        <SectionHeader
            title="News Room"
            subtitle="Read official announcements, daily updates, and updates from the Speaker's media office."
        />

        <!-- Filter Bar -->
        <div class="flex justify-between items-center mb-8">
            <SearchInput v-model="search" placeholder="Search news articles..." @search="performSearch" />
        </div>

        <!-- News Grid -->
        <div v-if="news.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <NewsCard
                    v-for="item in news.data"
                    :key="item.id"
                    :news="item"
                />
            </div>
            
            <Pagination :links="news.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Articles Published"
                message="There are no news articles matching your search query. Please check back later."
            />
        </div>
    </PublicLayout>
</template>
