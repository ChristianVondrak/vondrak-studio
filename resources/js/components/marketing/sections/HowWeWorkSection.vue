<template>
  <section
    ref="wrapper"
    :class="['how-work', { 'how-work--wide': props.wide, 'how-work--reduced': prefersReducedMotion }]"
  >
    <div class="how-work__sticky">
      <div ref="track" class="how-work__track">
        <article class="how-work__step how-work__step--intro">
          <div class="how-work__intro-shell">
            <span class="how-work__eyebrow">Proceso</span>
            <h2 class="how-work__headline">Cómo trabajamos</h2>
            <p class="how-work__intro-copy">
              Equipos locales, procesos claros y entregables iterativos. Desliza para ver cada paso del proceso.
            </p>
          </div>
        </article>
        <article
          v-for="(step, index) in visibleSteps"
          :key="step.title + index"
          class="how-work__step"
        >
          <HowWorkCard
            :number="pad2(index + 1)"
            :title="step.title"
            :subtitle="step.description"
            :accent="palette[index % palette.length]"
            :art-src="abstractArt"
          />
        </article>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import HowWorkCard from './HowWorkCard.vue'
import abstractArt from '@/assets/cards/abstracet1.png'

interface Step {
  title: string
  description: string
}

const INTRO_SCROLL_THRESHOLD = 0.07
const HORIZONTAL_TRAVEL_RATIO = 0.45

const DEFAULT_STEPS: Step[] = [
  {
    title: 'Descubrimiento',
    description: 'Conversamos para entender objetivos, restricciones y prioridades del negocio.'
  },
  {
    title: 'Diseño de solución',
    description: 'Definimos arquitectura, experiencia y roadmap para la primera versión.'
  },
  {
    title: 'Desarrollo iterativo',
    description: 'Construimos en sprints cortos con QA constante y entregables visibles.'
  },
  {
    title: 'Lanzamiento y soporte',
    description: 'Liberamos, monitoreamos resultados y ajustamos con base en métricas reales.'
  }
]

const DEFAULT_PALETTE = [
  'linear-gradient(135deg, #1e1aff, #c04df7)',
  'linear-gradient(135deg, #0ea5e9, #38bdf8)',
  'linear-gradient(135deg, #f97316, #fb7185)',
  'linear-gradient(135deg, #22c55e, #3b82f6)'
]

const props = defineProps<{
  steps?: Step[]
  wide?: boolean
}>()

const wrapper = ref<HTMLElement | null>(null)
const track = ref<HTMLElement | null>(null)
let rafId: number | null = null

const prefersReducedMotion =
  typeof window !== 'undefined' &&
  typeof window.matchMedia === 'function' &&
  window.matchMedia('(prefers-reduced-motion: reduce)').matches

const steps = computed<Step[]>(() => (props.steps?.length ? props.steps : DEFAULT_STEPS))
const visibleSteps = computed(() => steps.value)

const palette = DEFAULT_PALETTE

const pad2 = (value: number) => String(value).padStart(2, '0')

const clamp = (value: number, min: number, max: number) => Math.min(Math.max(value, min), max)

function recalcLayout() {
  if (!wrapper.value || !track.value) return

  const panels = visibleSteps.value.length + 1 // intro panel + steps
  const vw = window.innerWidth
  const vh = window.innerHeight

  const travel = prefersReducedMotion ? vh : vw * HORIZONTAL_TRAVEL_RATIO

  wrapper.value.style.height = prefersReducedMotion
    ? `${panels * vh}px`
    : `${vh + Math.max(0, panels - 1) * travel}px`

  track.value.style.width = `${panels * vw}px`

  if (prefersReducedMotion) {
    track.value.style.transform = 'none'
    return
  }

  applyTransform(getProgress())
}

function applyTransform(progressValue: number) {
  if (!track.value) return

  const maxTranslate = track.value.scrollWidth - window.innerWidth
  const introAdjustedProgress = clamp(
    (progressValue - INTRO_SCROLL_THRESHOLD) / (1 - INTRO_SCROLL_THRESHOLD),
    0,
    1
  )
  const x = -introAdjustedProgress * maxTranslate
  track.value.style.transform = `translate3d(${x}px, 0, 0)`
}

function getProgress() {
  if (!wrapper.value) return 0

  const rect = wrapper.value.getBoundingClientRect()
  const distanceInto = -rect.top
  const maxScroll = rect.height - window.innerHeight
  return maxScroll > 0 ? clamp(distanceInto / maxScroll, 0, 1) : 0
}

function handleScroll() {
  if (rafId !== null) return

  rafId = requestAnimationFrame(() => {
    rafId = null

    if (!track.value) return

    if (prefersReducedMotion) {
      track.value.style.transform = 'none'
      return
    }

    applyTransform(getProgress())
  })
}

function handleResize() {
  recalcLayout()
  handleScroll()
}

onMounted(async () => {
  await nextTick()
  recalcLayout()
  handleScroll()

  window.addEventListener('resize', handleResize, { passive: true })
  window.addEventListener('orientationchange', handleResize)
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
  window.removeEventListener('orientationchange', handleResize)
  window.removeEventListener('scroll', handleScroll)

  if (rafId !== null) {
    cancelAnimationFrame(rafId)
    rafId = null
  }
})

watch(visibleSteps, async () => {
  await nextTick()
  recalcLayout()
  handleScroll()
})
</script>

<style scoped>
.how-work {
  --hw-bg: #ffffff;
  --hw-text-primary: #111111;
  --hw-text-muted: rgba(17, 17, 17, 0.64);
  --hw-card-bg: #ffffff;
  --hw-card-border: rgba(17, 17, 17, 0.08);
  --hw-top-gap: clamp(6rem, 18vh, 10rem);
  --hw-bottom-gap: var(--hw-top-gap);
  background: var(--hw-bg);
  color: var(--hw-text-primary);
}

.how-work__sticky {
  position: sticky;
  top: 0;
  height: 100vh;
  background: var(--hw-bg);
  overflow: hidden;
}

.how-work__eyebrow {
  font-size: 0.85rem;
  letter-spacing: 0.42em;
  text-transform: uppercase;
  color: rgba(17, 17, 17, 0.55);
}

.how-work__track {
  position: relative;
  display: flex;
  align-items: stretch;
  height: 100%;
  padding: var(--hw-top-gap) clamp(5vw, 7vw, 9vw) var(--hw-bottom-gap);
  box-sizing: border-box;
  will-change: transform;
  opacity: 1;
  transition: opacity 0.6s ease, transform 0.08s linear;
}

/* .how-work--wide .how-work__track {
  padding-inline: clamp(5vw, 8vw, 11vw);
} */

.how-work--reduced .how-work__track {
  display: grid;
  grid-auto-flow: row;
  grid-auto-rows: auto;
  padding: clamp(6rem, 18vh, 9rem) clamp(1.75rem, 6vw, 3rem);
  transform: none !important;
  width: 100% !important;
}

.how-work__step {
  width: calc(100vw - clamp(4rem, 10vw, 9rem));
  min-height: calc(100vh - var(--hw-top-gap) - var(--hw-bottom-gap));
  display: flex;
  align-items: center;
  justify-content: center;
}

.how-work--reduced .how-work__step {
  width: 100%;
  min-height: auto;
  padding-block: clamp(2rem, 6vw, 3rem);
}

.how-work__step--intro {
  justify-content: center;
}

.how-work--reduced .how-work__step--intro {
  padding-block: clamp(2rem, 6vw, 3.5rem);
}

.how-work__intro-shell {
  display: grid;
  gap: clamp(0.75rem, 1.5vw, 1.6rem);
  width: min(720px, 80vw);
  text-align: center;
  margin-inline: auto;
}

.how-work__headline {
  font-size: clamp(3rem, 8vw, 5.5rem);
  font-weight: 800;
  letter-spacing: 0;
  text-transform: uppercase;
}

.how-work__intro-copy {
  font-size: clamp(1.05rem, 0.8vw + 1rem, 1.35rem);
  line-height: 1.7;
  color: var(--hw-text-muted);
}

@media (max-width: 959px) {
  .how-work__track {
    padding-inline: clamp(2rem, 10vw, 4rem);
  }

  .how-work__intro-shell {
    width: min(620px, 90vw);
  }
}

@media (max-width: 640px) {
  .how-work {
    --hw-top-gap: clamp(5rem, 28vh, 7.5rem);
    --hw-bottom-gap: var(--hw-top-gap);
  }

  .how-work__track {
    padding-inline: clamp(1.25rem, 5vw, 2rem);
  }

  .how-work__intro-shell {
    width: 100%;
    padding-block: clamp(1.75rem, 8vw, 3rem);
  }
}

@media (prefers-reduced-motion: reduce) {
  .how-work__track,
  .how-work__step {
    transition: none !important;
  }
}
</style>
