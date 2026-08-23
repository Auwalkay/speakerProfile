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

interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    excerpt: string | null;
    author: string | null;
    published_at: string | null;
    category?: Category;
    image_url?: string | null;
}

interface PaginatedNews {
    data: News[];
    links: any[];
}

const props = defineProps<{
    news: PaginatedNews;
    featured: News | null;
    categories: Category[];
    filters: {
        search?: string;
        category?: string | number;
    };
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

const categoryOptions = props.categories.map((c) => ({ value: c.id, label: c.name }));

const performSearch = () => {
    router.get('/news', {
        search: search.value,
        category: category.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

watch([search, category], () => {
    performSearch();
});
</script>

<template>
    <PublicLayout title="News & Press Releases">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
            <Link href="/" class="hover:text-[#008751]">Home</Link>
            <span>/</span>
            <span class="text-slate-600">News</span>
        </nav>

        <SectionHeader
            title="News & Updates"
            subtitle="Get the latest official statements, policy declarations, and updates directly from the Office."
        />

        <!-- Featured News Card (Only if no active filters are set) -->
        <div v-if="featured && !search && !category" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden mb-12 grid grid-cols-1 lg:grid-cols-2">
            <div class="bg-slate-100 aspect-video lg:aspect-auto min-h-[260px] flex items-center justify-center text-slate-400 relative overflow-hidden group">
                <img 
                    v-if="featured.image_url" 
                    :src="featured.image_url" 
                    :alt="featured.title" 
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                />
                <div v-else class="w-full h-full flex flex-col items-center justify-center text-slate-300 font-bold uppercase text-xs space-y-1 p-6">
                    <svg class="w-10 h-10 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Official Release</span>
                </div>
                <span class="absolute top-4 left-4 bg-[#008751] text-white text-[9px] font-bold px-2 py-0.5 rounded tracking-wide uppercase shadow-sm">
                    Featured
                </span>
            </div>
            <div class="p-8 sm:p-10 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="text-xs font-bold text-[#008751] uppercase tracking-wider">
                        {{ featured.category?.name }}
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-[#172033] hover:text-[#008751] transition">
                        <Link :href="`/news/${featured.slug}`">{{ featured.title }}</Link>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                        {{ featured.excerpt || featured.summary }}
                    </p>
                </div>
                <div class="flex justify-between items-center text-[10px] text-slate-400 font-semibold border-t pt-4">
                    <span>By: {{ featured.author || 'Press Secretary' }} &bull; {{ featured.published_at ? new Date(featured.published_at).toLocaleDateString() : '' }}</span>
                    <Link :href="`/news/${featured.slug}`" class="text-[#008751] font-bold hover:underline">Read Article &rarr;</Link>
                </div>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-sm mb-8 max-w-2xl">
            <SearchInput v-model="search" placeholder="Search keywords..." @search="performSearch" />
            <FilterSelect v-model="category" :options="categoryOptions" placeholder="All Categories" />
        </div>

        <!-- News Grid -->
        <div v-if="news.data.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="item in news.data" 
                    :key="item.id" 
                    class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition group"
                >
                    <div>
                        <div class="bg-slate-100 aspect-video flex items-center justify-center text-slate-400 relative overflow-hidden">
                            <img 
                                v-if="item.image_url" 
                                :src="item.image_url" 
                                :alt="item.title" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            />
                            <div v-else class="w-full h-full flex flex-col items-center justify-center text-slate-300 font-bold uppercase text-[10px] space-y-1">
                                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Official Release</span>
                            </div>
                            <span class="absolute top-3 left-3 bg-[#172033] text-white text-[9px] font-bold px-2 py-0.5 rounded tracking-wide uppercase shadow-sm">
                                {{ item.category?.name || 'UPDATE' }}
                            </span>
                        </div>
                        <div class="p-6 space-y-3">
                            <span class="block text-[10px] font-semibold text-slate-400">
                                {{ item.published_at ? new Date(item.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '' }}
                            </span>
                            <h4 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                                <Link :href="`/news/${item.slug}`">{{ item.title }}</Link>
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-3">
                                {{ item.excerpt || item.summary }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center text-[10px] text-slate-400 font-semibold bg-slate-50">
                        <span>By: {{ item.author || 'Official' }}</span>
                        <Link :href="`/news/${item.slug}`" class="text-[#008751] font-bold hover:underline">Read More &rarr;</Link>
                    </div>
                </div>
            </div>

            <Pagination :links="news.links" />
        </div>
        <div v-else>
            <EmptyState
                title="No Articles Found"
                message="No news items match the chosen queries. All entries are verified institutional releases."
            />
        </div>
    </PublicLayout>
</template>
