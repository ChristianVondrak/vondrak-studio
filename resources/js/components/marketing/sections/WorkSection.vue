<template>
  <section id="work" class="section work-section">
    <BaseContainer>
      <h2 class="section-title" v-reveal:up>Proyectos destacados</h2>

      <div class="grid" role="list" v-reveal:up.d80>
        <a
          class="work work--panel-rrhh"
          href="/projects/panel-rrhh"
          role="listitem"
          aria-label="Panel RR. HH."
          v-reveal:up.d140
          :style="{ '--bg-image': 'url(/images/projects/orion/dashboard.jpg)' }"
        >
          <span>Gestión de proyectos</span>
        </a>
        <a
          class="work work--avantiway"
          href="/projects/avantiway-maps"
          role="listitem"
          aria-label="Búsqueda MLS Avantiway"
          v-reveal:up.d200
          :style="{ '--bg-image': `url(${avantiMapCover})` }"
        >
          <span>Buscador MLS Avantiway</span>
        </a>
        <a
          class="work work--vondrak"
          href="/projects/vondrak-studio"
          role="listitem"
          aria-label="Sitio Vondrak Studio"
          v-reveal:up.d260
          :style="{ '--bg-image': `url(${vondrakCover})` }"
        >
          <span>Vondrak Studio</span>
        </a>
      </div>

      <p class="muted" v-reveal:up.d340>
        ¿Quieres una demo en vivo? <a href="#contact">Escríbeme</a>.
      </p>
    </BaseContainer>
  </section>
</template>

<script setup lang="ts">
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import avantiMapCover from '@/assets/projects/avanti_app/mapa.png'

const makeVondrakCover = () => {
  const svg = `<?xml version="1.0" encoding="UTF-8"?>
  <svg xmlns='http://www.w3.org/2000/svg' width='1200' height='800'>
    <defs>
      <linearGradient id='bg' x1='0' y1='0' x2='1' y2='1'>
        <stop offset='0%' stop-color='#22d3ee'/>
        <stop offset='100%' stop-color='#a855f7'/>
      </linearGradient>
    </defs>
    <rect width='100%' height='100%' fill='#050b1a'/>
    <rect x='40' y='40' width='1120' height='720' rx='28' fill='url(#bg)' opacity='0.22'/>
    <text x='50%' y='45%' text-anchor='middle' fill='#e9ecff' font-family='"Poppins", "Inter", sans-serif' font-size='72' font-weight='700'>Vondrak Studio</text>
    <text x='50%' y='58%' text-anchor='middle' fill='#cdd5ff' font-family='"Inter", sans-serif' font-size='28'>Software Factory Website</text>
  </svg>`
  return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`
}

const vondrakCover = makeVondrakCover()
</script>

<style scoped src="./WorkSection.css"></style>
