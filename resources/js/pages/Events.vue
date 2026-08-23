<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import EventCard from '../Components/EventCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Event {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    starts_at: string | null;
    ends_at: string | null;
    location: string | null;
}

interface PaginatedEvents {
    data: Event[];
    links: any[];
}

const props = defineProps<{
    events: PaginatedEvents;
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const performSearch = () => {
    router.get('/events', {
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
    <PublicLayout title="Events Calendar">
        <SectionHeader
            title="Institutional Events & Calendar"
            subtitle="View public activities, parliamentary visits, committee meetings, and scheduled hearings."
        />

        <!-- Filter Bar -->
        <div class="flex justify-between items-center mb-8">
            <SearchInput v-model="search" placeholder="Search events..." @search="performSearch" />
        </div>

        <!-- Events Grid -->
        <div v-if="events.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <EventCard
                    v-for="ev in events.data"
                    :key="ev.id"
                    :event="ev"
                />
            </div>
            
            <Pagination :links="events.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Events Scheduled"
                message="No official events match your filters. Please consult the legislative calendar for session schedules."
            />
        </div>
    </PublicLayout>
</template>
