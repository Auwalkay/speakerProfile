<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PublicLayout from '../Layouts/PublicLayout.vue';
import SectionHeader from '../Components/SectionHeader.vue';

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post('/contact', {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <PublicLayout title="Contact the Office">
        <div class="max-w-xl mx-auto">
            <SectionHeader
                title="Contact the Office"
                subtitle="Submit official feedback, inquiries, or media requests directly to the administrative wing."
            />

            <!-- Form Card -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm space-y-6">
                <!-- Success Alert -->
                <div 
                    v-if="flashSuccess" 
                    class="bg-emerald-50 border border-emerald-200 text-[#008751] p-4 rounded-lg text-xs font-bold uppercase tracking-wider"
                    role="alert"
                >
                    {{ flashSuccess }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="flex flex-col space-y-1">
                        <label for="contact-name" class="text-xs font-bold text-[#172033] uppercase tracking-wider">Full Name</label>
                        <input
                            id="contact-name"
                            type="text"
                            required
                            v-model="form.name"
                            class="bg-[#F8FAFC] border border-slate-300 text-xs px-3.5 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033]"
                        />
                        <span v-if="form.errors.name" class="text-[10px] text-red-600 font-bold uppercase">{{ form.errors.name }}</span>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="contact-email" class="text-xs font-bold text-[#172033] uppercase tracking-wider">Email Address</label>
                        <input
                            id="contact-email"
                            type="email"
                            required
                            v-model="form.email"
                            class="bg-[#F8FAFC] border border-slate-300 text-xs px-3.5 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033]"
                        />
                        <span v-if="form.errors.email" class="text-[10px] text-red-600 font-bold uppercase">{{ form.errors.email }}</span>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="contact-subject" class="text-xs font-bold text-[#172033] uppercase tracking-wider">Subject</label>
                        <input
                            id="contact-subject"
                            type="text"
                            v-model="form.subject"
                            class="bg-[#F8FAFC] border border-slate-300 text-xs px-3.5 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033]"
                        />
                        <span v-if="form.errors.subject" class="text-[10px] text-red-600 font-bold uppercase">{{ form.errors.subject }}</span>
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="contact-message" class="text-xs font-bold text-[#172033] uppercase tracking-wider">Message</label>
                        <textarea
                            id="contact-message"
                            rows="5"
                            required
                            v-model="form.message"
                            class="bg-[#F8FAFC] border border-slate-300 text-xs px-3.5 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#008751] focus:border-transparent text-[#172033]"
                        ></textarea>
                        <span v-if="form.errors.message" class="text-[10px] text-red-600 font-bold uppercase">{{ form.errors.message }}</span>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-[#008751] hover:bg-[#008751]/90 disabled:opacity-50 text-white font-bold uppercase tracking-wider py-3 rounded-lg text-xs transition shadow-sm focus:outline-none focus:ring-2 focus:ring-[#008751]"
                    >
                        {{ form.processing ? 'Submitting...' : 'Send Message' }}
                    </button>
                </form>
            </div>
        </div>
    </PublicLayout>
</template>
