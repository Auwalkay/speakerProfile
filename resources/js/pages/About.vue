<script setup lang="ts">
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';

interface AboutData {
    title: string;
    subtitle: string;
    constitutional_role: string;
    legislative_agenda: string;
    coat_of_arms_title: string;
    coat_of_arms_text: string;
}

interface SpeakerData {
    name: string;
    title: string;
    biography: string;
    constituency: string;
    education: string;
    image_url?: string;
}

const props = defineProps<{
    about?: AboutData;
    speaker?: SpeakerData;
}>();
</script>

<template>
    <PublicLayout title="About the Office">
        <div class="max-w-4xl mx-auto space-y-10">
            <SectionHeader 
                :title="props.about?.title || 'Office of the Speaker of the House of Representatives'" 
                :subtitle="props.about?.subtitle || 'The constitutional mandate, leadership profile, and structure of the House of Representatives.'" 
            />

            <!-- Speaker Biography Profile Card -->
            <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-center md:items-start gap-8">
                <div class="w-36 h-48 sm:w-44 sm:h-56 rounded-lg overflow-hidden border-2 border-[#D4AF37]/40 shadow-sm flex-shrink-0 bg-slate-100">
                    <img 
                        :src="props.speaker?.image_url || '/images/speaker_portrait.png'" 
                        :alt="props.speaker?.name || 'Speaker Portrait'"
                        class="w-full h-full object-cover object-top"
                    />
                </div>
                <div class="space-y-4 flex-1 text-center md:text-left">
                    <div>
                        <span class="inline-block px-2.5 py-1 text-xs font-semibold text-[#006837] bg-[#006837]/10 rounded-md mb-2">
                            Speaker Biography
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#172033]">
                            {{ props.speaker?.name || 'Rt. Hon. Tajudeen Abbas, Ph.D' }}
                        </h2>
                        <p class="text-xs sm:text-sm font-medium text-[#006837] mt-0.5">
                            {{ props.speaker?.title || 'Speaker, 10th House of Representatives' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 text-xs text-[#64748B]">
                        <span v-if="props.speaker?.constituency" class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-200 rounded-full">
                            <svg class="w-3.5 h-3.5 text-[#006837]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ props.speaker.constituency }}
                        </span>
                        <span v-if="props.speaker?.education" class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-200 rounded-full">
                            <svg class="w-3.5 h-3.5 text-[#006837]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            {{ props.speaker.education }}
                        </span>
                    </div>

                    <p class="text-xs sm:text-sm text-[#64748B] leading-relaxed whitespace-pre-line text-justify">
                        {{ props.speaker?.biography || 'Rt. Hon. Tajudeen Abbas, Ph.D, is a distinguished academician, public administrator, and senior legislator. Serving as the Speaker of the 10th House of Representatives, he has sponsored numerous legislative bills and spearheaded reforms aimed at economic revitalisation, national security oversight, and transparent public resource governance.' }}
                    </p>
                </div>
            </div>

            <!-- Constitutional Role & Legislative Agenda -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-[#172033]">Constitutional Role</h3>
                <p class="text-xs sm:text-sm text-[#64748B] leading-relaxed whitespace-pre-line">
                    {{ props.about?.constitutional_role || 'Under Section 50 of the Constitution of the Federal Republic of Nigeria, the Speaker of the House of Representatives acts as the presiding officer of the House. The Speaker coordinates the legislative activity of the lower chamber of the National Assembly, represents the house in external communications, and acts on behalf of the constituency represented.' }}
                </p>
                
                <h3 class="text-lg font-bold text-[#172033] pt-4">Legislative Agenda</h3>
                <p class="text-xs sm:text-sm text-[#64748B] leading-relaxed whitespace-pre-line">
                    {{ props.about?.legislative_agenda || 'The office focuses on steering the legislative agenda towards socio-economic development, robust security oversight, educational empowerment, infrastructural progress, and transparency in public resource utilization.' }}
                </p>
            </div>

            <!-- Nigerian Coat of Arms Section -->
            <div class="bg-[#172033] text-white p-8 rounded-xl flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-8">
                <div class="w-20 h-20 rounded-full bg-white/10 flex items-center justify-center border-2 border-[#D4AF37] flex-shrink-0">
                    <span class="text-xl font-bold text-[#D4AF37]">COA</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-[#D4AF37] uppercase tracking-wider">
                        {{ props.about?.coat_of_arms_title || 'Federal Republic of Nigeria' }}
                    </h4>
                    <p class="text-xs text-slate-300 leading-relaxed mt-1.5 whitespace-pre-line">
                        {{ props.about?.coat_of_arms_text || 'Our institution acts as the voice of the Nigerian populace across 360 federal constituencies. All programs and projects published on this portal represent the verified stewardship of the Office.' }}
                    </p>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
