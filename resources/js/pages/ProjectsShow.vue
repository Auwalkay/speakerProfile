<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import BaseMap from '../Components/BaseMap.vue';

interface Project {
    id: number;
    name: string;
    slug: string;
    location: string | null;
    community: string | null;
    budget: string | null;
    funding_source: string | null;
    start_date: string | null;
    expected_completion: string | null;
    completion_percentage: number;
    beneficiaries_count: number;
    status_project: string;
    summary: string | null;
    description: string | null;
    category?: { name: string };
    state?: { name: string };
    lga?: { name: string };
}

interface Media {
    before?: string;
    during?: string;
    after?: string;
    gallery: string[];
    documents: Array<{ name: string; url: string }>;
    videos: string[];
}

interface MapConfig {
    provider: 'google' | 'mapbox' | 'openstreetmap';
    api_key: string;
    latitude: string;
    longitude: string;
    zoom: number;
}

defineProps<{
    project: Project;
    media: Media;
    related: Project[];
    mapConfig: MapConfig;
}>();
</script>

<template>
    <PublicLayout :title="project.name">
        <Head>
            <meta name="description" :content="project.summary || ''" />
        </Head>

        <div class="max-w-5xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/projects" class="hover:text-[#008751]">Constituency Projects</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ project.name }}</span>
            </nav>

            <!-- Header Info -->
            <div class="space-y-4">
                <span v-if="project.category?.name" class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ project.category.name }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ project.name }}
                </h1>
                
                <div v-if="project.state?.name || project.lga?.name || project.community || project.status_project" class="flex flex-wrap gap-4 text-xs text-[#64748B] font-semibold pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span v-if="project.state?.name">
                        <strong>State:</strong> {{ project.state.name }}
                    </span>
                    <span v-if="project.lga?.name">
                        <strong>LGA:</strong> {{ project.lga.name }}
                    </span>
                    <span v-if="project.community">
                        <strong>Community:</strong> {{ project.community }}
                    </span>
                    <span v-if="project.status_project" class="bg-[#008751]/10 text-[#008751] px-2 py-0.5 rounded font-bold uppercase">
                        {{ project.status_project }}
                    </span>
                </div>
            </div>

            <!-- Content Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Project Summary and Description -->
                    <div v-if="project.summary || project.description" class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                        <div v-if="project.summary" class="border-l-4 border-[#008751] pl-4 text-xs sm:text-sm text-[#172033] font-semibold italic bg-[#008751]/5 py-2 pr-2 leading-relaxed">
                            {{ project.summary }}
                        </div>
                        <div 
                            v-if="project.description"
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="project.description"
                        ></div>
                    </div>

                    <!-- Progress Photos Comparison Row (Before / During / After) -->
                    <div v-if="media.before || media.during || media.after" class="space-y-4">
                        <h3 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider border-b pb-2">Execution Progress Photos</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Before Image -->
                            <div v-if="media.before" class="bg-white border rounded-lg overflow-hidden p-2 text-center space-y-2">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">1. Before Project</span>
                                <div class="bg-slate-100 aspect-video rounded flex items-center justify-center overflow-hidden">
                                    <img :src="media.before" alt="Before progress photo" class="object-cover w-full h-full" />
                                </div>
                            </div>
                            <!-- During Image -->
                            <div v-if="media.during" class="bg-white border rounded-lg overflow-hidden p-2 text-center space-y-2">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">2. During Execution</span>
                                <div class="bg-slate-100 aspect-video rounded flex items-center justify-center overflow-hidden">
                                    <img :src="media.during" alt="During progress photo" class="object-cover w-full h-full" />
                                </div>
                            </div>
                            <!-- After Image -->
                            <div v-if="media.after" class="bg-white border rounded-lg overflow-hidden p-2 text-center space-y-2">
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">3. Completion Stage</span>
                                <div class="bg-slate-100 aspect-video rounded flex items-center justify-center overflow-hidden">
                                    <img :src="media.after" alt="After progress photo" class="object-cover w-full h-full" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photo Gallery Grid -->
                    <div v-if="media.gallery.length > 0" class="space-y-4">
                        <h3 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider border-b pb-2">Media Gallery</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div v-for="(img, idx) in media.gallery" :key="idx" class="bg-slate-100 aspect-video rounded-lg overflow-hidden border border-slate-100">
                                <img :src="img" alt="Gallery image" class="object-cover w-full h-full hover:scale-105 transition duration-300" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Parameters & Map Column -->
                <div class="space-y-6">
                    <!-- Project Timeline & Progress Card -->
                    <div v-if="project.completion_percentage != null || project.start_date || project.expected_completion" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Timeline & Completion</h3>
                        <div class="space-y-4">
                            <!-- Progress gauge -->
                            <div v-if="project.completion_percentage != null" class="space-y-1">
                                <div class="flex justify-between text-[11px] font-bold text-[#172033]">
                                    <span>Completion Status</span>
                                    <span>{{ project.completion_percentage }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-[#008751] h-full rounded-full transition-all duration-300" :style="{ width: `${project.completion_percentage}%` }"></div>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div v-if="project.start_date || project.expected_completion" class="grid grid-cols-2 gap-4 text-xs font-semibold">
                                <div v-if="project.start_date" class="space-y-0.5">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase">Start Date</span>
                                    <span class="text-[#172033]">{{ new Date(project.start_date).toLocaleDateString() }}</span>
                                </div>
                                <div v-if="project.expected_completion" class="space-y-0.5">
                                    <span class="block text-[9px] font-bold text-slate-400 uppercase">Target Completion</span>
                                    <span class="text-[#172033]">{{ new Date(project.expected_completion).toLocaleDateString() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Budget & Cost Indicators Card -->
                    <div v-if="project.budget || project.funding_source || project.beneficiaries_count" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Funding & Details</h3>
                        <div class="space-y-3 text-xs font-semibold">
                            <div v-if="project.budget" class="space-y-0.5">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase">Total Budget</span>
                                <span class="text-[#008751] text-sm font-black">₦{{ Number(project.budget).toLocaleString() }}</span>
                            </div>
                            <div v-if="project.funding_source" class="space-y-0.5">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase">Funding Source</span>
                                <span class="text-[#172033]">{{ project.funding_source }}</span>
                            </div>
                            <div v-if="project.beneficiaries_count" class="space-y-0.5">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase">Beneficiaries</span>
                                <span class="text-[#172033]">{{ Number(project.beneficiaries_count).toLocaleString() }} Citizens</span>
                            </div>
                        </div>
                    </div>

                    <!-- Map Location Card (BaseMap Wrapper) -->
                    <div v-if="project.latitude && project.longitude" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Geographic Coordinates</h3>
                        <div class="h-[220px]">
                            <BaseMap
                                :provider="mapConfig.provider"
                                :apiKey="mapConfig.api_key"
                                :latitude="project.latitude"
                                :longitude="project.longitude"
                                :zoom="mapConfig.zoom"
                                :title="project.name"
                            />
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-400 font-semibold pt-1">
                            <span>Lat: {{ project.latitude }}</span>
                            <span>Lng: {{ project.longitude }}</span>
                        </div>
                    </div>

                    <!-- Documents/Downloads -->
                    <div v-if="media.documents.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Official Documents</h3>
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
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
