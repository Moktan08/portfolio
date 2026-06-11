<script setup>
// Accept the dynamic profile data from the index.vue parent wrapper
const props = defineProps({
  data: {
    type: Object,
    default: () => ({
      title: "Software Engineer",
      tagline: "Passionate about continuous learning and applying technical expertise to build scalable, data-driven real-world architectures."
    })
  }
})
</script>

<template>
  <section id="hero" class="max-w-4xl mx-auto px-6 pt-28 pb-32 text-center flex flex-col items-center justify-center min-h-[75vh]">
    <p class="mono text-xs uppercase tracking-[0.25em] text-sky-500 font-semibold mb-4">
      HI, MY NAME IS
    </p>
    <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-white mb-4">
      Romi Lama
    </h1>
    
    <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-slate-400 mb-8">
      {{ props.data?.title || 'Software Engineer' }}
    </h2>
    
    <p class="text-base md:text-lg text-slate-400 max-w-2xl mb-12 leading-relaxed">
      {{ props.data?.tagline || 'Passionate about continuous learning and applying technical expertise to build scalable, data-driven real-world architectures.' }}
    </p>
    
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full sm:w-auto">
      <a href="#experience" class="w-full sm:w-auto inline-flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm px-8 py-3.5 rounded-lg transition-all shadow-lg shadow-sky-500/20 tracking-wide">
        My Experiences
      </a>
      <a href="#contact" class="w-full sm:w-auto inline-flex items-center justify-center bg-transparent hover:bg-slate-800/40 text-slate-300 hover:text-white border border-slate-700 font-semibold text-sm px-8 py-3.5 rounded-lg transition-all tracking-wide">
        Get In Touch
      </a>
    </div>
  </section>
</template>