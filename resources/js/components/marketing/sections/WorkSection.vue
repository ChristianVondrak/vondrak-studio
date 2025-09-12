<template>
  <section id="work" class="section work-section">
    <BaseContainer>
      <h2 class="section-title">Proyectos destacados</h2>

      <div class="grid" role="list">
        <a class="work" href="#contact" role="listitem" aria-label="Panel RR. HH.">
          <span>Panel RR. HH.</span>
        </a>
        <a class="work" href="#contact" role="listitem" aria-label="Módulo de Reportes">
          <span>Módulo de Reportes</span>
        </a>
        <a class="work" href="#contact" role="listitem" aria-label="Alertas y Notificaciones">
          <span>Alertas y Notificaciones</span>
        </a>
      </div>

      <p class="muted">
        ¿Quieres una demo en vivo? <a href="#contact">Escríbeme</a>.
      </p>
    </BaseContainer>
  </section>
</template>

<script setup lang="ts">
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
</script>

<style scoped src="./WorkSection.css"></style>
