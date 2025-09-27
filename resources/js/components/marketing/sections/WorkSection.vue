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
          <span>Panel RR. HH.</span>
        </a>
        <a class="work" href="#contact" role="listitem" aria-label="Módulo de Reportes" v-reveal:up.d200>
          <span>Módulo de Reportes</span>
        </a>
        <a class="work" href="#contact" role="listitem" aria-label="Alertas y Notificaciones" v-reveal:up.d260>
          <span>Alertas y Notificaciones</span>
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
</script>

<style scoped src="./WorkSection.css"></style>
