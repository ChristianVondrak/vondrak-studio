<template>
  <div class="plan" :class="{ 'plan--highlight': highlight }">
    <div v-if="highlight && badge" class="badge">{{ badge }}</div>

    <div class="plan__head">
      <h3 class="plan__title">
        <span v-if="titleEmphasis">
          {{ titleBefore }}<span class="accent">{{ titleEmphasis }}</span>{{ titleAfter }}
        </span>
        <span v-else>{{ title }}</span>
      </h3>

      <p v-if="subtitle" class="plan__subtitle">{{ subtitle }}</p>
      <!-- Mantengo v-html para paridad 1:1 con tu versión -->
      <p class="plan__price" v-if="price" v-html="price"></p>
    </div>

    <ul class="plan__features" v-if="features?.length">
      <li v-for="(feature, i) in features" :key="i">{{ feature }}</li>
    </ul>

    <a :href="ctaHref" class="btn plan__cta">{{ ctaText }}</a>
    <p v-if="note" class="plan__note">{{ note }}</p>
  </div>
</template>

<style scoped src="./PricingCard.css"></style>

<script setup lang="ts">
import { withDefaults, defineProps } from 'vue'

type Props = {
  title?: string
  titleBefore?: string
  titleEmphasis?: string
  titleAfter?: string
  subtitle?: string
  price?: string // ej. "<strong>$399</strong> USD"
  features?: string[]
  ctaText?: string
  ctaHref?: string
  note?: string
  highlight?: boolean
  badge?: string
}

withDefaults(defineProps<Props>(), {
  title: '',
  titleBefore: '',
  titleEmphasis: '',
  titleAfter: '',
  subtitle: '',
  price: '',
  features: () => [],
  ctaText: 'Contratar ahora',
  ctaHref: '#contact',
  note: '',
  highlight: false,
  badge: ''
})
</script>

