<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Achievement {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    content: string | null;
    achievement_date: string | null;
    location: string | null;
    impact_summary: string | null;
    category?: { name: string };
    state?: { name: string };
    lga?: { name: string };
}

interface MediaFiles {
    featured_image: string;
    gallery: string[];
    documents: Array<{ name: string; url: string }>;
    videos: string[];
}

defineProps<{
    achievement: Achievement;
    media: MediaFiles;
    related: Achievement[];
}>();
</script>

<template>
    <PublicLayout :title="achievement.title">
        <Head>
            <meta name="description" :content="achievement.summary || ''" />
        </Head>

        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/achievements" class="hover:text-[#008751]">Achievements</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ achievement.title }}</span>
            </nav>

            <!-- Main Title & Info Header -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ achievement.category?.name || 'Achievement' }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ achievement.title }}
                </h1>
                
                <div class="flex flex-wrap gap-4 text-xs text-[#64748B] font-medium pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span v-if="achievement.achievement_date">
                        <strong>Date:</strong> {{ new Date(achievement.achievement_date).toLocaleDateString() }}
                    </span>
                    <span v-if="achievement.location || achievement.state">
                        <strong>Location:</strong> {{ achievement.location ? `${achievement.location}, ` : '' }}{{ achievement.lga?.name }}, {{ achievement.state?.name }}
                    </span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Main Content Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Featured Image placeholder/display -->
                    <div v-if="media.featured_image" class="rounded-xl overflow-hidden shadow-sm border border-slate-100 bg-slate-100 aspect-video">
                        <img :src="media.featured_image" alt="Achievement Featured Image" class="w-full h-full object-cover" />
                    </div>

                    <!-- Summary & Content -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                        <div v-if="achievement.summary" class="border-l-4 border-[#008751] pl-4 text-xs sm:text-sm text-[#172033] font-semibold italic leading-relaxed bg-[#008751]/5 py-2 pr-2">
                            {{ achievement.summary }}
                        </div>
                        <div 
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="achievement.content"
                        ></div>
                    </div>

                    <!-- Gallery Section -->
                    <div v-if="media.gallery && media.gallery.length > 0" class="space-y-4">
                        <h3 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider">Image Gallery</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div 
                                v-for="(img, idx) in media.gallery" 
                                :key="idx" 
                                class="rounded-lg overflow-hidden border border-slate-100 shadow-sm aspect-square bg-slate-50"
                            >
                                <img :src="img" alt="Gallery item" class="w-full h-full object-cover hover:scale-105 transition duration-200" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side Information Column -->
                <div class="space-y-6">
                    <!-- Impact Summary Box -->
                    <div v-if="achievement.impact_summary" class="bg-[#172033] text-white p-6 rounded-xl border-t-4 border-[#D4AF37] space-y-3 shadow-md">
                        <h3 class="text-xs font-bold tracking-wider text-[#D4AF37] uppercase">Impact Assessment</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ achievement.impact_summary }}
                        </p>
                    </div>

                    <!-- Documents/Downloads -->
                    <div v-if="media.documents && media.documents.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Documents</h3>
                        <ul class="space-y-2">
                            <li v-for="(doc, idx) in media.documents" :key="idx" class="text-xs font-semibold">
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

                    <!-- Related Achievements -->
                    <div v-if="related && related.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related</h3>
                        <div class="space-y-3">
                            <div v-for="rel in related" :key="rel.id" class="text-xs">
                                <Link 
                                    :href="`/achievements/${rel.slug}`" 
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ rel.title }}
                                </Link>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ rel.published_at ? new Date(rel.published_at).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
