<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    excerpt: string | null;
    content: string | null;
    author: string | null;
    published_at: string | null;
    category?: { name: string };
}

defineProps<{
    article: News;
    featuredImageUrl?: string;
    related: News[];
}>();
</script>

<template>
    <PublicLayout :title="article.title">
        <Head>
            <meta name="description" :content="article.excerpt || article.summary || ''" />
        </Head>

        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/news" class="hover:text-[#008751]">News</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ article.title }}</span>
            </nav>

            <!-- News Details Header -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ article.category?.name || 'Press Release' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ article.title }}
                </h1>
                <div class="flex flex-wrap gap-4 text-xs text-[#64748B] font-semibold pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span>
                        <strong>Published:</strong> {{ article.published_at ? new Date(article.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '' }}
                    </span>
                    <span>
                        <strong>Author:</strong> {{ article.author || 'Press Secretary' }}
                    </span>
                </div>
            </div>

            <!-- Content Area Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Main Article -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Featured Image placeholder/display -->
                    <div class="bg-slate-100 aspect-video rounded-xl overflow-hidden border border-slate-100">
                        <img v-if="featuredImageUrl" :src="featuredImageUrl" alt="Featured article news image" class="object-cover w-full h-full" />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-300 font-bold uppercase text-xs">
                            No Photo Attached
                        </div>
                    </div>

                    <!-- Article Body -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                        <div v-if="article.excerpt" class="text-xs sm:text-sm font-semibold italic text-[#172033] leading-relaxed border-l-4 border-[#008751] pl-4">
                            {{ article.excerpt }}
                        </div>
                        <div 
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="article.content"
                        ></div>
                    </div>
                </div>

                <!-- Right Sidebar: Related News -->
                <div class="space-y-6">
                    <div v-if="related.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related News</h3>
                        <div class="space-y-4">
                            <div v-for="item in related" :key="item.id" class="text-xs space-y-1">
                                <Link 
                                    :href="`/news/${item.slug}`"
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ item.title }}
                                </Link>
                                <span class="text-[9px] text-slate-400 block">{{ item.published_at ? new Date(item.published_at).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
