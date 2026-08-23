<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import FilterSelect from '../Components/FilterSelect.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Speech {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    location: string | null;
    speech_date: string | null;
    event: string | null;
}

interface PaginatedSpeeches {
    data: Speech[];
    links: any[];
}

const props = defineProps<{
    speeches: PaginatedSpeeches;
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
    router.get('/speeches', {
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
    <PublicLayout title="Speeches & Addresses">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <span class="text-slate-600">Speeches</span>
        </nav>

        <SectionHeader
            title="Speeches & Addresses"
            subtitle="Access transcripts and PDFs of key addresses, plenary interventions, and statements delivered by the Speaker."
        />

        <!-- Filters Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8 max-w-2xl">
            <SearchInput v-model="search" placeholder="Search event, location or title..." @search="performSearch" />
            <FilterSelect v-model="year" :options="yearOptions" placeholder="All Years" />
        </div>

        <!-- Speeches Listing Grid -->
        <div v-if="speeches.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="speech in speeches.data" 
                    :key="speech.id" 
                    class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between hover:border-[#008751]/30 transition"
                >
                    <div class="space-y-3">
                        <span class="inline-block bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                            Speech
                        </span>
                        <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                            <Link :href="`/speeches/${speech.slug}`">{{ speech.title }}</Link>
                        </h4>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ speech.summary || 'No summary description available.' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold mt-4">
                        <span>Delivered: {{ speech.speech_date ? new Date(speech.speech_date).toLocaleDateString() : 'N/A' }}</span>
                        <Link :href="`/speeches/${speech.slug}`" class="text-[#008751] font-bold hover:underline">Read Transcript &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="speeches.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Speeches Found"
                message="No speeches match the chosen criteria. All items are verified official records."
            />
        </div>
    </PublicLayout>
</template>
