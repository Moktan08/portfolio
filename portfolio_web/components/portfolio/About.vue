<script setup>
// Accept the dynamic profile data from pages/index.vue
// Since it's usually a single profile record, we default it to an object
const props = defineProps({
  data: {
    type: Object,
    default: () => ({
      bio: "I am a highly motivated and adaptable individual with a keen interest in technology and problem solving."
    })
  }
})
</script>

<template>
  <section id="about" class="max-w-4xl mx-auto px-6 py-24">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <div>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-500 font-bold mb-2">01 // Profile</h3>
        <h2 class="text-2xl font-bold text-white tracking-tight">About Me</h2>
      </div>
      
      <div class="md:col-span-2 space-y-6 text-slate-400 leading-relaxed text-base">
        <p 
          v-for="(paragraph, index) in props.data?.bio?.split('\n')" 
          :key="index"
          v-show="paragraph.trim().length > 0"
        >
          {{ paragraph }}
        </p>

        <p v-if="!props.data?.bio" class="text-sm text-slate-500 italic">
          No profile biography saved in the admin panel yet.
        </p>
      </div>
    </div>
  </section>
</template>