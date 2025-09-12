<template>
  <header class="nav" :class="{ 'nav--solid': isSolid }">
    <BaseContainer>
      <a class="brand" href="#hero" data-no-inertia>
        <span class="logo">VS</span>
        <span class="brand-text">Vondrak Studio</span>
      </a>

      <nav class="links" aria-label="Navegación principal">
        <a href="#services" data-no-inertia>Servicios</a>
        <a href="#work" data-no-inertia>Proyectos</a>
  <a href="#contact" class="btn btn--sm" data-no-inertia>Hablemos</a>
      </nav>
    </BaseContainer>
  </header>
</template>

<script setup lang="ts">
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import { useNavbarScroll } from '@/composables/marketing/useNavbarScroll'

const { isSolid } = useNavbarScroll()
</script>

<style scoped src="./Navbar.css"></style>
