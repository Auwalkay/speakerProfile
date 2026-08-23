<script setup lang="ts">
// Reusable premium SVG Coat of Arms representation
</script>

<template>
    <svg 
        viewBox="0 0 100 100" 
        fill="none" 
        xmlns="http://www.w3.org/2000/svg"
        class="w-full h-full text-[#008751] select-none"
        aria-hidden="true"
    >
        <!-- Gold Outer Ring -->
        <circle cx="50" cy="50" r="48" stroke="#D4AF37" stroke-width="1.5" />
        <!-- Nigeria Green Inner Ring -->
        <circle cx="50" cy="50" r="45" stroke="#008751" stroke-width="2" fill="#008751" fill-opacity="0.03" />

        <!-- Eagle (Top) -->
        <path d="M42 22C42 22 45 15 50 15C55 15 58 22 58 22C58 22 54 21 50 21C46 21 42 22 42 22Z" fill="#D4AF37" />
        <path d="M45 22.5L50 17L55 22.5H45Z" fill="#D4AF37" />
        
        <!-- Shield (Center) -->
        <path d="M42 32C42 30 58 30 58 32V48C58 53 50 56 50 56C50 56 42 53 42 48V32Z" fill="#172033" stroke="#D4AF37" stroke-width="1.5" />
        <!-- Silver/White Pall (Y-Shape representing Niger & Benue Rivers) -->
        <path d="M50 32V42L44 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
        <path d="M50 42L56 48" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
        
        <!-- Left Supporting Horse -->
        <path d="M30 48C30 42 35 34 38 34C37 38 35 44 38 48C40 51 38 56 36 58C34 56 30 54 30 48Z" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="0.75" />
        <path d="M31 52L27 58H33L31 52Z" fill="#FFFFFF" />

        <!-- Right Supporting Horse -->
        <path d="M70 48C70 42 65 34 62 34C63 38 65 44 62 48C60 51 62 56 64 58C66 56 70 54 70 48Z" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="0.75" />
        <path d="M69 52L73 58H67L69 52Z" fill="#FFFFFF" />

        <!-- Red Flowers / Base (CoCo) -->
        <path d="M32 58C40 60 60 60 68 58C62 61 38 61 32 58Z" fill="#008751" stroke="#008751" stroke-width="2" />
        
        <!-- Ribbon / Motto Scroll -->
        <path d="M35 62C40 64 60 64 65 62L62 65C58 66 42 66 38 65L35 62Z" fill="#D4AF37" />
        <path d="M40 62.5H60" stroke="#172033" stroke-width="0.5" />
    </svg>
</template>
