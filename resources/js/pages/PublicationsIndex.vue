<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Publication {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    category: string | null;
    publication_date: string | null;
}

interface PaginatedPublications {
    data: Publication[];
    links: any[];
}

const props = defineProps<{
    publications: PaginatedPublications;
    categories: string[];
    years: number[];
    filters: {
        search?: string;
        category?: string;
        year?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const year = ref(props.filters.year || '');

const categoryOptions = props.categories.map((c) => ({ value: c, label: c }));
const yearOptions = props.years.map((y) => ({ value: y, label: String(y) }));

const performSearch = () => {
    router.get('/publications', {
        search: search.value,
        category: category.value,
        year: year.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, category, year], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Official Publications">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <span class="text-slate-600">Publications</span>
        </nav>

        <SectionHeader
            title="Official Publications"
            subtitle="Download policy booklets, hansards, legislative manuals, and public annual summaries."
        />

        <!-- Filters Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8 max-w-3xl">
            <SearchInput v-model="search" placeholder="Search publications..." @search="performSearch" />
            <FilterSelect v-model="category" :options="categoryOptions" placeholder="All Categories" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Publications Grid -->
        <div v-if="publications.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="pub in publications.data" 
                    :key="pub.id" 
                    class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition"
                >
                    <div class="p-6 space-y-4">
                        <span class="inline-block bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                            {{ pub.category || 'Manual' }}
                        </span>
                        <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                            <Link :href="`/publications/${pub.slug}`">{{ pub.title }}</Link>
                        </h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-3">
                            {{ pub.summary || 'No summary description available.' }}
                        </p>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold bg-slate-50">
                        <span>Released: {{ pub.publication_date ? new Date(pub.publication_date).toLocaleDateString() : 'N/A' }}</span>
                        <Link :href="`/publications/${pub.slug}`" class="text-[#008751] font-bold hover:underline">Download PDF &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="publications.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Publications Found"
                message="No booklets match the chosen criteria. All items represent verified documents."
            />
        </div>
    </PublicLayout>
</template>
