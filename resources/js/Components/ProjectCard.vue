<script setup lang="ts">
interface Project {
    id: number;
    title: string;
    slug: string;
    location: string | null;
    status_project: string;
    cost: string | number | null;
    beneficiaries_count: number | null;
    summary: string | null;
    state?: { name: string };
    lga?: { name: string };
    category?: { name: string };
}

defineProps<{
    project: Project;
}>();
</script>

<template>
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:border-[#008751]/30 transition duration-150">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-start">
                <span class="inline-block bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                    {{ project.category?.name || 'Constituency Project' }}
                </span>
                <span 
                    :class="[
                        project.status_project === 'Completed' || project.status_project === 'Commissioned'
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                            : 'bg-amber-50 text-amber-700 border-amber-100',
                        'border text-[10px] px-2 py-0.5 rounded font-bold'
                    ]"
                >
                    {{ project.status_project }}
                </span>
            </div>
            
            <div class="space-y-1">
                <h3 class="text-sm font-bold text-[#172033] hover:text-[#008751] transition line-clamp-2">
                    {{ project.title }}
                </h3>
                <p class="text-xs text-[#64748B] leading-relaxed line-clamp-3">
                    {{ project.summary || 'No description provided.' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100 text-[10px] text-[#64748B]">
                <div>
                    <span class="block text-slate-400 font-semibold uppercase">Location</span>
                    <span class="font-bold text-[#172033]">{{ project.lga?.name }}, {{ project.state?.name }}</span>
                </div>
                <div v-if="project.beneficiaries_count">
                    <span class="block text-slate-400 font-semibold uppercase">Beneficiaries</span>
                    <span class="font-bold text-[#172033]">{{ project.beneficiaries_count.toLocaleString() }} (DEMO)</span>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-between items-center text-[10px] text-[#64748B] font-medium">
            <span>Cost: {{ project.cost ? `₦${Number(project.cost).toLocaleString()}` : 'N/A' }} (DEMO)</span>
            <span class="text-[#008751] font-bold">Constituency Work</span>
        </div>
    </div>
</template>
