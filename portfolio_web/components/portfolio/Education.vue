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
  <section id="education" class="max-w-4xl mx-auto px-6 py-24 bg-slate-900/20 rounded-2xl border border-slate-800/40 my-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <div>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">02 // Knowledge Base</h3>
        <h2 class="text-2xl font-bold text-white tracking-tight">Education</h2>
      </div>
      
      <div class="md:col-span-2 space-y-10">
        <div 
          v-for="item in props.data" 
          :key="item.id" 
          class="group"
        >
          <div class="flex items-center justify-between mb-1">
            <h4 class="text-lg font-semibold text-white group-hover:text-sky-400 transition-colors duration-200">
              {{ item.degree }}
            </h4>
            <span class="mono text-xs text-slate-500 shrink-0 ml-4">{{ item.duration }}</span>
          </div>
          
          <p class="text-sm text-sky-500/90 font-medium mb-3">
            {{ item.institution }} <span v-if="item.location">— {{ item.location }}</span>
          </p>
          
          <p class="text-xs text-slate-400 leading-relaxed">
            <strong class="text-slate-300 font-medium">Key Modules:</strong> 
            {{ item.key_modules }}
          </p>
        </div>

        <div v-if="!props.data.length" class="text-sm text-slate-500 italic">
          No academic history tracking records saved in the admin panel yet.
        </div>
      </div>
    </div>
  </section>
</template>