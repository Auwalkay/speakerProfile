<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Record {
    id: number;
    title: string;
    slug: string;
    bill_number?: string;
    sponsor: string | null;
    status_legislative?: string;
    date_introduced?: string;
    date_passed?: string;
    assent_status?: string;
    date?: string;
    summary: string | null;
    description: string | null;
}

interface Document {
    name: string;
    url: string;
}

interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    published_at: string | null;
}

interface Speech {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    delivered_at: string | null;
}

defineProps<{
    type: 'bill' | 'motion';
    record: Record;
    documents: Document[];
    relatedNews: News[];
    relatedSpeeches: Speech[];
}>();
</script>

<template>
    <PublicLayout :title="record.title">
        <Head>
            <meta name="description" :content="record.summary || ''" />
        </Head>

        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/legislative-work" class="hover:text-[#008751]">Legislative Work</Link>
                <span>/</span>
                <Link :href="type === 'bill' ? '/legislative-work/bills' : '/legislative-work/motions'" class="hover:text-[#008751]">
                    {{ type === 'bill' ? 'Bills' : 'Motions' }}
                </Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ record.title }}</span>
            </nav>

            <!-- Header Info -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ type === 'bill' ? record.bill_number || 'Bill' : 'Motion' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ record.title }}
                </h1>
                
                <div class="flex flex-wrap gap-4 text-xs text-[#64748B] font-medium pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span v-if="record.sponsor">
                        <strong>Sponsor:</strong> {{ record.sponsor }}
                    </span>
                    <span v-if="type === 'bill' && record.date_introduced">
                        <strong>Introduced:</strong> {{ new Date(record.date_introduced).toLocaleDateString() }}
                    </span>
                    <span v-if="type === 'motion' && record.date">
                        <strong>Date Moved:</strong> {{ new Date(record.date).toLocaleDateString() }}
                    </span>
                    <span v-if="type === 'bill' && record.status_legislative" class="bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded font-bold uppercase">
                        {{ record.status_legislative }}
                    </span>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Main Content Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Summary & Content -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                        <div v-if="record.summary" class="border-l-4 border-[#008751] pl-4 text-xs sm:text-sm text-[#172033] font-semibold italic bg-[#008751]/5 py-2 pr-2 leading-relaxed">
                            {{ record.summary }}
                        </div>
                        <div 
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="record.description"
                        ></div>
                    </div>
                </div>

                <!-- Right Side Information Column -->
                <div class="space-y-6">
                    <!-- Documents/Downloads -->
                    <div v-if="documents.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Documents</h3>
                        <ul class="space-y-2">
                            <li v-for="(doc, idx) in documents" :key="idx" class="text-xs font-semibold">
                                <a 
                                    :href="doc.url" 
                                    target="_blank" 
                                    class="text-[#008751] hover:underline flex items-center space-x-1.5"
                                >
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="truncate">{{ doc.name }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Related News -->
                    <div v-if="relatedNews.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related News</h3>
                        <div class="space-y-3">
                            <div v-for="news in relatedNews" :key="news.id" class="text-xs">
                                <Link 
                                    href="/news"
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ news.title }}
                                </Link>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ news.published_at ? new Date(news.published_at).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Speeches -->
                    <div v-if="relatedSpeeches.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related Speeches</h3>
                        <div class="space-y-3">
                            <div v-for="speech in relatedSpeeches" :key="speech.id" class="text-xs">
                                <Link 
                                    href="/speeches"
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ speech.title }}
                                </Link>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ speech.delivered_at ? new Date(speech.delivered_at).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
