<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Publication {
    id: number;
    title: string;
    slug: string;
    category: string | null;
    publication_date: string | null;
    summary: string | null;
    description: string | null;
}

defineProps<{
    publication: Publication;
    pdfUrl?: string;
    coverUrl?: string;
    related: Publication[];
}>();
</script>

<template>
    <PublicLayout :title="publication.title">
        <Head>
            <meta name="description" :content="publication.summary || ''" />
        </Head>

        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/publications" class="hover:text-[#008751]">Publications</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ publication.title }}</span>
            </nav>

            <!-- Details Header -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ publication.category || 'Manual' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ publication.title }}
                </h1>
                
                <div class="flex flex-wrap gap-4 text-xs text-[#64748B] font-semibold pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span v-if="publication.publication_date">
                        <strong>Released:</strong> {{ new Date(publication.publication_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
                    </span>
                </div>
            </div>

            <!-- Content Area Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details -->
                <div class="lg:col-span-2 space-y-8 flex flex-col sm:flex-row gap-6 items-start">
                    <!-- Cover Image -->
                    <div class="w-full sm:w-[160px] bg-slate-100 aspect-[3/4] rounded-lg overflow-hidden border border-slate-200 flex-shrink-0 flex items-center justify-center">
                        <img v-if="coverUrl" :src="coverUrl" alt="Book cover thumbnail" class="object-cover w-full h-full" />
                        <span v-else class="text-[9px] font-bold text-slate-300 uppercase text-center p-4">No Cover Image</span>
                    </div>

                    <!-- Texts -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6 flex-grow w-full">
                        <div v-if="publication.summary" class="text-xs sm:text-sm font-semibold italic text-[#172033] leading-relaxed border-l-4 border-[#008751] pl-4">
                            {{ publication.summary }}
                        </div>
                        <div 
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="publication.description"
                        ></div>
                    </div>
                </div>

                <!-- Right Sidebar: Downloads & Recs -->
                <div class="space-y-6">
                    <!-- Download Card -->
                    <div v-if="pdfUrl" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Document PDF</h3>
                        <a 
                            :href="pdfUrl" 
                            target="_blank" 
                            class="w-full bg-[#008751] hover:bg-[#008751]/95 text-white py-2.5 rounded-lg text-xs font-bold block text-center transition"
                        >
                            Download PDF File
                        </a>
                    </div>

                    <!-- Related Publications -->
                    <div v-if="related.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related Publications</h3>
                        <div class="space-y-4">
                            <div v-for="item in related" :key="item.id" class="text-xs space-y-1">
                                <Link 
                                    :href="`/publications/${item.slug}`"
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ item.title }}
                                </Link>
                                <span class="text-[9px] text-slate-400 block">{{ item.publication_date ? new Date(item.publication_date).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
