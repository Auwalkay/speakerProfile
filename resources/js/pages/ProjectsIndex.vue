<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Category {
    id: number;
    name: string;
}

interface State {
    id: number;
    name: string;
}

interface Lga {
    id: number;
    name: string;
}

interface Project {
    id: number;
    name: string;
    slug: string;
    location: string | null;
    community: string | null;
    budget: string | null;
    completion_percentage: number;
    status_project: string;
    category?: Category;
    state?: State;
    lga?: Lga;
}

interface PaginatedProjects {
    data: Project[];
    links: any[];
}

const props = defineProps<{
    projects: PaginatedProjects;
    states: State[];
    lgas: Lga[];
    categories: Category[];
    years: number[];
    projectStatuses: string[];
    filters: {
        search?: string;
        state?: string | number;
        lga?: string | number;
        category?: string | number;
        status_project?: string;
        year?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const state = ref(props.filters.state || '');
const lga = ref(props.filters.lga || '');
const category = ref(props.filters.category || '');
const statusProject = ref(props.filters.status_project || '');
const year = ref(props.filters.year || '');

const stateOptions = props.states.map((s) => ({ value: s.id, label: s.name }));
const lgaOptions = props.lgas.map((l) => ({ value: l.id, label: l.name }));
const categoryOptions = props.categories.map((c) => ({ value: c.id, label: c.name }));
const statusOptions = props.projectStatuses.map((s) => ({ value: s, label: s }));
const yearOptions = props.years.map((y) => ({ value: y, label: String(y) }));

const performSearch = () => {
    router.get('/projects', {
        search: search.value,
        state: state.value,
        lga: lga.value,
        category: category.value,
        status_project: statusProject.value,
        year: year.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, state, category, statusProject, year], () => {
    // If state changes, reset LGA
    if (state.value !== props.filters.state) {
        lga.value = '';
    }
    performSearch();
});

watch(lga, () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Constituency Projects Map">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <span class="text-slate-600">Constituency Projects</span>
        </nav>

        <SectionHeader
            title="Constituency Projects"
            subtitle="Monitor real-time progress, budgets, and distribution of development works across all community jurisdictions."
        />

        <!-- Filters Matrix -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-10">
            <SearchInput v-model="search" placeholder="Search project name..." @search="performSearch" />
            <FilterSelect v-model="state" :options="stateOptions" placeholder="All States" />
            <FilterSelect v-model="lga" :options="lgaOptions" placeholder="All LGAs" :disabled="!state" />
            <FilterSelect v-model="category" :options="categoryOptions" placeholder="All Categories" />
            <FilterSelect v-model="statusProject" :options="statusOptions" placeholder="All Statuses" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Projects Grid -->
        <div v-if="projects.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="proj in projects.data" 
                    :key="proj.id" 
                    class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition"
                >
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                {{ proj.category?.name || 'Development' }}
                            </span>
                            <span class="text-[10px] font-bold uppercase text-slate-400">
                                {{ proj.status_project }}
                            </span>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                                <Link :href="`/projects/${proj.slug}`">{{ proj.name || proj.title }}</Link>
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2 font-medium">
                                Location: {{ proj.community ? `${proj.community}, ` : '' }}{{ proj.location || 'Constituency' }}
                            </p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1.5 pt-2">
                            <div class="flex justify-between text-[10px] font-bold text-[#172033]">
                                <span>Completion</span>
                                <span>{{ proj.completion_percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#008751] h-full rounded-full transition-all duration-300" :style="{ width: `${proj.completion_percentage}%` }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer parameters -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold">
                        <span>Budget: {{ proj.budget ? `₦${Number(proj.budget).toLocaleString()}` : 'Confidential' }}</span>
                        <Link :href="`/projects/${proj.slug}`" class="text-[#008751] font-bold hover:underline">View Details &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="projects.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Projects Found"
                message="No constituency projects match the selected search values. All listings represent public records."
            />
        </div>
    </PublicLayout>
</template>
