<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import ProjectCard from '../Components/ProjectCard.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface State {
    id: number;
    name: string;
}

interface Project {
    id: number;
    title: string;
    slug: string;
    location: string | null;
    status_project: string;
    cost: string | number | null;
    beneficiaries_count: number | null;
    summary: string | null;
    state?: { name: string };
    lga?: { name: string };
    category?: { name: string };
}

interface PaginatedProjects {
    data: Project[];
    links: any[];
}

const props = defineProps<{
    projects: PaginatedProjects;
    states: State[];
    filters: {
        search?: string;
        state?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const state = ref(props.filters.state || '');

const stateOptions = props.states.map((s) => ({
    value: s.id,
    label: s.name,
}));

const performSearch = () => {
    router.get('/projects', {
        search: search.value,
        state: state.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, state], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Constituency Projects">
        <SectionHeader
            title="Constituency Projects"
            subtitle="Explore verified infrastructural and welfare constituency projects funded or facilitated."
        />

        <!-- Filter Bar -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8">
            <SearchInput v-model="search" placeholder="Search projects..." @search="performSearch" />
            <FilterSelect v-model="state" :options="stateOptions" placeholder="All States" />
        </div>

        <!-- Projects Grid -->
        <div v-if="projects.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <ProjectCard
                    v-for="proj in projects.data"
                    :key="proj.id"
                    :project="proj"
                />
            </div>
            
            <Pagination :links="projects.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Projects Indexed"
                message="No projects matching the selected state or query were found. All constituency entries are subject to physical verification."
            />
        </div>
    </PublicLayout>
</template>
