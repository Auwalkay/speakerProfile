<script setup lang="ts">
import { ref, computed } from 'vue';
import PublicLayout from '../Layouts/PublicLayout.vue';

interface Appointee {
    id: number;
    name: string;
    designation: string;
    category: string;
    bio: string | null;
    avatar_url: string;
}

const props = defineProps<{
    appointees: Appointee[];
}>();

const selectedCategory = ref('All');

const categories = ['All', 'Chief of Staff', 'Special Adviser', 'Senior Special Assistant', 'Special Assistant', 'Aide'];

const filteredAppointees = computed(() => {
    if (selectedCategory.value === 'All') {
        return props.appointees;
    }
    return props.appointees.filter(a => a.category === selectedCategory.value);
});
</script>

<template>
    <PublicLayout title="Appointees & Aides">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 space-y-12">
            <!-- Header section -->
            <div class="text-center max-w-3xl mx-auto space-y-4">
                <div class="inline-flex items-center space-x-2 bg-emerald-50 border border-emerald-100/80 px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#008751] animate-pulse"></span>
                    <span class="text-[10px] font-black tracking-widest text-[#008751] uppercase">Office of the Speaker</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-[#172033] tracking-tight uppercase">Appointees & Special Advisers</h1>
                <p class="text-sm text-slate-500 font-semibold leading-relaxed">
                    Meet the dedicated professionals, advisers, and aides supporting the Speaker in delivering legislative excellence and constituency progress.
                </p>
                <div class="w-20 h-[3px] bg-[#D4AF37] mx-auto mt-2"></div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-2 border-b border-slate-100 pb-6">
                <button
                    v-for="cat in categories"
                    :key="cat"
                    @click="selectedCategory = cat"
                    class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200"
                    :class="selectedCategory === cat 
                        ? 'bg-[#008751] text-white shadow-md' 
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50'"
                >
                    {{ cat === 'All' ? 'All Appointees' : cat }}
                </button>
            </div>

            <!-- Grid container -->
            <div v-if="filteredAppointees.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div 
                    v-for="appointee in filteredAppointees" 
                    :key="appointee.id" 
                    class="bg-white border border-slate-100 rounded-3xl p-6 text-center space-y-5 shadow-sm hover:shadow-md transition duration-300 relative group overflow-hidden"
                >
                    <!-- Small decorative top badge -->
                    <div class="absolute top-4 right-4">
                        <span class="text-[8px] font-black tracking-widest uppercase px-2 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-100">
                            {{ appointee.category }}
                        </span>
                    </div>

                    <!-- Profile Photo Frame -->
                    <div class="relative w-28 h-28 mx-auto rounded-full overflow-hidden p-1 border-2 border-slate-100 group-hover:border-[#008751]/30 transition duration-300 aspect-square">
                        <img 
                            :src="appointee.avatar_url" 
                            :alt="appointee.name" 
                            class="w-full h-full object-cover rounded-full"
                        />
                    </div>

                    <!-- Appointee Details -->
                    <div class="space-y-1">
                        <h3 class="text-sm font-black text-[#172033] tracking-wide uppercase leading-tight">{{ appointee.name }}</h3>
                        <p class="text-xs text-[#008751] font-extrabold tracking-wide uppercase">{{ appointee.designation }}</p>
                    </div>

                    <!-- Bio Snippet -->
                    <p class="text-xs text-slate-500 font-semibold leading-relaxed line-clamp-3">
                        {{ appointee.bio || 'No bio details provided yet.' }}
                    </p>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-16 bg-white border border-slate-100 rounded-3xl max-w-xl mx-auto p-8 space-y-4">
                <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto text-slate-400">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <h3 class="text-sm font-black text-[#172033] uppercase">No Appointees Found</h3>
                <p class="text-xs text-slate-500 font-semibold">We couldn't find any appointees matching the selected category at this time.</p>
            </div>
        </div>
    </PublicLayout>
</template>
