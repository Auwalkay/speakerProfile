<script setup lang="ts">
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';
</script>

<template>
    <PublicLayout title="About the Office">
        <div class="max-w-4xl mx-auto space-y-10">
            <SectionHeader 
                title="Office of the Speaker of the House of Representatives" 
                subtitle="The constitutional mandate, leadership profile, and structure of the House of Representatives." 
            />

            <!-- Main Info -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-[#172033]">Constitutional Role</h3>
                <p class="text-xs sm:text-sm text-[#64748B] leading-relaxed">
                    Under Section 50 of the Constitution of the Federal Republic of Nigeria, the Speaker of the House of Representatives acts as the presiding officer of the House. The Speaker coordinates the legislative activity of the lower chamber of the National Assembly, represents the house in external communications, and acts on behalf of the constituency represented.
                </p>
                
                <h3 class="text-lg font-bold text-[#172033] pt-4">Legislative Agenda</h3>
                <p class="text-xs sm:text-sm text-[#64748B] leading-relaxed">
                    The office focuses on steering the legislative agenda towards socio-economic development, robust security oversight, educational empowerment, infrastructural progress, and transparency in public resource utilization.
                </p>
            </div>

            <!-- Nigerian Coat of Arms Section -->
            <div class="bg-[#172033] text-white p-8 rounded-xl flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-8">
                <div class="w-20 h-20 rounded-full bg-white/10 flex items-center justify-center border-2 border-[#D4AF37] flex-shrink-0">
                    <span class="text-xl font-bold text-[#D4AF37]">COA</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-[#D4AF37] uppercase tracking-wider">Federal Republic of Nigeria</h4>
                    <p class="text-xs text-slate-300 leading-relaxed mt-1.5">
                        Our institution acts as the voice of the Nigerian populace across 360 federal constituencies. All programs and projects published on this portal represent the verified stewardship of the Office.
                    </p>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
