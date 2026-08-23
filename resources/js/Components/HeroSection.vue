<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

interface Slide {
    id: number;
    title: string;
    subtitle: string | null;
    badge: string | null;
    link_text: string;
    link_url: string;
    image_url: string | null;
    side_image_url: string | null;
}

const props = defineProps<{
    slides: Slide[];
    speakerImageUrl: string;
    speakerSpeech: string;
}>();

const activeSlide = ref(0);
let slideInterval: any = null;

// Fallback images for seeded slides
const fallbackImages = [
    '/images/national_assembly.png',
    '/images/project_placeholder.png',
    '/images/news_placeholder.png'
];

const getSlideImage = (slide: Slide, index: number): string => {
    if (slide.image_url && slide.image_url.trim() !== '') {
        return slide.image_url;
    }
    return fallbackImages[index % fallbackImages.length];
};

const getSideImage = (slide: Slide, index: number): string => {
    if (slide.side_image_url && slide.side_image_url.trim() !== '') {
        return slide.side_image_url;
    }
    if (index === 0) return props.speakerImageUrl;
    return fallbackImages[index % fallbackImages.length];
};

const nextSlide = () => {
    if (props.slides.length > 0) {
        activeSlide.value = (activeSlide.value + 1) % props.slides.length;
    }
};

const prevSlide = () => {
    if (props.slides.length > 0) {
        activeSlide.value = (activeSlide.value - 1 + props.slides.length) % props.slides.length;
    }
};

const setSlide = (index: number) => {
    activeSlide.value = index;
};

onMounted(() => {
    if (props.slides.length > 0) {
        slideInterval = setInterval(nextSlide, 8000);
    }
});

onUnmounted(() => {
    if (slideInterval) clearInterval(slideInterval);
});
</script>

<template>
    <section class="relative bg-[#172033] overflow-hidden min-h-[580px] lg:min-h-[620px] flex items-center border-b border-slate-900" aria-labelledby="hero-title">
        <!-- Background Slider Crossfade Images -->
        <div v-if="slides && slides.length > 0" class="absolute inset-0 z-0">
            <div 
                v-for="(slide, index) in slides" 
                :key="slide.id"
                class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :style="{ opacity: activeSlide === index ? 0.3 : 0, pointerEvents: activeSlide === index ? 'auto' : 'none' }"
            >
                <img :src="getSlideImage(slide, index)" class="w-full h-full object-cover" alt="Hero background" />
            </div>
            <!-- Dark Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#172033] via-[#172033]/90 to-[#172033]/70"></div>
        </div>

        <!-- Subtle Federal Gold Accent Line -->
        <div class="absolute top-0 left-0 w-full h-[6px] bg-gradient-to-r from-[#008751] via-[#D4AF37] to-[#008751] z-20"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center relative z-10 w-full">
            <!-- Left Info Area (7 cols) -->
            <div class="lg:col-span-7 text-left space-y-6 sm:space-y-8 min-h-[300px] sm:min-h-[360px] flex flex-col justify-center">
                
                <!-- Slide-specific text content transitions -->
                <div v-if="slides && slides.length > 0">
                    <div 
                        v-for="(slide, index) in slides" 
                        :key="'text-' + slide.id" 
                        v-show="activeSlide === index" 
                        class="space-y-4 sm:space-y-6 animate-[fadeIn_0.5s_ease-out]"
                    >
                        <!-- Badge -->
                        <div v-if="slide.badge" class="inline-flex items-center space-x-2 bg-white/5 border border-white/10 px-3 py-1 rounded-full">
                            <span class="text-[9px] sm:text-[10px] font-black tracking-widest text-[#D4AF37] uppercase">{{ slide.badge }}</span>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            <span class="block text-[10px] sm:text-xs font-black tracking-wider text-[#008751] uppercase">Federal Republic of Nigeria</span>
                            <h2 id="hero-title" class="text-2xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-white leading-[1.1] tracking-tight uppercase break-words">
                                {{ slide.title }}
                            </h2>
                            <p v-if="slide.subtitle" class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-semibold max-w-xl">
                                {{ slide.subtitle }}
                            </p>
                        </div>

                        <!-- Slide Link Button -->
                        <div class="pt-2">
                            <Link
                                :href="slide.link_url || '/achievements'"
                                class="inline-block bg-[#008751] hover:bg-[#008751]/95 text-white px-8 py-3.5 rounded-full text-xs font-extrabold uppercase tracking-wider transition shadow-lg hover:shadow-xl focus:outline-none"
                            >
                                {{ slide.link_text || 'Explore' }}
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Custom Blockquote for Speaker's Quote, pinned below slide content -->
                <div class="border-t border-white/10 pt-6 mt-4">
                    <p class="text-xs text-slate-400 font-medium italic">
                        "{{ speakerSpeech }}"
                    </p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="w-4 h-[1px] bg-[#D4AF37]"></span>
                        <span class="text-[9px] font-bold text-[#D4AF37] tracking-widest uppercase">Speaker's Welcome</span>
                    </div>
                </div>
            </div>

            <!-- Right Content Area: Portrait Presentation (5 cols) -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end relative">
                <!-- Abstract circular frames behind the portrait -->
                <div class="absolute -top-12 -left-12 w-64 h-64 rounded-full bg-[#008751]/10 blur-2xl"></div>
                <div class="absolute -bottom-12 -right-12 w-64 h-64 rounded-full bg-[#D4AF37]/10 blur-2xl"></div>

                <!-- Main Glassmorphism Frame Wrapper -->
                <div class="relative p-3 bg-white/5 border border-white/10 rounded-3xl shadow-2xl w-full max-w-[320px] group transition duration-300">
                    <!-- Image Container -->
                    <div class="relative rounded-2xl overflow-hidden bg-slate-800 w-full h-[380px]">
                        <div 
                            v-for="(slide, index) in slides" 
                            :key="'side-' + slide.id"
                            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                            :style="{ opacity: activeSlide === index ? 1 : 0, pointerEvents: activeSlide === index ? 'auto' : 'none' }"
                        >
                            <img 
                                :src="getSideImage(slide, index)" 
                                alt="Official Presentation Image" 
                                class="w-full h-full object-cover transition duration-500"
                            />
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#172033] via-[#172033]/25 to-transparent pointer-events-none" style="pointer-events: none;"></div>

                        <!-- Banner Info on top of Image bottom -->
                        <div class="absolute bottom-0 left-0 w-full p-5 text-left space-y-1 z-10">
                            <span class="text-[9px] font-black text-[#D4AF37] tracking-widest uppercase">Hon. Speaker</span>
                            <h3 class="text-sm font-bold text-white tracking-wide leading-none">Rt. Hon. Abbas Tajudeen, Ph.D</h3>
                            <p class="text-[9px] font-semibold text-slate-300 uppercase tracking-wider">Speaker, House of Representatives</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Controls (manual paging buttons & indicators) -->
        <div v-if="slides && slides.length > 1" class="absolute bottom-6 left-6 lg:left-8 flex items-center space-x-6 z-20">
            <!-- Prev / Next arrows -->
            <div class="flex items-center space-x-2">
                <button @click="prevSlide" class="w-8 h-8 rounded-full border border-white/15 text-white/70 hover:text-white hover:bg-white/5 flex items-center justify-center transition focus:outline-none">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button @click="nextSlide" class="w-8 h-8 rounded-full border border-white/15 text-white/70 hover:text-white hover:bg-white/5 flex items-center justify-center transition focus:outline-none">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
            
            <!-- Pagination dots -->
            <div class="flex items-center space-x-2">
                <button 
                    v-for="(slide, index) in slides" 
                    :key="slide.id"
                    @click="setSlide(index)"
                    class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                    :class="activeSlide === index ? 'bg-[#008751] w-6' : 'bg-white/20 hover:bg-white/40'"
                ></button>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
