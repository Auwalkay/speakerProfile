<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="bg-[#172033] text-white border-t-2 border-[#008751]" role="contentinfo">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <span class="block text-[#008751] font-black text-sm tracking-wider uppercase">OFFICE OF THE SPEAKER</span>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        House of Representatives, National Assembly Complex, Three Arms Zone, Abuja, Nigeria.
                    </p>
                </div>

                <!-- Column 2 -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold tracking-wider uppercase text-slate-400">Quick Links</h3>
                    <ul class="space-y-2 text-xs text-[#94A3B8]">
                        <li><a href="#" class="hover:text-white transition focus:outline-none">Constituencies</a></li>
                        <li><a href="#" class="hover:text-white transition focus:outline-none">House Rules</a></li>
                        <li><a href="#" class="hover:text-white transition focus:outline-none">Hansard</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold tracking-wider uppercase text-slate-400">Legal</h3>
                    <ul class="space-y-2 text-xs text-[#94A3B8]">
                        <li><a href="#" class="hover:text-white transition focus:outline-none">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition focus:outline-none">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold tracking-wider uppercase text-slate-400">Connect</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition" aria-label="Official Email">
                            @
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition" aria-label="Official Website">
                            w
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-6 text-center md:text-left text-[10px] text-[#94A3B8]">
                <p>&copy; {{ new Date().getFullYear() }} Office of the Speaker, House of Representatives, Nigeria. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</template>
