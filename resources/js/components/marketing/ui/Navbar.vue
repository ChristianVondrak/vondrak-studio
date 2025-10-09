<template>
  <header class="nav" :class="{ 'nav--solid': isSolid }">
    <BaseContainer>
      <a class="brand" :href="brandHref" v-bind="brandAttrs">
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
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import { useNavbarScroll } from '@/composables/marketing/useNavbarScroll'

const { isSolid } = useNavbarScroll()

const page = usePage()
const isHome = computed(() => page.url === '/' || page.component === 'marketing/Home')
const brandHref = computed(() => (isHome.value ? '#hero' : '/'))
const brandAttrs = computed(() => (isHome.value ? { 'data-no-inertia': true } : {}))
</script>

<style scoped src="./Navbar.css"></style>
