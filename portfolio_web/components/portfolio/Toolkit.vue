<script setup>
// Define properties to accept the incoming live database skills from parent index.vue page
const props = defineProps({
  data: {
    type: Array,
    default: () => []
  }
})
</script>

<template>
  <section id="toolkit" class="max-w-4xl mx-auto px-6 py-24 border-t border-slate-900">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <div>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">04 // Capabilities</h3>
        <h2 class="text-2xl font-bold text-white tracking-tight">Technical Matrix</h2>
      </div>
      
      <div v-if="props.data && props.data.length" class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mono text-slate-300">
        <div 
          v-for="skill in props.data" 
          :key="skill.id" 
          class="flex items-center space-x-2 group"
        >
          <Icon name="lucide:check-circle-2" class="w-4 h-4 text-sky-500 group-hover:text-emerald-400 transition-colors duration-200" /> 
          <span class="group-hover:text-white transition-colors duration-200">{{ skill.name }}</span>
        </div>
      </div>

      <div v-else class="md:col-span-2 text-sm text-slate-500 italic flex items-center">
        No skills added to the admin tracking matrix yet.
      </div>
    </div>
  </section>
</template>