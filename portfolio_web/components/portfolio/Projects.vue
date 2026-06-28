<script setup>
import { ref, watch, computed } from 'vue'

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

const activeProjectId = ref(null)
const activeImageIndex = ref({})
const descOpen = ref({})

watch(() => props.data, (newData) => {
  if (newData && newData.length > 0 && !activeProjectId.value) {
    activeProjectId.value = newData[0].id
  }
}, { immediate: true })

const getImages = (project) => {
  if (Array.isArray(project.images) && project.images.length > 0) {
    return project.images
  }
  if (project.image_path) {
    return [project.image_path]
  }
  return [null]
}

const getCurrentImageIndex = (projectId) => {
  return activeImageIndex.value[projectId] ?? 0
}

const shiftImage = (projectId, dir, total) => {
  const cur = getCurrentImageIndex(projectId)
  activeImageIndex.value[projectId] = (cur + dir + total) % total
}

const goToImage = (projectId, index) => {
  activeImageIndex.value[projectId] = index
}

const toggleDesc = (projectId) => {
  descOpen.value[projectId] = !descOpen.value[projectId]
}

const isDescOpen = (projectId) => {
  return !!descOpen.value[projectId]
}

const getImageUrl = (path) => {
  if (!path) return ''
  let cleanPath = path

  if (typeof path === 'string' && (path.startsWith('[') || path.startsWith('{'))) {
    try {
      const parsed = JSON.parse(path)
      if (Array.isArray(parsed) && parsed.length > 0) {
        cleanPath = parsed[0]
      } else if (typeof parsed === 'object' && parsed !== null) {
        cleanPath = Object.values(parsed)[0] || ''
      }
    } catch (e) {
      cleanPath = path.replace(/[\[\]"']/g, '')
    }
  } else if (Array.isArray(path)) {
    cleanPath = path[0] || ''
  }

  cleanPath = String(cleanPath).replace(/^\//, '')
  return `http://portfolio-app.test/storage/${cleanPath}`
}

// Touch/swipe support
const touchStartX = ref({})

const onTouchStart = (projectId, e) => {
  touchStartX.value[projectId] = e.touches[0].clientX
}

const onTouchEnd = (projectId, e, total) => {
  const startX = touchStartX.value[projectId]
  if (startX === undefined) return
  const dx = e.changedTouches[0].clientX - startX
  if (Math.abs(dx) > 40) {
    shiftImage(projectId, dx < 0 ? 1 : -1, total)
  }
}
</script>

<template>
  <section id="projects" class="max-w-4xl mx-auto px-6 py-12 relative overflow-hidden">
    <!-- Ambient glow -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-sky-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Section heading -->
    <div class="mb-8 relative">
      <div class="flex items-center gap-3 mb-2">
        <span class="h-[1px] w-8 bg-sky-500/60"></span>
        <h3 class="mono text-xs uppercase tracking-widest text-sky-400 font-bold">05 // Creations</h3>
      </div>
      <h2 class="text-2xl font-bold text-white tracking-tight">
        Featured Projects
      </h2>
    </div>

    <!-- Error state -->
    <div
      v-if="props.error"
      class="p-4 rounded-xl bg-red-950/20 backdrop-blur-md border border-red-900/30 text-red-400 text-sm mb-6 shadow-xl shadow-red-950/10"
    >
      <p class="flex items-center gap-3">
        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
        Failed to sync repository data. Please verify your backend server connection.
      </p>
    </div>

    <!-- Main layout -->
    <div
      v-else-if="props.data.length"
      class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start relative z-10"
    >

      <!-- Left nav -->
      <div class="md:col-span-1">
        <div class="flex flex-col space-y-1 border-l border-slate-800/80 pl-2 relative">
          <div class="absolute left-0 top-0 bottom-0 w-[1px] bg-slate-800/40"></div>

          <button
            v-for="project in props.data"
            :key="'nav-' + project.id"
            @click="activeProjectId = project.id"
            class="text-left py-2 px-2.5 rounded-md text-[11px] font-medium transition-all duration-200 relative group overflow-hidden"
            :class="activeProjectId === project.id
              ? 'text-sky-400 bg-sky-950/20 border border-sky-900/20 font-semibold pl-3.5'
              : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/20 hover:pl-3.5'"
          >
            <span
              class="absolute left-0 top-1/4 bottom-1/4 w-[1.5px] bg-gradient-to-b from-sky-400 to-sky-600 rounded-r transition-all duration-200 transform scale-y-0"
              :class="activeProjectId === project.id ? 'scale-y-100' : 'group-hover:scale-y-50'"
            ></span>
            <span class="relative z-10 block truncate tracking-wide">{{ project.title }}</span>
          </button>
        </div>
      </div>

      <!-- Right: gallery panels -->
      <div class="md:col-span-2 relative min-h-[380px]">
        <div
          v-for="project in props.data"
          :key="project.id"
          class="transition-all duration-300"
          :class="activeProjectId === project.id
            ? 'opacity-100 scale-100 pointer-events-auto h-auto relative'
            : 'opacity-0 scale-[0.99] pointer-events-none h-0 absolute inset-0'"
        >
          <div
            class="relative rounded-2xl overflow-hidden border border-slate-800/40 shadow-2xl shadow-black/40"
            style="aspect-ratio: 16/10;"
            @touchstart="onTouchStart(project.id, $event)"
            @touchend="onTouchEnd(project.id, $event, getImages(project).length)"
          >
            <!-- Image slides -->
            <div class="absolute inset-0">
              <div
                v-for="(imgPath, imgIndex) in getImages(project)"
                :key="imgIndex"
                class="absolute inset-0 transition-opacity duration-400"
                :class="getCurrentImageIndex(project.id) === imgIndex ? 'opacity-100' : 'opacity-0'"
              >
                <img
                  v-if="imgPath"
                  :src="getImageUrl(imgPath)"
                  :alt="project.title + ' screenshot ' + (imgIndex + 1)"
                  class="w-full h-full object-cover"
                />
                <div
                  v-else
                  class="w-full h-full flex flex-col items-center justify-center bg-slate-950 gap-2"
                >
                  <i data-lucide="code-2" class="w-10 h-10 opacity-10 text-slate-500"></i>
                  <span class="text-[10px] font-mono text-slate-600 tracking-wider">
                    NO_PREVIEW · {{ imgIndex + 1 }}/{{ getImages(project).length }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Subtle dark gradient overlay at bottom (always visible) -->
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-slate-950/80 to-transparent pointer-events-none z-10"></div>

            <!-- Left arrow -->
            <button
              v-if="getImages(project).length > 1"
              @click="shiftImage(project.id, -1, getImages(project).length)"
              class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full flex items-center justify-center bg-slate-900/80 border border-sky-900/30 text-sky-400 hover:bg-sky-950/50 hover:border-sky-500/40 transition-all duration-200"
              aria-label="Previous image"
            >
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M9 11L5 7L9 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <!-- Right arrow -->
            <button
              v-if="getImages(project).length > 1"
              @click="shiftImage(project.id, 1, getImages(project).length)"
              class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full flex items-center justify-center bg-slate-900/80 border border-sky-900/30 text-sky-400 hover:bg-sky-950/50 hover:border-sky-500/40 transition-all duration-200"
              aria-label="Next image"
            >
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M5 3L9 7L5 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <!-- Dot indicators -->
            <div
              v-if="getImages(project).length > 1"
              class="absolute bottom-12 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5"
            >
              <button
                v-for="(_, dotIndex) in getImages(project)"
                :key="dotIndex"
                @click="goToImage(project.id, dotIndex)"
                class="rounded-full transition-all duration-200 border-none p-0 cursor-pointer"
                :class="getCurrentImageIndex(project.id) === dotIndex
                  ? 'w-4 h-1.5 bg-sky-400'
                  : 'w-1.5 h-1.5 bg-slate-600 hover:bg-slate-400'"
                :aria-label="'Go to image ' + (dotIndex + 1)"
              ></button>
            </div>

            <!-- Description trigger tab -->
            <div class="absolute bottom-0 inset-x-0 z-30 flex justify-center pb-2.5">
              <button
                @click="toggleDesc(project.id)"
                class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[10px] font-mono tracking-widest uppercase transition-all duration-200 border"
                :class="isDescOpen(project.id)
                  ? 'bg-sky-950/70 border-sky-500/40 text-sky-300'
                  : 'bg-slate-950/80 border-sky-900/30 text-sky-400 hover:bg-sky-950/50 hover:border-sky-500/40'"
              >
                <svg
                  width="10" height="10" viewBox="0 0 10 10" fill="none"
                  class="transition-transform duration-300"
                  :class="isDescOpen(project.id) ? 'rotate-180' : ''"
                >
                  <path d="M2 7L5 4L8 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Description
              </button>
            </div>

            <!-- Slide-up description panel -->
            <div
              class="absolute inset-x-0 bottom-0 z-20 transition-all duration-350 ease-in-out"
              :class="isDescOpen(project.id)
                ? 'translate-y-0 opacity-100'
                : 'translate-y-full opacity-0'"
              style="backdrop-filter: blur(14px); background: rgba(8, 15, 30, 0.92); border-top: 1px solid rgba(56, 189, 248, 0.12); max-height: 70%; overflow-y: auto; padding-bottom: 52px;"
            >
              <div class="p-5">
                <!-- Label -->
                <div class="flex items-center gap-1.5 mb-3">
                  <span class="w-1 h-1 rounded-full bg-sky-400"></span>
                  <span class="text-[10px] font-mono tracking-wider text-slate-500 uppercase">Architecture Details</span>
                </div>

                <!-- Title -->
                <h3 class="text-sm font-bold text-white tracking-tight mb-2">
                  {{ project.title }}
                </h3>

                <!-- Description -->
                <p class="text-slate-400 text-xs leading-relaxed whitespace-pre-line font-normal tracking-wide mb-4">
                  {{ project.description }}
                </p>

                <!-- Link -->
                <div v-if="project.project_url" class="pt-3 border-t border-slate-800/40 flex justify-end">
                  <a
                    :href="project.project_url"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-sky-400 hover:text-sky-300 transition-colors group/link"
                  >
                    Explore Codebase
                    <span class="transform group-hover/link:translate-x-1 transition-transform font-bold">→</span>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

    <!-- Empty state -->
    <div
      v-else
      class="text-xs text-slate-500 italic text-center max-w-sm mx-auto p-6 bg-slate-900/10 border border-slate-800/30 rounded-xl"
    >
      No projects indexed yet. Connect your dashboard to populate data entries.
    </div>
  </section>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(56, 189, 248, 0.15);
  border-radius: 9999px;
}

.duration-350 {
  transition-duration: 350ms;
}

.duration-400 {
  transition-duration: 400ms;
}
</style>