<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Speech {
    id: number;
    title: string;
    slug: string;
    event: string | null;
    location: string | null;
    speech_date: string | null;
    summary: string | null;
    content: string | null;
    transcript: string | null;
    video_url: string | null;
}

defineProps<{
    speech: Speech;
    pdfUrl?: string;
    related: Speech[];
}>();
</script>

<template>
    <PublicLayout :title="speech.title">
        <Head>
            <meta name="description" :content="speech.summary || ''" />
        </Head>

        <div class="max-w-4xl mx-auto space-y-10">
            <!-- Breadcrumbs -->
            <nav class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-[#008751]">Home</Link>
                <span>/</span>
                <Link href="/speeches" class="hover:text-[#008751]">Speeches</Link>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-[240px]">{{ speech.title }}</span>
            </nav>

            <!-- Speech Details Header -->
            <div class="space-y-4">
                <span class="inline-block bg-[#008751]/10 text-[#008751] px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    Official Speech
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#172033] tracking-tight leading-tight">
                    {{ speech.title }}
                </h1>
                
                <div class="flex flex-wrap gap-4 text-xs text-[#64748B] font-semibold pt-2 border-t border-[#E2E8F0] border-b pb-4">
                    <span v-if="speech.speech_date">
                        <strong>Date:</strong> {{ new Date(speech.speech_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
                    </span>
                    <span v-if="speech.event">
                        <strong>Event:</strong> {{ speech.event }}
                    </span>
                    <span v-if="speech.location">
                        <strong>Location:</strong> {{ speech.location }}
                    </span>
                </div>
            </div>

            <!-- Content Area Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Main Transcript -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Audio/Video Embed representation if video_url exists -->
                    <div v-if="speech.video_url" class="bg-slate-100 aspect-video rounded-xl overflow-hidden border border-slate-100 flex items-center justify-center">
                        <iframe 
                            v-if="speech.video_url.includes('youtube.com') || speech.video_url.includes('youtu.be')"
                            :src="speech.video_url" 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            allowfullscreen
                        ></iframe>
                        <a v-else :href="speech.video_url" target="_blank" class="text-[#008751] font-bold hover:underline text-xs flex items-center space-x-1.5">
                            <span>Watch video clip on external portal</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <!-- Transcript Body -->
                    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                        <div v-if="speech.summary" class="text-xs sm:text-sm font-semibold italic text-[#172033] leading-relaxed border-l-4 border-[#008751] pl-4">
                            {{ speech.summary }}
                        </div>
                        <div 
                            class="text-xs sm:text-sm text-[#64748B] leading-relaxed space-y-4 prose max-w-none"
                            v-html="speech.content"
                        ></div>
                        <div v-if="speech.transcript" class="mt-8 border-t pt-8 space-y-4">
                            <h4 class="text-xs font-bold text-[#172033] uppercase tracking-wider">Verbatim Transcript</h4>
                            <div 
                                class="text-xs sm:text-sm text-slate-500 leading-relaxed space-y-4 bg-slate-50 p-4 rounded-lg"
                                v-html="speech.transcript"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Downloads & Recommendations -->
                <div class="space-y-6">
                    <!-- Download Transcript PDF Card -->
                    <div v-if="pdfUrl" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-3 text-center">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2 text-left">Document</h3>
                        <a 
                            :href="pdfUrl" 
                            target="_blank" 
                            class="w-full bg-[#008751] hover:bg-[#008751]/95 text-white py-2.5 rounded-lg text-xs font-bold block transition"
                        >
                            Download PDF Transcript
                        </a>
                    </div>

                    <!-- Related Speeches -->
                    <div v-if="related.length > 0" class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-[#172033] uppercase tracking-wider border-b pb-2">Related Speeches</h3>
                        <div class="space-y-4">
                            <div v-for="item in related" :key="item.id" class="text-xs space-y-1">
                                <Link 
                                    :href="`/speeches/${item.slug}`"
                                    class="font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2 block"
                                >
                                    {{ item.title }}
                                </Link>
                                <span class="text-[9px] text-slate-400 block">{{ item.speech_date ? new Date(item.speech_date).toLocaleDateString() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
