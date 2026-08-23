<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Motion {
    id: number;
    title: string;
    slug: string;
    sponsor: string | null;
    date: string | null;
    summary: string | null;
}

interface PaginatedMotions {
    data: Motion[];
    links: any[];
}

const props = defineProps<{
    motions: PaginatedMotions;
    years: number[];
    filters: {
        search?: string;
        year?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const year = ref(props.filters.year || '');

const yearOptions = props.years.map((y) => ({ value: y, label: String(y) }));

const performSearch = () => {
    router.get('/legislative-work/motions', {
        search: search.value,
        year: year.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, year], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Official Motions Registry">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <Link href="/legislative-work" class="hover:text-[#008751]">Legislative Work</Link>
            <span>/</span>
            <span class="text-slate-600">Motions</span>
        </nav>

        <SectionHeader
            title="Motions Registry"
            subtitle="View parliamentary motions and official resolutions presented during sessions."
        />

        <!-- Filters Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8 max-w-2xl">
            <SearchInput v-model="search" placeholder="Search sponsor or title..." @search="performSearch" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Motions List Grid -->
        <div v-if="motions.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="motion in motions.data" 
                    :key="motion.id" 
                    class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between hover:border-[#008751]/30 transition"
                >
                    <div class="space-y-3">
                        <span class="inline-block bg-[#D4AF37]/10 text-[#D4AF37] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                            Motion
                        </span>
                        <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition">
                            <Link :href="`/legislative-work/${motion.slug}`">{{ motion.title }}</Link>
                        </h4>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ motion.summary || 'No summary description available.' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold">
                        <span>Sponsor: {{ motion.sponsor || 'Official' }}</span>
                        <Link :href="`/legislative-work/${motion.slug}`" class="text-[#008751] font-bold hover:underline">View Detail &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="motions.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Motions Found"
                message="No motions match your search criteria. All items are verified records from parliamentary order sheets."
            />
        </div>
    </PublicLayout>
</template>
