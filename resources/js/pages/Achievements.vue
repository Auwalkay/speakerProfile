<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import AchievementCard from '../Components/AchievementCard.vue';
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

interface Achievement {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    content: string | null;
    category?: { name: string };
    published_at: string | null;
}

interface PaginatedAchievements {
    data: Achievement[];
    links: any[];
}

const props = defineProps<{
    achievements: PaginatedAchievements;
    featured: Achievement[];
    categories: Category[];
    states: State[];
    years: number[];
    filters: {
        search?: string;
        category?: string | number;
        state?: string | number;
        year?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const state = ref(props.filters.state || '');
const year = ref(props.filters.year || '');

const categoryOptions = props.categories.map((c) => ({
    value: c.id,
    label: c.name,
}));

const stateOptions = props.states.map((s) => ({
    value: s.id,
    label: s.name,
}));

const yearOptions = props.years.map((y) => ({
    value: y,
    label: String(y),
}));

const performSearch = () => {
    router.get('/achievements', {
        search: search.value,
        category: category.value,
        state: state.value,
        year: year.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, category, state, year], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Verified Achievements">
        <SectionHeader 
            title="Official Key Achievements" 
            subtitle="Verified developmental milestones, policies, and accomplishments executed during the Speaker's tenure." 
        />

        <!-- Featured Section -->
        <section v-if="featured.length > 0 && !search && !category && !state && !year" class="mb-12">
            <h3 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider mb-4">Featured Achievements</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div 
                    v-for="feat in featured" 
                    :key="feat.id" 
                    class="bg-[#172033] text-white rounded-xl border border-slate-800 p-6 flex flex-col justify-between hover:border-[#D4AF37]/50 transition duration-150 shadow-md"
                >
                    <div class="space-y-3">
                        <span class="inline-block bg-[#D4AF37]/20 text-[#D4AF37] border border-[#D4AF37]/30 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider">
                            {{ feat.category?.name || 'Featured' }}
                        </span>
                        <h4 class="text-sm font-bold text-white leading-snug">
                            <Link :href="`/achievements/${feat.slug}`" class="hover:text-[#D4AF37] transition">
                                {{ feat.title }}
                            </Link>
                        </h4>
                        <p class="text-[11px] text-slate-300 leading-relaxed line-clamp-3">
                            {{ feat.summary }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-800 flex justify-between items-center text-[9px] text-slate-400 font-semibold">
                        <span>{{ feat.published_at ? new Date(feat.published_at).toLocaleDateString() : '' }}</span>
                        <Link :href="`/achievements/${feat.slug}`" class="text-[#D4AF37] font-bold hover:underline">Read Detail &rarr;</Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8">
            <SearchInput v-model="search" placeholder="Search achievements..." @search="performSearch" />
            <FilterSelect v-model="category" :options="categoryOptions" placeholder="All Categories" />
            <FilterSelect v-model="state" :options="stateOptions" placeholder="All States" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Content Grid -->
        <div v-if="achievements.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="ach in achievements.data"
                    :key="ach.id"
                    class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150"
                >
                    <div class="p-6 space-y-3">
                        <span class="inline-block bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                            {{ ach.category?.name || 'Achievement' }}
                        </span>
                        <h3 class="text-base font-bold text-[#172033] hover:text-[#008751] transition">
                            <Link :href="`/achievements/${ach.slug}`">{{ ach.title }}</Link>
                        </h3>
                        <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                            {{ ach.summary || 'No summary available.' }}
                        </p>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
                        <span>{{ ach.published_at ? new Date(ach.published_at).toLocaleDateString() : 'N/A' }}</span>
                        <Link :href="`/achievements/${ach.slug}`" class="text-[#008751] font-bold hover:underline">View Details &rarr;</Link>
                    </div>
                </div>
            </div>
            
            <Pagination :links="achievements.links" />
        </div>
        <div v-else>
            <EmptyState 
                title="No Achievements Registered" 
                message="There are no achievements matching your search filters. All data posted is official and verified." 
            />
        </div>
    </PublicLayout>
</template>
