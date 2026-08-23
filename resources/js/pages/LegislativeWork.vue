<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
import SearchInput from '../Components/SearchInput.vue';
import Pagination from '../Components/Pagination.vue';
import EmptyState from '../Components/EmptyState.vue';

interface Item {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    sponsor: string | null;
    bill_number?: string;
    status_legislative?: string;
    date_presented?: string;
}

interface PaginatedItems {
    data: Item[];
    links: any[];
}

const props = defineProps<{
    items: PaginatedItems;
    filters: {
        search?: string;
        type?: string;
    };
}>();

const search = ref(props.filters.search || '');
const activeType = ref(props.filters.type || 'bills');

const setType = (type: string) => {
    activeType.value = type;
    router.get('/legislative-work', {
        search: search.value,
        type: activeType.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

const performSearch = () => {
    router.get('/legislative-work', {
        search: search.value,
        type: activeType.value,
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
    <PublicLayout title="Legislative Work">
        <SectionHeader
            title="Legislative Activity & Records"
            subtitle="Explore official records of sponsored bills, parliamentary motions, and resolutions."
        />

        <!-- Tab Toggle & Search -->
        <div class="flex flex-col md:flex-row gap-4 justify-between items-start md:items-center mb-8">
            <div class="inline-flex rounded-lg border border-[#E2E8F0] bg-white p-1 shadow-sm">
                <button
                    @click="setType('bills')"
                    :class="[
                        activeType === 'bills' ? 'bg-[#008751] text-white' : 'text-[#172033] hover:bg-slate-50',
                        'px-4 py-2 rounded-md text-xs font-bold transition'
                    ]"
                >
                    Bills
                </button>
                <button
                    @click="setType('motions')"
                    :class="[
                        activeType === 'motions' ? 'bg-[#008751] text-white' : 'text-[#172033] hover:bg-slate-50',
                        'px-4 py-2 rounded-md text-xs font-bold transition'
                    ]"
                >
                    Motions
                </button>
            </div>
            
            <SearchInput v-model="search" placeholder="Search title or sponsor..." @search="performSearch" />
        </div>

        <!-- Content List -->
        <div v-if="items.data.length > 0" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="item in items.data"
                    :key="item.id"
                    class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between hover:border-[#008751]/30 transition"
                >
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase">
                            <span>{{ activeType === 'bills' ? item.bill_number || 'Bill' : 'Motion' }}</span>
                            <span v-if="item.status_legislative" class="bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded">
                                {{ item.status_legislative }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                            {{ item.title }}
                        </h3>
                        <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                            {{ item.summary || 'No summary available.' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-medium">
                        <span>Sponsor: {{ item.sponsor || 'Official' }}</span>
                        <span v-if="item.date_presented">{{ new Date(item.date_presented).toLocaleDateString() }}</span>
                    </div>
                </div>
            </div>

            <Pagination :links="items.links" />
        </div>
        
        <div v-else>
            <EmptyState
                title="No Legislative Records Found"
                message="No items match your search. Only officially filed and processed documents are indexed."
            />
        </div>
    </PublicLayout>
</template>
