<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(defineProps<{
    provider?: 'google' | 'mapbox' | 'openstreetmap';
    apiKey?: string;
    latitude: string | number;
    longitude: string | number;
    zoom?: number;
    title?: string;
}>(), {
    provider: 'openstreetmap',
    apiKey: '',
    zoom: 13,
    title: 'Project Map Location',
});

// Build the standard openstreetmap iframe URL or fallbacks
const iframeUrl = computed(() => {
    const lat = Number(props.latitude);
    const lon = Number(props.longitude);
    
    if (props.provider === 'google' && props.apiKey) {
        return `https://www.google.com/maps/embed/v1/view?key=${props.apiKey}&center=${lat},${lon}&zoom=${props.zoom}`;
    }
    
    if (props.provider === 'mapbox' && props.apiKey) {
        return `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/${lon},${lat},${props.zoom}/600x400?access_token=${props.apiKey}`;
    }
    
    // Default openstreetmap embed link
    const bboxLeft = lon - 0.01;
    const bboxBottom = lat - 0.01;
    const bboxRight = lon + 0.01;
    const bboxTop = lat + 0.01;
    return `https://www.openstreetmap.org/export/embed.html?bbox=${bboxLeft}%2C${bboxBottom}%2C${bboxRight}%2C${bboxTop}&layer=mapnik&marker=${lat}%2C${lon}`;
});
</script>

<template>
    <div class="w-full h-full relative rounded-xl overflow-hidden bg-slate-100 border border-slate-200 min-h-[300px]">
        <iframe
            :title="title"
            width="100%"
            height="100%"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
            :src="iframeUrl"
            class="w-full h-full min-h-[300px]"
            loading="lazy"
        ></iframe>
    </div>
</template>
