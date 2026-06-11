<script setup>
import { onMounted } from 'vue'
// Explicit import overrides any Nuxt auto-discovery pathing issues
import PortfolioProjects from '~/components/portfolio/Projects.vue'

// Fetch all decoupled data arrays from the Laravel API engine
const { data: heroData } = await useFetch('http://portfolio-app.test/api/hero')
const { data: projects, error: projectsError } = await useFetch('http://portfolio-app.test/api/projects')
const { data: experiences } = await useFetch('http://portfolio-app.test/api/experiences')
const { data: educationList } = await useFetch('http://portfolio-app.test/api/education')
const { data: skills } = await useFetch('http://portfolio-app.test/api/skills')
const { data: profileData } = await useFetch('http://portfolio-app.test/api/profile')

// Refresh Lucide icons if you're loading them via CDN
onMounted(() => {
  if (window.lucide) {
    window.lucide.createIcons()
  }
})
</script>

<template>
  <div>
    <PortfolioHero :data="heroData || {}" />

    <div class="max-w-5xl mx-auto px-6">
      <div class="h-[1px] bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>
    </div>

    <PortfolioAbout :data="profileData || {}" />

    <PortfolioEducation :data="educationList || []" />
    <PortfolioExperience :data="experiences || []" />
    
    <PortfolioToolkit :data="skills || []" />

    <PortfolioProjects :data="projects || []" :error="projectsError" />

    <div class="max-w-5xl mx-auto px-6">
      <div class="h-[1px] bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>
    </div>

    <PortfolioContact />
  </div>
</template>