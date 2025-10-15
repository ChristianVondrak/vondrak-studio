<template>
  <section
    ref="wrapper"
    :class="[
      'how-work',
      { 'how-work--wide': props.wide, 'how-work--reduced': prefersReducedMotion, 'how-work--intro': introActive }
    ]"
  >
    <div class="how-work__sticky">
      <header class="how-work__heading">
        <span class="how-work__ticker" aria-hidden="true">Toronto · {{ time }} · Local · {{ localTime }}</span>
        <span class="how-work__eyebrow">Proceso</span>
        <h2 class="how-work__headline">Cómo trabajamos</h2>
      </header>

      <div ref="track" class="how-work__track">
        <article
          v-for="(step, index) in visibleSteps"
          :key="index"
          class="how-work__step"
        >
          <div
            class="how-work__step-shell"
            :style="{ '--hw-step-accent': palette[index % palette.length] }"
          >
            <div class="how-work__step-number">
              <div class="how-work__number-inner">
                <span class="how-work__number-caption">Paso</span>
                <span class="how-work__number-index">{{ pad2(index + 1) }}</span>
              </div>
            </div>

            <div class="how-work__step-card">
              <div class="how-work__meta">
                <span class="how-work__badge">Proceso</span>
                <span class="how-work__progress">{{ pad2(index + 1) }} / {{ pad2(visibleSteps.length) }}</span>
              </div>

              <h3 class="how-work__step-title">{{ step.title }}</h3>
              <p class="how-work__step-description">{{ step.description }}</p>

              <div v-if="step.points?.length" class="how-work__step-points">
                <div v-for="(point, pointIndex) in step.points" :key="pointIndex" class="how-work__point">
                  <span class="how-work__bullet" aria-hidden="true"></span>
                  <span class="how-work__point-text">{{ point }}</span>
                </div>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'

interface Step {
  title: string
  description: string
  points?: string[]
}

const props = defineProps<{
  steps?: Step[]
  wide?: boolean
}>()

const defaultSteps: Step[] = [
  {
    title: 'Descubrimiento',
    description:
      'Entendemos el contexto del negocio, objetivos y restricciones. Definimos alcance y KPIs iniciales.',
    points: ['Kickoff y entrevistas', 'Análisis de riesgos', 'Roadmap de alto nivel']
  },
  {
    title: 'Diseño de solución',
    description:
      'Traducimos objetivos en arquitectura, UX de alto nivel y plan de releases. Priorizamos valor y viabilidad.',
    points: ['Arquitectura del sistema', 'User flows y wireframes', 'Definición de sprints']
  },
  {
    title: 'Desarrollo iterativo',
    description:
      'Implementación en sprints cortos con QA continuo y demos. Feedback temprano para minimizar retrabajo.',
    points: ['CI/CD y code reviews', 'Feature flags', 'Pruebas unitarias y funcionales']
  },
  {
    title: 'Lanzamiento y soporte',
    description:
      'Release controlado, monitoreo y observabilidad. Medimos impacto y ajustamos el roadmap.',
    points: ['Monitoreo y alertas', 'Métricas de uso', 'Mejora continua']
  }
]

const palette = [
  'linear-gradient(135deg, #1e1aff, #c04df7)',
  'linear-gradient(135deg, #0ea5e9, #38bdf8)',
  'linear-gradient(135deg, #f97316, #fb7185)',
  'linear-gradient(135deg, #22c55e, #3b82f6)'
]

const steps = computed(() => (props.steps?.length ? props.steps : defaultSteps))

const prefersReducedMotion =
  typeof window !== 'undefined' &&
  window.matchMedia &&
  window.matchMedia('(prefers-reduced-motion: reduce)').matches

const visibleSteps = computed(() => steps.value)

const wrapper = ref<HTMLElement | null>(null)
const track = ref<HTMLElement | null>(null)
const time = ref('11:34')
const localTime = ref('11:34')
const progress = ref(prefersReducedMotion ? 1 : 0)
const introActive = computed(() => !prefersReducedMotion && progress.value < 0.2)
let rafId: number | null = null
let timer: number | null = null

function syncLayout() {
  if (!wrapper.value || !track.value) return

  const panels = visibleSteps.value.length
  const vw = window.innerWidth
  const vh = window.innerHeight

  const horizontalTravelFactor = prefersReducedMotion ? vh : vw * 0.65

  wrapper.value.style.height = prefersReducedMotion
    ? `${panels * vh}px`
    : `${vh + Math.max(0, panels - 1) * horizontalTravelFactor}px`

  track.value.style.width = `${panels * vw}px`

  if (prefersReducedMotion) {
    track.value.style.transform = 'none'
    progress.value = 1
  }
}

function clamp(value: number, min: number, max: number) {
  return Math.min(Math.max(value, min), max)
}

function onScroll() {
  if (!wrapper.value || !track.value) return
  if (rafId !== null) return

  rafId = requestAnimationFrame(() => {
    rafId = null
    if (!wrapper.value || !track.value) return

    const rect = wrapper.value.getBoundingClientRect()
    const distanceInto = -rect.top
    const maxScroll = rect.height - window.innerHeight
    const sectionProgress = maxScroll > 0 ? clamp(distanceInto / maxScroll, 0, 1) : 0

    progress.value = sectionProgress

    if (prefersReducedMotion) {
      track.value.style.transform = 'none'
      return
    }

    const maxTranslate = track.value.scrollWidth - window.innerWidth
    const x = -sectionProgress * maxTranslate
    track.value.style.transform = `translate3d(${x}px, 0, 0)`
  })
}

function onResize() {
  syncLayout()
  onScroll()
}

function pad2(value: number) {
  return String(value).padStart(2, '0')
}

function updateTime() {
  if (typeof window === 'undefined') return
  const now = new Date()
  const toronto = now.toLocaleTimeString('es-ES', {
    timeZone: 'America/Toronto',
    hour: '2-digit',
    minute: '2-digit'
  })
  const local = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
  time.value = toronto
  localTime.value = local
}

const handleVisibility = () => {
  if (typeof document !== 'undefined' && document.visibilityState === 'visible') {
    updateTime()
  }
}

onMounted(async () => {
  await nextTick()
  syncLayout()
  updateTime()
  window.addEventListener('resize', onResize, { passive: true })
  window.addEventListener('orientationchange', onResize)
  window.addEventListener('scroll', onScroll, { passive: true })
  window.addEventListener('visibilitychange', handleVisibility)
  onScroll()

  timer = window.setInterval(updateTime, 60000)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', onResize)
  window.removeEventListener('orientationchange', onResize)
  window.removeEventListener('scroll', onScroll)
  window.removeEventListener('visibilitychange', handleVisibility)
  if (timer !== null) {
    window.clearInterval(timer)
    timer = null
  }
  if (rafId !== null) {
    cancelAnimationFrame(rafId)
    rafId = null
  }
})

watch(visibleSteps, async () => {
  await nextTick()
  syncLayout()
  onScroll()
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

.how-work__heading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: grid;
  justify-items: center;
  gap: clamp(0.75rem, 1.5vw, 1.5rem);
  width: min(680px, 90vw);
  text-align: center;
  z-index: 3;
  pointer-events: none;
  opacity: 0;
  transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.6s ease;
}

.how-work--intro .how-work__heading {
  opacity: 1;
  transform: translate(-50%, -50%);
}

.how-work:not(.how-work--intro) .how-work__heading {
  opacity: 0;
  transform: translate(-50%, -140%);
}

.how-work--reduced .how-work__heading {
  position: relative;
  top: auto;
  left: auto;
  transform: none;
  width: min(720px, 100%);
  margin: 0 auto;
  padding: clamp(2rem, 6vw, 3.5rem) 0;
  opacity: 1;
  pointer-events: auto;
}

.how-work__ticker {
  font-size: 0.75rem;
  letter-spacing: 0.32em;
  text-transform: uppercase;
  color: rgba(17, 17, 17, 0.45);
}

.how-work__eyebrow {
  font-size: 0.85rem;
  letter-spacing: 0.42em;
  text-transform: uppercase;
  color: rgba(17, 17, 17, 0.55);
}

.how-work__headline {
  font-size: clamp(3.2rem, 9vw, 7rem);
  font-weight: 800;
  letter-spacing: 0.02em;
  text-transform: uppercase;
}

.how-work__track {
  position: relative;
  display: flex;
  align-items: stretch;
  height: 100%;
  padding: var(--hw-top-gap) clamp(10vw, 14vw, 18vw) var(--hw-bottom-gap);
  box-sizing: border-box;
  will-change: transform;
  opacity: 1;
  transition: opacity 0.6s ease, transform 0.08s linear;
}

.how-work--intro .how-work__track {
  opacity: 0;
  pointer-events: none;
}

.how-work--wide .how-work__track {
  padding-inline: clamp(8vw, 12vw, 16vw);
}

.how-work--reduced .how-work__track {
  display: grid;
  grid-auto-flow: row;
  grid-auto-rows: auto;
  padding: clamp(6rem, 18vh, 9rem) clamp(1.75rem, 6vw, 3rem);
  transform: none !important;
  width: 100% !important;
}

.how-work__step {
  width: 100vw;
  min-height: calc(100vh - var(--hw-top-gap) - var(--hw-bottom-gap));
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 1;
  transform: translateY(0);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.how-work--intro .how-work__step {
  opacity: 0;
  transform: translateY(64px);
}

.how-work--reduced .how-work__step {
  width: 100%;
  min-height: auto;
  padding-block: clamp(2rem, 6vw, 3rem);
  opacity: 1;
  transform: none;
}

.how-work__step-shell {
  display: grid;
  align-items: center;
  gap: clamp(2rem, 5vw, 4rem);
  width: min(1040px, 90vw);
}

.how-work--wide .how-work__step-shell {
  width: min(1180px, 92vw);
}

@media (min-width: 960px) {
  .how-work__step-shell {
    grid-template-columns: clamp(260px, 30vw, 380px) minmax(320px, 1fr);
  }
}

.how-work__step-number {
  position: relative;
  border-radius: 32px;
  background: var(--hw-step-accent);
  overflow: hidden;
  min-height: clamp(240px, 38vw, 420px);
  display: flex;
  align-items: flex-end;
  box-shadow: 0 35px 60px rgba(17, 17, 17, 0.15);
  padding: clamp(1.75rem, 4vw, 3.2rem);
}

.how-work__step-number::after {
  content: '';
  position: absolute;
  inset: 12%;
  background: radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.55), transparent 65%);
  opacity: 0.9;
}

.how-work__number-inner {
  position: relative;
  z-index: 1;
  display: grid;
  gap: clamp(1rem, 3vw, 1.75rem);
}

.how-work__number-caption {
  font-size: 0.85rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.8);
}

.how-work__number-index {
  font-size: clamp(4.5rem, 9vw, 8rem);
  font-weight: 800;
  letter-spacing: -0.045em;
  color: #ffffff;
}

.how-work__step-card {
  position: relative;
  border-radius: 36px;
  background: var(--hw-card-bg);
  border: 1px solid var(--hw-card-border);
  box-shadow: 0 28px 60px rgba(17, 17, 17, 0.08);
  padding: clamp(2rem, 3.5vw, 4rem);
  display: grid;
  gap: clamp(1.4rem, 2vw, 2.5rem);
}

.how-work__meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.35em;
  color: rgba(17, 17, 17, 0.45);
}

.how-work__badge {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
}

.how-work__badge::before {
  content: '';
  width: 0.75rem;
  height: 0.75rem;
  border-radius: 50%;
  background: linear-gradient(135deg, #111111, #3b3b3b);
}

.how-work__step-title {
  font-size: clamp(2rem, 2.4vw, 3.2rem);
  font-weight: 800;
  letter-spacing: -0.02em;
  text-transform: uppercase;
}

.how-work__step-description {
  font-size: clamp(1.05rem, 0.65vw + 1rem, 1.35rem);
  line-height: 1.7;
  color: var(--hw-text-muted);
}

.how-work__step-points {
  display: grid;
  gap: 0.9rem;
  margin-top: 0.5rem;
}

.how-work__point {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  font-size: 1.05rem;
  line-height: 1.6;
  color: var(--hw-text-primary);
}

.how-work__bullet {
  margin-top: 0.6rem;
  width: 0.45rem;
  height: 0.45rem;
  border-radius: 999px;
  background: rgba(17, 17, 17, 0.5);
  flex-shrink: 0;
}

.how-work__point-text {
  color: var(--hw-text-muted);
}

@media (max-width: 959px) {
  .how-work__track {
    padding-inline: clamp(2rem, 10vw, 4rem);
  }

  .how-work__step-shell {
    grid-template-columns: 1fr;
    width: min(92vw, 640px);
  }

  .how-work__step-number {
    min-height: clamp(200px, 55vw, 340px);
  }
}

@media (max-width: 640px) {
  .how-work {
    --hw-top-gap: clamp(5rem, 28vh, 7.5rem);
    --hw-bottom-gap: var(--hw-top-gap);
  }

  .how-work__heading {
    padding: clamp(1.75rem, 8vw, 3rem) 0 clamp(1.25rem, 6vw, 2.5rem);
  }

  .how-work__track {
    padding-inline: clamp(1.25rem, 5vw, 2rem);
  }

  .how-work__step-card {
    border-radius: 28px;
    padding: clamp(1.75rem, 6vw, 2.5rem);
  }
}

@media (prefers-reduced-motion: reduce) {
  .how-work__heading,
  .how-work__track,
  .how-work__step {
    transition: none !important;
  }
}
</style>
