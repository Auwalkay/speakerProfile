<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Bill {
    id: number;
    title: string;
    slug: string;
    bill_number: string | null;
    category: string | null;
    sponsor: string | null;
    status_legislative: string;
    summary: string | null;
    date_introduced: string | null;
}

interface PaginatedBills {
    data: Bill[];
    links: any[];
}

const props = defineProps<{
    bills: PaginatedBills;
    years: number[];
    categories: string[];
    statuses: string[];
    filters: {
        search?: string;
        category?: string;
        status?: string;
        year?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const status = ref(props.filters.status || '');
const year = ref(props.filters.year || '');

const categoryOptions = props.categories.map((c) => ({ value: c, label: c }));
const statusOptions = props.statuses.map((s) => ({ value: s, label: s }));
const yearOptions = props.years.map((y) => ({ value: y, label: String(y) }));

const performSearch = () => {
    router.get('/legislative-work/bills', {
        search: search.value,
        category: category.value,
        status: status.value,
        year: year.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, category, status, year], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="Official Bills Registry">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <Link href="/legislative-work" class="hover:text-[#008751]">Legislative Work</Link>
            <span>/</span>
            <span class="text-slate-600">Bills</span>
        </nav>

        <SectionHeader
            title="Bills Registry"
            subtitle="Explore sponsored bills, their committee statuses, dates of introduction, and official drafts."
        />

        <!-- Filters Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8">
            <SearchInput v-model="search" placeholder="Search bill number or title..." @search="performSearch" />
            <FilterSelect v-model="category" :options="categoryOptions" placeholder="All Categories" />
            <FilterSelect v-model="status" :options="statusOptions" placeholder="All Statuses" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Bills List Grid -->
        <div v-if="bills.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="bill in bills.data" 
                    :key="bill.id" 
                    class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between hover:border-[#008751]/30 transition"
                >
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase">
                            <span>{{ bill.bill_number }}</span>
                            <span class="bg-[#008751]/15 text-[#008751] px-1.5 py-0.5 rounded">{{ bill.status_legislative }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition">
                            <Link :href="`/legislative-work/${bill.slug}`">{{ bill.title }}</Link>
                        </h4>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ bill.summary || 'No summary description available.' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold">
                        <span>Introduced: {{ bill.date_introduced ? new Date(bill.date_introduced).toLocaleDateString() : 'N/A' }}</span>
                        <Link :href="`/legislative-work/${bill.slug}`" class="text-[#008751] font-bold hover:underline">View Detail &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="bills.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Bills Found"
                message="No bills match your current search queries or filters. All entries represent verified legislative updates."
            />
        </div>
    </PublicLayout>
</template>
