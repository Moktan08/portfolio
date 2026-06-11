<script setup>
// Catch the live database records passed down from pages/index.vue
const props = defineProps({
  data: {
    type: Array,
    default: () => []
  }
})
</script>

<template>
  <section id="experience" class="max-w-4xl mx-auto px-6 py-24">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <div>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">03 // Track Record</h3>
        <h2 class="text-2xl font-bold text-white tracking-tight">Experience</h2>
      </div>
      
      <div class="md:col-span-2 space-y-12">
        <div 
          v-for="(item, index) in props.data" 
          :key="item.id" 
          class="relative pl-6 border-l border-slate-800 group"
        >
          <div 
            class="absolute -left-[4.5px] top-1.5 w-2 h-2 rounded-full transition-all duration-300 group-hover:scale-125"
            :class="index === 0 ? 'bg-sky-500 shadow-sm shadow-sky-500' : 'bg-slate-700'"
          ></div>
          
          <div class="flex items-center justify-between mb-1">
            <h4 class="text-lg font-semibold text-white group-hover:text-sky-400 transition-colors duration-200">
              {{ item.position }}
            </h4>
            <span class="mono text-xs text-slate-500 shrink-0 ml-4">{{ item.duration }}</span>
          </div>
          
          <p class="text-sm text-sky-500/90 font-medium mb-4">
            {{ item.company }} <span v-if="item.location">— {{ item.location }}</span>
          </p>
          
          <ul class="text-sm text-slate-400 space-y-3 list-none">
            <li 
              v-for="(bullet, bIndex) in item.responsibilities.split('\n')" 
              :key="bIndex"
              v-show="bullet.trim().length > 0"
              class="flex items-start"
            >
              <span class="text-sky-500 mr-2.5 mt-2 block w-1 h-1 rounded-full shrink-0"></span>
              <span>{{ bullet }}</span>
            </li>
          </ul>
        </div>

        <div v-if="!props.data.length" class="text-sm text-slate-500 italic">
          No experience records added to the dashboard yet.
        </div>
      </div>
    </div>
  </section>
</template>