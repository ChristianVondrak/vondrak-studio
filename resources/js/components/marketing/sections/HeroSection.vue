<template>
  <section id="hero" class="hero">
    <div class="hero-bg" aria-hidden="true">
      <VantaGlobe />
    </div>
    <BaseContainer>
      <div class="hero-card">
        <h1>
          Transformo tus ideas en <span class="accent">sitios web que convierten</span>
        </h1>
        <p class="sub">
          Landing pages, tiendas online y páginas informativas rápidas y modernas. Diseño responsive,
          buena velocidad y SEO básico para que te encuentren y te contacten.
        </p>
        <div class="cta">
          <BaseButton href="#contact">Quiero mi sitio</BaseButton>
          <BaseButton href="#work" :ghost="true">Ver trabajos</BaseButton>
        </div>
        <ul class="trust">
          <li>🚀 Entrega rápida</li>
          <li>📱 Diseño responsive</li>
          <li>🔎 SEO básico y analítica</li>
        </ul>
      </div>
    </BaseContainer>
  </section>
</template>

<script setup lang="ts">
import VantaGlobe from '@/components/marketing/ui/VantaGlobe.vue'
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import BaseButton from '@/components/marketing/base/BaseButton.vue'
</script>

<style scoped src="./HeroSection.css"></style>
