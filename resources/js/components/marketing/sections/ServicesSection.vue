<template>
  <section id="services" class="section section--pricing">
    <BaseContainer>
      <h2 class="section-title title-center">Planes y precios</h2>

      <div class="pricing">
        <PricingCard
          :title-before="'Página '"
          title-emphasis="Informativa"
          subtitle="Sobre tu negocio o servicio"
          price="<strong>$399</strong> USD"
          :features="[
            'Diseño tradicional y estático',
            'Diseño responsive',
            'Optimización de carga',
            'Integración con redes sociales',
            'Formulario de contacto',
            'Hosting y dominio',
            '30 días de garantía y mantención'
          ]"
          cta-text="Contratar ahora"
          cta-href="#contact"
          note="El precio incluye el primer año de hosting y dominio"
        />

        <PricingCard
          :highlight="true"
          badge="Más contratado"
          title="Landing Page"
          subtitle="Web similar a esta"
          price="<strong>$799</strong> USD"
          :features="[
            'Diseño único',
            'Animaciones',
            'Diseño responsive',
            'Hasta 4 secciones adicionales',
            'Optimización de carga',
            'Integración con redes sociales',
            'Formulario de contacto',
            'Hosting y dominio',
            '60 días de garantía y mantención'
          ]"
          cta-text="Contratar ahora"
          cta-href="#contact"
          note="El precio incluye el primer año de hosting y dominio"
        />

        <PricingCard
          title="Tienda Online"
          subtitle="También llamado e-commerce"
          price="<strong>$1.299</strong> USD"
          :features="[
            'Diseño personalizado',
            'Diseño responsive',
            'Ingreso de 50 productos',
            'Optimización de SEO para producto',
            'Optimización de carga',
            'Integración con redes sociales',
            'Formulario de contacto',
            'Hosting y dominio',
            '90 días de garantía y mantención'
          ]"
          cta-text="Contratar ahora"
          cta-href="#contact"
          note="El precio incluye el primer año de hosting y dominio"
        />
      </div>
    </BaseContainer>
  </section>
</template>

<script setup lang="ts">
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import PricingCard from '@/components/marketing/ui/PricingCard.vue'
</script>

<style scoped src="./ServicesSection.css"></style>
