<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  data: {
    type: Array,
    default: () => []
  }
})

const activeIndex = ref(0)

watch(() => props.data, (newData) => {
  if (newData && newData.length > 0) {
    activeIndex.value = 0
  }
}, { immediate: true })
</script>

<template>
  <section id="experience" class="max-w-4xl mx-auto px-6 py-12 relative">
    
    <div class="mb-8 relative">
      <div class="flex items-center gap-3 mb-2">
        <span class="h-[1px] w-8 bg-sky-500/60"></span>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-400 font-bold">03 // Track Record</h3>
      </div>
      <h2 class="text-2xl font-bold text-white tracking-tight">Experience</h2>
    </div>

    <div v-if="props.data.length" class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
      
      <div class="md:col-span-1">
        <div class="flex flex-col space-y-1.5 border-l border-slate-800/80 pl-2">
          <button
            v-for="(item, index) in props.data"
            :key="'nav-exp-' + item.id"
            @click="activeIndex = index"
            class="text-left py-2.5 px-3 rounded-lg text-xs font-medium transition-all duration-200 relative group overflow-hidden"
            :class="activeIndex === index 
              ? 'text-sky-400 bg-sky-950/30 shadow-sm border border-sky-900/30 font-semibold pl-4' 
              : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/20 hover:pl-4'"
          >
            <span 
              class="absolute left-0 top-1/4 bottom-1/4 w-[2px] bg-gradient-to-b from-sky-400 to-sky-600 rounded-r transition-all duration-200 transform scale-y-0"
              :class="activeIndex === index ? 'scale-y-100' : 'group-hover:scale-y-50'"
            ></span>
            <span class="block truncate font-semibold">{{ item.company }}</span>
          </button>
        </div>
      </div>

      <div class="md:col-span-2 relative min-h-[360px]">
        <div 
          v-for="(item, index) in props.data" 
          :key="'display-exp-' + item.id"
          class="transition-all duration-300"
          :class="activeIndex === index 
            ? 'opacity-100 scale-100 pointer-events-auto h-auto relative' 
            : 'opacity-0 scale-[0.99] pointer-events-none h-0 absolute inset-0'"
        >
          <div class="bg-slate-900/20 border border-slate-800/40 rounded-xl p-5 flex flex-col sm:h-[360px] shadow-xl shadow-black/20">
            
            <div class="mb-4 pb-4 border-b border-slate-800/40 shrink-0">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                <h3 class="text-base font-bold text-white tracking-tight">{{ item.position }}</h3>
                <span class="mono text-[10px] font-medium text-slate-500 self-start sm:self-auto">{{ item.duration }}</span>
              </div>
              <p class="text-xs font-medium text-sky-500/90 mt-1">
                {{ item.company }} <span v-if="item.location" class="text-slate-500">— {{ item.location }}</span>
              </p>
            </div>

            <div class="overflow-y-auto pr-1 flex-grow custom-scrollbar">
              <ul class="text-xs text-slate-400 space-y-3 list-none leading-relaxed">
                <li 
                  v-for="(bullet, bIndex) in item.responsibilities.split('\n')" 
                  :key="bIndex"
                  v-show="bullet.trim().length > 0"
                  class="flex items-start"
                >
                  <span class="text-sky-500 mr-2.5 mt-1.5 block w-1 h-1 rounded-full shrink-0"></span>
                  <span>{{ bullet }}</span>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>

    </div>

    <div v-else class="text-sm text-slate-500 italic">
      No experience records added to the dashboard yet.
    </div>
  </section>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 3px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(56, 189, 248, 0.15); border-radius: 9999px; }
</style>