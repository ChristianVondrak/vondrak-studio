<template>
  <div class="how-work-card">
    <div class="how-work-card__media" :style="{ '--hw-step-accent': accent }">
      <span class="how-work-card__index">{{ number }}</span>
    </div>
    <div class="how-work-card__body">
      <div class="how-work-card__text">
        <h3 class="how-work-card__title">{{ title }}</h3>
        <p class="how-work-card__subtitle">{{ subtitle }}</p>
      </div>
      <img class="how-work-card__art" :src="artSrc" alt="" aria-hidden="true" />
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  number: string
  title: string
  subtitle: string
  accent: string
  artSrc: string
}>()
</script>

<style scoped>
.how-work-card {
  position: relative;
  display: grid;
  grid-template-columns: clamp(220px, 26vw, 300px) minmax(0, 1fr);
  width: min(880px, 82vw);
  border-radius: 42px;
  overflow: hidden;
  background: #f5f7fb;
  box-shadow: 0 26px 60px rgba(17, 17, 17, 0.08);
}

.how-work-card__media {
  position: relative;
  background: var(--hw-step-accent);
  display: flex;
  align-items: flex-end;
  justify-content: flex-start;
  padding: clamp(2rem, 4vw, 3rem);
  color: #ffffff;
}

.how-work-card__media::after {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 75% 25%, rgba(255, 255, 255, 0.55), transparent 60%);
  opacity: 0.85;
}

.how-work-card__index {
  position: relative;
  z-index: 1;
  font-size: clamp(4.5rem, 9vw, 8rem);
  font-weight: 800;
  letter-spacing: -0.045em;
}

.how-work-card__body {
  position: relative;
  display: grid;
  align-content: end;
  gap: clamp(1rem, 1.6vw, 2rem);
  padding: clamp(2rem, 3vw, 3.5rem) clamp(2.25rem, 3.5vw, 4rem);
  background: #ffffff;
  min-height: clamp(260px, 32vw, 360px);
}

.how-work-card__text {
  display: grid;
  gap: clamp(0.6rem, 1vw, 1.2rem);
}

.how-work-card__title {
  font-size: clamp(1.2rem, 1.5vw, 2.0rem);
  font-weight: 800;
  letter-spacing: -0.02em;
  text-transform: uppercase;
}

.how-work-card__subtitle {
  font-size: clamp(1rem, calc(0.6vw + 1rem), 1.25rem);
  line-height: 1.2;
  color: rgba(17, 17, 17, 0.64);
}

.how-work-card__art {
  position: absolute;
  top: -29px;
  right: -24px;
  width: 220px;
  height: auto;
  max-width: none;
  object-fit: cover;
  pointer-events: none;
}

@media (max-width: 959px) {
  .how-work-card {
    grid-template-columns: 1fr;
    width: min(92vw, 640px);
  }

  .how-work-card__media {
    min-height: clamp(200px, 55vw, 320px);
  }

  .how-work-card__body {
    align-content: end;
  }

  .how-work-card__art {
    /* móvil/mediano: tamaño más pequeño y sin recorte lateral */
    width: 160px;
    right: 12px;
    top: 12px;
  }
}

@media (max-width: 640px) {
  .how-work-card {
    border-radius: 28px;
  }

  .how-work-card__body {
    padding: clamp(1.75rem, 6vw, 2.5rem);
  }

  .how-work-card__art {
    width: 200px;
    top: 10px;
    right: 10px;
  }
}
</style>
