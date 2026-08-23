<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';

interface Bill {
    id: number;
    title: string;
    slug: string;
    bill_number: string | null;
    status_legislative: string;
    summary: string | null;
}

interface Motion {
    id: number;
    title: string;
    slug: string;
    sponsor: string | null;
    summary: string | null;
}

defineProps<{
    recentBills: Bill[];
    recentMotions: Motion[];
}>();
</script>

<template>
    <PublicLayout title="Legislative Work Overview">
        <SectionHeader
            title="Legislative Activity & Records"
            subtitle="Explore official documents and summaries of sponsored bills, parliamentary motions, and resolutions."
        />

        <!-- Section Navigation -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <!-- Bills navigation card -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between items-start space-y-6 hover:shadow-md transition">
                <div class="space-y-3">
                    <span class="text-xs font-bold text-[#008751] uppercase tracking-wider block">Official Bills</span>
                    <h3 class="text-xl font-bold text-[#172033]">Sponsored & Facilitated Bills</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                        Access the complete archive of legislations sponsored by the Office, including date introduced, status of consideration, and downloadable PDF drafts.
                    </p>
                </div>
                <Link
                    href="/legislative-work/bills"
                    class="bg-[#008751] hover:bg-[#008751]/95 text-white px-6 py-2.5 rounded-full text-xs font-bold transition shadow-sm"
                >
                    View All Bills &rarr;
                </Link>
            </div>

            <!-- Motions navigation card -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between items-start space-y-6 hover:shadow-md transition">
                <div class="space-y-3">
                    <span class="text-xs font-bold text-[#D4AF37] uppercase tracking-wider block">Parliamentary Motions</span>
                    <h3 class="text-xl font-bold text-[#172033]">Presented House Motions</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                        Explore key resolutions, oversight directives, and national importance motions moved during assembly sessions.
                    </p>
                </div>
                <Link
                    href="/legislative-work/motions"
                    class="bg-[#172033] hover:bg-[#172033]/95 text-white px-6 py-2.5 rounded-full text-xs font-bold transition shadow-sm"
                >
                    View All Motions &rarr;
                </Link>
            </div>
        </div>

        <!-- Recent Highlights rows -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Recent Bills -->
            <div class="space-y-6">
                <h4 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider border-b pb-3">Recent Bills</h4>
                <div v-if="recentBills.length > 0" class="space-y-4">
                    <div 
                        v-for="bill in recentBills" 
                        :key="bill.id" 
                        class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-2 hover:border-[#008751]/20 transition"
                    >
                        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400">
                            <span>{{ bill.bill_number }}</span>
                            <span class="bg-[#008751]/15 text-[#008751] px-1.5 py-0.5 rounded">{{ bill.status_legislative }}</span>
                        </div>
                        <h5 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition">
                            <Link :href="`/legislative-work/${bill.slug}`">{{ bill.title }}</Link>
                        </h5>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ bill.summary }}</p>
                    </div>
                </div>
                <div v-else class="text-xs text-slate-400 py-6 text-center bg-white border border-slate-100 rounded-lg">
                    No recent bills records.
                </div>
            </div>

            <!-- Recent Motions -->
            <div class="space-y-6">
                <h4 class="text-sm font-extrabold text-[#172033] uppercase tracking-wider border-b pb-3">Recent Motions</h4>
                <div v-if="recentMotions.length > 0" class="space-y-4">
                    <div 
                        v-for="motion in recentMotions" 
                        :key="motion.id" 
                        class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm space-y-2 hover:border-[#008751]/20 transition"
                    >
                        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400">
                            <span>Sponsor: {{ motion.sponsor || 'Official' }}</span>
                        </div>
                        <h5 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition">
                            <Link :href="`/legislative-work/${motion.slug}`">{{ motion.title }}</Link>
                        </h5>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ motion.summary }}</p>
                    </div>
                </div>
                <div v-else class="text-xs text-slate-400 py-6 text-center bg-white border border-slate-100 rounded-lg">
                    No recent motions records.
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
