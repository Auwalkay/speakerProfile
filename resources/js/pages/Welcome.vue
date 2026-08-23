<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import HeroSection from '../Components/HeroSection.vue';

interface StatsData {
    bills_sponsored: number;
    bills_sponsored_is_demo: boolean;
    bills_passed: number;
    bills_passed_is_demo: boolean;
    projects_count: number;
    projects_count_is_demo: boolean;
    beneficiaries: number;
    beneficiaries_is_demo: boolean;
}

interface News {
    id: number;
    title: string;
    slug: string;
    summary: string | null;
    category?: { name: string };
    published_at: string | null;
}

interface HeroSlide {
    id: number;
    title: string;
    subtitle: string | null;
    badge: string | null;
    link_text: string;
    link_url: string;
    image_url: string;
    side_image_url: string | null;
}

const props = defineProps<{
    stats: StatsData;
    news: News[];
    speakerImageUrl: string;
    speakerSpeech: string;
    heroSlides: HeroSlide[];
}>();

// Pillars of Progress mock cards
const pillars = [
    {
        title: 'Legislative Reform',
        description: 'Modernizing our legal framework to ensure justice, equity, and efficiency in governance.',
        icon: 'fa-solid fa-scale-balanced',
        href: '/legislative-work',
    },
    {
        title: 'Social Welfare',
        description: 'Expanding access to healthcare, clean water, and social safety nets for vulnerable populations.',
        icon: 'fa-solid fa-shield-heart',
        href: '/projects',
    },
    {
        title: 'Infrastructure',
        description: 'Investing in roads, bridges, and power to connect communities and drive economic activity.',
        icon: 'fa-solid fa-building',
        href: '/achievements',
    },
];

// Fallback mock news if database has no published news, to match the image precisely
const displayNews = props.news.length > 0 ? props.news : [
    {
        id: 1,
        title: 'House Passes Landmark Bill on Renewable Energy Integration',
        summary: 'The new legislation aims to diversify the nation\'s energy mix and promote sustainable practices...',
        category: { name: 'SESSION' },
        published_at: '2026-10-24T12:00:00Z',
    },
    {
        id: 2,
        title: 'Speaker Inaugurates Special Committee on Youth Empowerment',
        summary: 'A newly formed committee will focus exclusively on policies that enhance educational and...',
        category: { name: 'COMMITTEE' },
        published_at: '2026-10-20T12:00:00Z',
    },
    {
        id: 3,
        title: 'Commissioning of New Healthcare Centers in Rural Communities',
        summary: 'Five new primary healthcare facilities were opened today, significantly improving medical...',
        category: { name: 'CONSTITUENCY' },
        published_at: '2026-10-15T12:00:00Z',
    },
];
</script>

<template>
    <PublicLayout title="Home">
        <HeroSection :slides="heroSlides" :speakerImageUrl="speakerImageUrl" :speakerSpeech="speakerSpeech" />

        <!-- Impact Statistics (Flat list exactly matching image) -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10 border-t border-slate-100 mb-16" aria-label="Impact Statistics">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6 text-center">
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">240+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">BILLS SPONSORED</span>
                </div>
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">180+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">BILLS PASSED</span>
                </div>
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">1,200+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">PROJECTS</span>
                </div>
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">5M+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">CITIZENS IMPACTED</span>
                </div>
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">15,000+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">SCHOLARSHIPS</span>
                </div>
                <div class="space-y-1">
                    <span class="block text-2xl sm:text-3xl font-black text-[#008751]">450+</span>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest leading-none">EMPOWERMENT</span>
                </div>
            </div>
        </section>

        <!-- Pillars of Progress Section -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10 mb-16 text-center" aria-labelledby="pillars-title">
            <div class="max-w-xl mx-auto space-y-2 mb-12">
                <h3 id="pillars-title" class="text-xl sm:text-2xl font-black text-[#172033]">Pillars of Progress</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-semibold">
                    Key areas of focus driving national development and improving the lives of citizens.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div 
                    v-for="pillar in pillars" 
                    :key="pillar.title" 
                    class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between items-start text-left hover:shadow-md transition duration-200"
                >
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-full bg-[#008751]/10 flex items-center justify-center text-sm">
                            <i :class="[pillar.icon, 'text-[#008751]']"></i>
                        </div>
                        <h4 class="text-sm font-bold text-[#172033]">{{ pillar.title }}</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            {{ pillar.description }}
                        </p>
                    </div>
                    <Link :href="pillar.href" class="text-xs font-bold text-[#008751] hover:underline mt-6 inline-flex items-center space-x-1">
                        <span>Read More</span>
                        <span>&rarr;</span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Latest Updates Section -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10 mb-20" aria-labelledby="news-title">
            <div class="flex justify-between items-end mb-10 border-b border-slate-100 pb-4">
                <div>
                    <h3 id="news-title" class="text-xl font-black text-[#172033]">Latest Updates</h3>
                    <p class="text-xs text-slate-500 mt-1 font-semibold">News and announcements from the Office.</p>
                </div>
                <Link href="/news" class="text-xs font-bold text-[#008751] hover:underline focus:outline-none">View All News</Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div 
                    v-for="item in displayNews" 
                    :key="item.id" 
                    class="bg-white rounded-xl overflow-hidden flex flex-col justify-between border border-slate-100 shadow-sm group hover:shadow-md transition"
                >
                    <div>
                        <!-- Image placeholder matching reference image layout -->
                        <div class="bg-slate-100 aspect-video w-full relative flex items-center justify-center text-slate-400">
                            <!-- Overlay badge -->
                            <span class="absolute top-3 left-3 bg-[#172033] text-white text-[9px] font-bold px-2 py-0.5 rounded tracking-wide uppercase">
                                {{ item.category?.name || 'UPDATE' }}
                            </span>
                            <span class="text-[9px] font-bold tracking-wider uppercase">Official Photo Release</span>
                        </div>
                        <div class="p-6 space-y-2">
                            <span class="block text-[10px] font-semibold text-slate-400">
                                {{ item.published_at ? new Date(item.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '' }}
                            </span>
                            <h4 class="text-sm font-bold text-[#172033] group-hover:text-[#008751] transition line-clamp-2">
                                <Link :href="`/news/${item.slug}`">{{ item.title }}</Link>
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-3">
                                {{ item.summary }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
