<script setup>
const props = defineProps({
  data: {
    type: Array,
    default: () => []
  },
  error: {
    type: [Object, Boolean],
    default: false
  }
})

// Clean up image path formatting dynamically
const getImageUrl = (path) => {
  if (!path) return ''
  // Strip out any accidental leading slashes to avoid 'storage//path' errors
  const cleanPath = path.replace(/^\//, '')
  return `http://portfolio-app.test/storage/${cleanPath}`
}
</script>

<template>
  <section id="projects" class="max-w-4xl mx-auto px-6 py-24">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      
      <div>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">05 // Creations</h3>
        <h2 class="text-2xl font-bold text-white tracking-tight">Projects</h2>
      </div>

      <div class="md:col-span-2 space-y-12">
        
        <div v-if="props.error" class="p-4 rounded-lg bg-red-950/40 border border-red-900/50 text-red-400 text-sm">
          <p class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            Failed to load projects. Please verify that your Laravel development server is running.
          </p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div 
            v-for="project in props.data" 
            :key="project.id" 
            class="group bg-slate-900/30 border border-slate-800/40 rounded-xl p-5 hover:border-slate-700/60 hover:bg-slate-900/50 transition-all duration-300 flex flex-col justify-between"
          >
            <div>
              <div v-if="project.image_path" class="mb-4 overflow-hidden rounded-lg aspect-video bg-slate-950 border border-slate-800/30">
                <img 
                  :src="getImageUrl(project.image_path)" 
                  :alt="project.title"
                  class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300"
                />
              </div>
              
              <div v-else class="mb-4 rounded-lg aspect-video bg-slate-950 border border-slate-800/30 flex items-center justify-center text-slate-700">
                <i data-lucide="code-2" class="w-8 h-8 opacity-40"></i>
              </div>

              <h3 class="text-lg font-semibold text-white group-hover:text-sky-400 transition-colors duration-200">
                {{ project.title }}
              </h3>
              <p class="text-slate-400 text-xs mt-2 line-clamp-3 leading-relaxed">
                {{ project.description }}
              </p>
            </div>

            <div v-if="project.project_url" class="mt-6 pt-4 border-t border-slate-800/40">
              <a 
                :href="project.project_url" 
                target="_blank" 
                class="inline-flex items-center gap-2 text-xs font-medium text-sky-500 hover:text-sky-400 transition-colors duration-200 group/link"
              >
                View Repository / Demo
                <span class="transform group-hover/link:translate-x-1 transition-transform duration-200">→</span>
              </a>
            </div>
          </div>
        </div>

        <div v-if="!props.error && !props.data.length" class="text-sm text-slate-500 italic">
          No project records added to the dashboard yet.
        </div>
      </div>

    </div>
  </section>
</template>