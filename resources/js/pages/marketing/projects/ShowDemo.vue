<template>
  <DefaultLayout>
    <!-- HERO -->
    <section class="hero">
      <div class="cover-wrap" :style="`--cover:url('${project.cover}')`">
        <div class="cover"></div>
        <div class="hero-inner">
          <BaseContainer>
            <div class="hero-head glass" role="banner" aria-label="Detalle de proyecto">
              <div class="hero-actions">
                <button class="btn action" @click="goBack" aria-label="Volver">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="label">Volver</span>
                </button>
                <button class="btn action" @click="shareOrCopy" aria-label="Compartir o copiar enlace">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 16V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 8l4-4 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="label">Compartir</span>
                </button>
              </div>
              <div class="eyebrow">Caso de estudio</div>
              <h1 class="title">
                {{ project.title.split(' ')[0] }}
                <span>{{ project.title.split(' ').slice(1).join(' ') }}</span>
              </h1>
              <p class="subtitle" v-if="project.excerpt">{{ project.excerpt }}</p>
              <ul class="tags" v-if="project.tags?.length">
                <li v-for="t in project.tags" :key="t">{{ t }}</li>
              </ul>
            </div>
          </BaseContainer>
        </div>
      </div>
    </section>

    <!-- NAV SECCIONES -->
    <nav class="section-nav" role="navigation" aria-label="Secciones del caso">
      <BaseContainer>
        <ul>
          <li v-for="s in sectionOrder" :key="s.id">
            <a :href="`#${s.id}`" :class="{active: activeSection === s.id}" @click.prevent="scrollToSection(s.id)">{{ s.label }}</a>
          </li>
        </ul>
      </BaseContainer>
    </nav>

    <!-- CONTENT -->
    <section class="section">
      <BaseContainer>
        <div class="grid">
          <!-- MAIN: foco 100% en valor/impacto -->
          <article class="main">
            <!-- KPIs arriba -->
            <div class="kpis" v-if="project.kpis?.length" role="list" aria-label="Indicadores clave">
              <div class="kpi" v-for="k in project.kpis" :key="k.label" role="listitem">
                <div class="kpi-icon" aria-hidden="true">
                  <svg v-if="getKpiIcon(k.label) === 'down'" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 7l10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M7 17h10V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <svg v-else-if="getKpiIcon(k.label) === 'speed'" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3a9 9 0 100 18 9 9 0 000-18z" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 12l4-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                  <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M7 8l5-5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="kpi-value" :aria-label="k.label">{{ k.value }}</div>
                <div class="kpi-label">{{ k.label }}</div>
              </div>
            </div>

            <!-- Resumen ejecutivo -->
            <div id="resumen" class="block block--summary section-block" v-if="project.summary">
              <h2>Resumen</h2>
              <p>{{ project.summary }}</p>
            </div>

            <!-- 1. Desafío -->
            <div id="desafio" class="block block--challenge section-block">
              <div class="block__head">
                <h2>Desafío</h2>
              </div>
              <div class="block__body">
                <p>{{ project.problem }}</p>
              </div>
            </div>

            <!-- 2. Solución (layout alterno) -->
            <div id="solucion" class="block block--solution section-block">
              <div class="block__head">
                <h2>Solución</h2>
              </div>
              <div class="block__body">
                <ul class="list">
                  <li v-for="(item, i) in project.solution" :key="i">{{ item }}</li>
                </ul>
              </div>
            </div>

            <!-- 3. Resultados / Impacto (destacado) -->
            <div id="resultados" class="block block--results section-block">
              <div class="block__head">
                <h2>Resultados</h2>
              </div>
              <div class="block__body">
                <p class="results-copy">{{ project.outcomes }}</p>
                <ul class="bullets" v-if="project.impactBullets?.length">
                  <li v-for="(b, i) in project.impactBullets" :key="i">{{ b }}</li>
                </ul>
              </div>
            </div>

            <!-- Características -->
            <div id="caracteristicas" class="block section-block" v-if="project.features?.length">
              <h2>Características clave</h2>
              <ul class="list">
                <li v-for="(f, i) in project.features" :key="i">{{ f }}</li>
              </ul>
            </div>

            <!-- Galería -->
    <div id="galeria" class="block section-block" v-if="displayGallery.length">
              <h2>Galería</h2>
              <div class="gallery">
                <figure
      v-for="(g, i) in displayGallery"
      :key="g.src"
                  :class="[{ 'span-2': (i % 5) === 0 }, { 'is-loading': !galleryLoaded[i] }]"
                >
                  <button class="img-btn" @click="openLightbox(i)" :aria-label="`Abrir imagen ${i+1} en visor`">
                    <img :src="g.src" :alt="g.caption || project.title" loading="lazy" @load="onGalleryLoad(i)" />
                  </button>
                  <figcaption v-if="g.caption">{{ g.caption }}</figcaption>
                </figure>
              </div>
            </div>

            <!-- Testimonial -->
            <div id="testimonial" class="testimonial section-block" v-if="project.testimonial">
              <div class="testimonial-top">
                <div class="testimonial-left">
                  <div v-if="project.testimonial.avatar" class="avatar-wrap">
                    <img class="avatar" :src="project.testimonial.avatar" :alt="`Avatar de ${project.testimonial.name}`" />
                  </div>
                  <div v-else class="avatar-placeholder" :style="avatarStyle(project.testimonial.name)" aria-hidden="true">{{ initials(project.testimonial.name) }}</div>
                </div>
                <div class="testimonial-info">
                  <strong class="who-name">{{ project.testimonial.name }}</strong>
                  <div class="who-role">{{ project.testimonial.role }}</div>
                </div>
              </div>
              <div class="testimonial-body">
                <blockquote class="quote">“{{ project.testimonial.quote }}”</blockquote>
              </div>
            </div>

            <!-- CTA principal -->
            <div class="cta" role="region" aria-label="Llamada a la acción">
              <div class="cta-copy">
                <strong>Transformamos ideas en productos escalables.</strong>
                <div class="muted">Cuéntanos tu reto y te proponemos un plan rápido y realista.</div>
              </div>
              <div class="cta-actions">
                <a href="/#contact" class="btn cta primary" aria-label="Solicitar presupuesto">Solicitar presupuesto</a>
              </div>
            </div>
          </article>

          <!-- ASIDE: extras/contexto -->
          <aside class="side">
            <div class="card quick-nav" aria-label="Navegación rápida">
              <h3>Contenido</h3>
              <ul>
                <li v-for="s in sectionOrder" :key="s.id">
                  <a :href="`#${s.id}`" :class="{active: activeSection === s.id}" @click.prevent="scrollToSection(s.id)">{{ s.label }}</a>
                </li>
              </ul>
            </div>
            <div class="card meta">
              <h3>Cliente</h3>
              <p>{{ project.client }}</p>
              <h3>Industria</h3>
              <p>{{ project.industry }}</p>
              <h3 v-if="project.role">Rol</h3>
              <p v-if="project.role">{{ project.role }}</p>
            </div>

            <div class="card">
              <h3>Stack</h3>
              <ul class="stack">
                <li v-for="s in project.stack" :key="s">{{ s }}</li>
              </ul>
            </div>

            <div class="card" v-if="project.timeline?.length">
              <h3>Timeline</h3>
              <ol class="timeline">
                <li v-for="t in project.timeline" :key="t.label">
                  <span class="dot"></span>
                  <div>
                    <strong>{{ t.label }}</strong>
                    <div class="tiny">{{ t.when }}</div>
                  </div>
                </li>
              </ol>
            </div>

            <div class="card links">
              <a v-if="project.live" :href="project.live" target="_blank" rel="noopener">Ver online →</a>
              <a v-if="project.repo" :href="project.repo" target="_blank" rel="noopener">Código →</a>
            </div>
          </aside>
        </div>
      </BaseContainer>
    </section>
  </DefaultLayout>
  <!-- LIGHTBOX accesible -->
  <div v-if="isLightboxOpen && displayGallery.length" class="lightbox" role="dialog" aria-modal="true" aria-label="Visor de imágenes" @keydown.esc="closeLightbox" tabindex="-1" ref="lightboxRef">
    <button class="lightbox__overlay" @click="closeLightbox" aria-label="Cerrar visor"></button>
    <div class="lightbox__inner">
      <button class="lightbox__close" @click="closeLightbox" aria-label="Cerrar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
      <button class="lightbox__nav prev" @click="prevImage" aria-label="Anterior">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
  <img :src="displayGallery[lightboxIndex].src" :alt="displayGallery[lightboxIndex].caption || project.title" />
      <button class="lightbox__nav next" @click="nextImage" aria-label="Siguiente">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
  <div class="lightbox__caption" v-if="displayGallery[lightboxIndex].caption">{{ displayGallery[lightboxIndex].caption }}</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import DefaultLayout from '@/layouts/marketing/DefaultLayout.vue'
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
import { onMounted, onBeforeUnmount, ref, nextTick, computed } from 'vue'

/**
 * IMPORTA EL COVER DESDE resources/js/assets/projects/orion/image.png
 * (Vite lo optimiza y genera hash para cache busting)
 */
import coverOrion from '@/assets/projects/orion/image.png'

type KPI = { label: string; value: string }
type TimelineItem = { label: string; when: string }
type GalleryItem = { src: string; caption?: string }
type Testimonial = { quote: string; name: string; role: string; avatar?: string }
type Project = {
  title: string
  excerpt: string
  cover: string
  summary: string
  problem: string
  solution: string[]
  outcomes: string
  impactBullets: string[]
  features: string[]
  kpis: KPI[]
  client: string
  industry: string
  role?: string
  stack: string[]
  live: string | null
  repo: string | null
  timeline: TimelineItem[]
  gallery?: GalleryItem[]
  testimonial?: Testimonial
  tags?: string[]
}

/**
 * DEMO DATA — luego lo moveremos a content/ o BD
 * Si agregas imágenes de galería: import g1 from '@/assets/projects/orion/galeria-1.png' ...
 */
const project: Project = {
  title: 'Proyecto Orion',
  excerpt: 'Plataforma para orquestar procesos y reportes en tiempo real con foco en rendimiento y conversión.',
  cover: coverOrion,
  tags: ['B2B', 'SaaS', 'Ops'],

  // MAIN content (prioritario)
  summary:
    'Construimos una aplicación unificada que integra flujo de aprobación, reportería exportable y tableros de métricas para acelerar decisiones y mejorar la visibilidad.',
  problem:
    'La organización gestionaba procesos en múltiples herramientas, sin trazabilidad ni KPIs unificados; esto generaba tiempos de respuesta altos y poca visibilidad.',
  solution: [
    'Backend Laravel con políticas, eventos y colas para tareas pesadas.',
    'SPA Vue 3 + Inertia con flujos guiados, estados claros y accesibilidad.',
    'Exportación PDF/CSV, auditoría y tablero de KPIs con caché.',
    'Infra con Docker, staging y healthchecks; monitoreo de performance.',
  ],
  outcomes:
    'Disminuimos el tiempo de ciclo en un 42% y aumentamos la tasa de adopción interna al 80%. Core Web Vitals en verde con LCP 1.4s y TBT estable.',
  impactBullets: ['−42% tiempo de ciclo', '+80% adopción interna', 'LCP 1.4s, Core Web Vitals “OK”'],
  features: ['Perfiles y permisos', 'Historial y auditoría', 'Bandejas por equipo', 'Reportes exportables'],

  // KPIs
  kpis: [
    { label: 'Tiempo de ciclo', value: '−42%' },
    { label: 'LCP', value: '1.4s' },
    { label: 'Adopción', value: '+80%' },
  ],

  // ASIDE
  client: 'Orion Labs',
  industry: 'Operaciones',
  role: 'Full-stack',
  stack: ['Laravel', 'Inertia', 'Vue 3', 'MySQL', 'Redis', 'Docker'],
  live: null,
  repo: null,
  timeline: [
    { label: 'Kickoff', when: 'Semana 1' },
    { label: 'MVP', when: 'Semana 4' },
    { label: 'Go-Live', when: 'Semana 7' },
    { label: 'Optimización', when: 'Semana 8–9' },
  ],

  // Galería (opcional)
  gallery: [],

  // Testimonial (opcional)
  testimonial: {
    quote:
      'La plataforma nos dio claridad operativa y aceleró la entrega. El foco en UX hizo que el equipo se adoptara rápido.',
    name: 'María Fernández',
    role: 'Directora de Operaciones, Orion Labs',
    // avatar: avatarImg
  },
}

// --- Navegación anclada y scrollspy ---
const sectionOrder = [
  { id: 'resumen', label: 'Resumen' },
  { id: 'desafio', label: 'Desafío' },
  { id: 'solucion', label: 'Solución' },
  { id: 'resultados', label: 'Resultados' },
  { id: 'caracteristicas', label: 'Características' },
  { id: 'galeria', label: 'Galería' },
  { id: 'testimonial', label: 'Testimonial' },
]
const activeSection = ref<string>('resumen')
let observer: IntersectionObserver | null = null

const createObserver = () => {
  const options = { root: null, rootMargin: '0px 0px -65% 0px', threshold: 0.25 }
  observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        activeSection.value = entry.target.id
      }
    })
  }, options)

  document.querySelectorAll<HTMLElement>('.section-block').forEach((el) => observer!.observe(el))
}

const scrollToSection = (id: string) => {
  const el = document.getElementById(id)
  if (!el) return
  const y = el.getBoundingClientRect().top + window.scrollY - 80
  window.scrollTo({ top: y, behavior: 'smooth' })
}

onMounted(() => {
  createObserver()
  // Si llega con hash, desplazamos suave
  if (location.hash) {
    const id = location.hash.replace('#', '')
    nextTick(() => scrollToSection(id))
  }
  // Navegación con teclado en lightbox
  window.addEventListener('keydown', handleKeyNav)
})

onBeforeUnmount(() => {
  if (observer) observer.disconnect()
  window.removeEventListener('keydown', handleKeyNav)
})

// --- Acciones hero ---
const goBack = () => {
  if (window.history.length > 1) window.history.back()
  else window.location.href = '/'
}

const shareOrCopy = async () => {
  const data = { title: project.title, text: project.excerpt, url: window.location.href }
  try {
    const nav = navigator as any
    if (typeof nav.share === 'function') return await nav.share(data)
  } catch {
    // continúa al fallback
  }
  try {
    await navigator.clipboard.writeText(window.location.href)
    // feedback ligero
    tempToast('Enlace copiado')
  } catch {
    tempToast('No se pudo copiar')
  }
}

const tempToast = (msg: string) => {
  const toast = document.createElement('div')
  toast.className = 'toast'
  toast.textContent = msg
  document.body.appendChild(toast)
  setTimeout(() => toast.classList.add('show'), 10)
  setTimeout(() => {
    toast.classList.remove('show')
    setTimeout(() => toast.remove(), 300)
  }, 1600)
}

// --- KPIs: icon mapping ---
const getKpiIcon = (label: string): 'down' | 'speed' | 'up' => {
  const l = label.toLowerCase()
  if (l.includes('tiempo') || l.includes('ciclo')) return 'down'
  if (l.includes('lcp') || l.includes('performance') || l.includes('core web vitals')) return 'speed'
  return 'up'
}

// --- Galería: lightbox + skeleton ---
const isLightboxOpen = ref(false)
const lightboxIndex = ref(0)
const lightboxRef = ref<HTMLDivElement | null>(null)
const galleryLoaded = ref<Record<number, boolean>>({})
// Placeholders si no hay galería
const makePlaceholder = (title: string, i: number): string => {
  const w = 1200, h = 800
  const bg = encodeURIComponent('#0b1220')
  const grad1 = encodeURIComponent('#22d3ee')
  const grad2 = encodeURIComponent('#a78bfa')
  const txt = encodeURIComponent(`${title} — Mock ${i+1}`)
  const svg = `<?xml version='1.0' encoding='UTF-8'?>
  <svg xmlns='http://www.w3.org/2000/svg' width='${w}' height='${h}'>
    <defs>
      <linearGradient id='g' x1='0' y1='0' x2='1' y2='1'>
        <stop offset='0%' stop-color='${grad1}' stop-opacity='0.6'/>
        <stop offset='100%' stop-color='${grad2}' stop-opacity='0.6'/>
      </linearGradient>
    </defs>
    <rect width='100%' height='100%' fill='${bg}'/>
    <rect x='20' y='20' width='${w-40}' height='${h-40}' rx='16' fill='url(#g)' opacity='0.25'/>
    <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='#e9ecff' font-family='Inter, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, sans-serif' font-size='42'>${txt}</text>
  </svg>`
  return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`
}
const defaultGallery: GalleryItem[] = [
  { src: makePlaceholder(project.title, 0), caption: 'Dashboard principal' },
  { src: makePlaceholder(project.title, 1), caption: 'Flujos y estados' },
  { src: makePlaceholder(project.title, 2), caption: 'Reportes y exportación' },
]
const displayGallery = computed<GalleryItem[]>(() => (project.gallery && project.gallery.length ? project.gallery : defaultGallery))

const onGalleryLoad = (i: number) => {
  galleryLoaded.value[i] = true
}

const openLightbox = (i: number) => {
  lightboxIndex.value = i
  isLightboxOpen.value = true
  nextTick(() => lightboxRef.value?.focus())
}
const closeLightbox = () => {
  isLightboxOpen.value = false
}
const prevImage = () => {
  if (!displayGallery.value.length) return
  lightboxIndex.value = (lightboxIndex.value - 1 + displayGallery.value.length) % displayGallery.value.length
}
const nextImage = () => {
  if (!displayGallery.value.length) return
  lightboxIndex.value = (lightboxIndex.value + 1) % displayGallery.value.length
}
const handleKeyNav = (e: KeyboardEvent) => {
  if (!isLightboxOpen.value) return
  if (e.key === 'ArrowLeft') prevImage()
  if (e.key === 'ArrowRight') nextImage()
  if (e.key === 'Escape') closeLightbox()
}

// --- Testimonial helpers ---
const initials = (name = '') => {
  const parts = name.split(' ').filter(Boolean)
  return (parts[0]?.[0] || '') + (parts[1]?.[0] || '')
}
const avatarStyle = (name = '') => {
  // simple deterministic color from name
  const colors = ['#f97316', '#fb7185', '#60a5fa', '#34d399', '#a78bfa']
  let sum = 0
  for (let i = 0; i < name.length; i++) sum += name.charCodeAt(i)
  const c = colors[sum % colors.length]
  return { background: `linear-gradient(135deg, ${c}, rgba(167,139,250,0.6))`, color: '#0b1220' }
}
</script>

<style scoped>
/* ------ HERO mejorado ------ */
.hero{
  position:relative; color:#fff;
}
.cover-wrap{
  position:relative; min-height: 62vh; isolation:isolate;
  background:
    radial-gradient(1200px 60% at 50% 10%, rgba(34,211,238,.22), transparent 60%),
    radial-gradient(800px 40% at 20% 0%, rgba(167,139,250,.18), transparent 60%);
}
.cover{
  position:absolute; inset:0;
  background:
    linear-gradient(180deg, rgba(11,18,32,0) 0%, rgba(11,18,32,.72) 70%, rgba(11,18,32,1) 100%),
    var(--cover) center/cover no-repeat;
  filter: saturate(108%) contrast(106%);
  z-index:-1;
}
.hero-inner{ display:grid; align-items:end; min-height: inherit; padding-top: 72px; }
.hero-head{
  padding: clamp(20px, 4vw, 34px);
}
.hero-head.glass{
  background: rgba(8,12,24,.34);
  border:1px solid rgba(255,255,255,.16);
  border-radius: 16px;
  backdrop-filter: blur(10px) saturate(130%);
  box-shadow: 0 10px 40px rgba(0,0,0,.28);
}
.hero-actions{ display:flex; gap:10px; margin-bottom:10px; flex-wrap:wrap }
.btn.action{
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  height:38px; padding:0 12px; border-radius:12px; color:#e9ecff; background: rgba(255,255,255,.08);
  border:1px solid rgba(255,255,255,.16); cursor:pointer; font-weight:600; font-size:.92rem;
}
.btn.action .label{ line-height:1; }
.btn.action:hover{ color:#0b1220; background: linear-gradient(90deg, #22d3ee, #a78bfa); box-shadow: 0 8px 24px rgba(34,211,238,.25) }
.btn.action:focus-visible{ outline:2px solid #22d3ee; outline-offset:2px }
.eyebrow{ color: var(--muted, #cfd2ffb0); font-size:.95rem; letter-spacing:.4px; text-transform:uppercase }
.title{ margin:6px 0 8px; font-size: clamp(32px, 4.8vw, 60px); line-height:1.04; color:#fff }
.title span{ color: var(--accent, #22d3ee) }
.subtitle{ color: var(--muted, #cfd2ffb0); max-width: 820px }
.tags{ display:flex; gap:8px; list-style:none; padding:0; margin:14px 0 0 }
.tags li{
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius:999px; padding:6px 12px; font-size:.85rem; color:var(--muted, #cfd2ffb0);
  background: rgba(255,255,255,.06);
}

/* ------ NAV SECCIONES ------ */
.section-nav{
  position: sticky; top: 0; z-index: 20;
  background: linear-gradient(180deg, rgba(11,18,32,.86), rgba(11,18,32,.72));
  border-bottom: 1px solid rgba(255,255,255,.08);
  backdrop-filter: blur(6px);
}
.section-nav ul{ display:flex; flex-wrap:wrap; gap:8px; padding:10px 0; margin:0; list-style:none }
.section-nav a{
  display:inline-block; padding:8px 12px; border-radius:999px; color:#cfd2ff; text-decoration:none; font-size:.92rem;
  border:1px solid rgba(255,255,255,.14); background: rgba(255,255,255,.04);
}
.section-nav a:hover{ color:#0b1220; background: linear-gradient(90deg, #22d3ee, #a78bfa) }
.section-nav a.active{ color:#0b1220; font-weight:700; background: linear-gradient(90deg, #22d3ee, #a78bfa); border-color: transparent }

/* ------ LAYOUT ------ */
.grid{
  display:grid; grid-template-columns: 1fr 320px; gap:22px;
}
.main{ min-width:0 }
.side{ position:sticky; top:80px; align-self:start; display:grid; gap:14px }

/* ------ CARDS & ELEMENTS ------ */
.card{
  background: var(--glass, rgba(255,255,255,.05));
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius: 14px; padding:14px;
  box-shadow: 0 10px 40px rgba(0,0,0,.25);
}
.card h3{ margin:6px 0 8px; font-size:1.05rem; color:#fff }
.quick-nav ul{ list-style:none; padding:0; margin:0; display:grid; gap:6px }
.quick-nav a{ color:#cfd2ff; text-decoration:none; border-bottom:1px dashed rgba(255,255,255,.2) }
.quick-nav a.active, .quick-nav a:hover{ color:#22d3ee }

/* KPIs */
.kpis{
  display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; margin-bottom: 16px;
}
.kpi{
  background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.03));
  border:1px solid var(--stroke, rgba(255,255,255,.16));
  border-radius: 12px; padding:16px;
  text-align:center;
  box-shadow: 0 10px 34px rgba(0,0,0,.2);
}
.kpi-icon{ width:28px; height:28px; margin: 0 auto 6px; color:#22d3ee }
.kpi-value{ font-size:1.7rem; font-weight:800; color:#fff }
.kpi-label{ color: var(--muted, #cfd2ffb0); font-size:.9rem }

/* BLOQUES (ritmo visual) */
.block{
  background: var(--glass, rgba(255,255,255,.05));
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius:14px; padding:18px; margin: 14px 0;
  box-shadow: 0 10px 34px rgba(0,0,0,.2);
}
.block h2{ margin:0 0 8px; color:#fff }
.block p{ margin: 8px 0; color:#e9ecff }
.list, .bullets{ margin: 8px 0 0 18px; color:#e9ecff }
.list li, .bullets li{ margin:6px 0 }

.block--summary{
  border-color: rgba(167,139,250,.28);
  background: linear-gradient(145deg, rgba(167,139,250,.08), rgba(255,255,255,.04));
}
.block--challenge{
  border-color: rgba(255,255,255,.18);
}
.block--solution{
  border-color: rgba(34,211,238,.28);
  background: linear-gradient(145deg, rgba(34,211,238,.08), rgba(255,255,255,.03));
}
.block--results{
  text-align:center;
  border-color: rgba(34,211,238,.35);
  background: linear-gradient(135deg, rgba(34,211,238,.12), rgba(167,139,250,.10));
}
.results-copy{ font-size:1.08rem; }

/* GALERÍA (masonry-like simple + hover) */
.gallery{
  display:grid; grid-template-columns: repeat(6, 1fr); gap:10px;
}
.gallery figure{
  grid-column: span 3;
  background: rgba(255,255,255,.04);
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius: 12px; overflow:hidden;
  transition: transform .18s ease, box-shadow .2s ease, border-color .2s ease;
}
.gallery figure.span-2{ grid-column: span 4 }
.gallery figure.is-loading{ position:relative }
.gallery figure.is-loading::before{
  content:""; position:absolute; inset:0; background: linear-gradient(90deg, rgba(255,255,255,.05), rgba(255,255,255,.12), rgba(255,255,255,.05));
  background-size:200% 100%; animation: shimmer 1.2s infinite;
}
.img-btn{ display:block; padding:0; border:none; background:none; cursor:zoom-in }
.gallery img{
  width:100%; height:auto; display:block;
  transition: transform .25s ease;
}
.gallery img:hover{ transform: scale(1.05); }
.gallery figcaption{ padding:8px 10px; color: var(--muted, #cfd2ffb0); font-size:.9rem; background: rgba(0,0,0,.25) }
.gallery figure:hover{
  transform: translateY(-3px);
  border-color: rgba(34,211,238,.45);
  box-shadow: 0 14px 54px rgba(34,211,238,.25);
}
@keyframes shimmer{ 0%{ background-position:200% 0 } 100%{ background-position:-200% 0 } }

/* TESTIMONIAL humanizado */
.testimonial{
  margin-top: 16px; display:flex; gap:16px; align-items:center;
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius:14px; padding:18px;
  background: linear-gradient(145deg, rgba(34,211,238,.15), rgba(167,139,250,.10));
  box-shadow: 0 14px 54px rgba(34,211,238,.15);
}
.testimonial .avatar{
  width:60px; height:60px; border-radius:50%; object-fit:cover; border:1px solid rgba(255,255,255,.2);
}
.testimonial blockquote{ margin:0; font-size:1.15rem; color:#fff; font-style:italic }
.testimonial .who{ margin-top:6px; color: var(--muted, #cfd2ffb0) }

/* Testimonial: humanizado */
.testimonial{ display:block; padding:18px }
.testimonial-top{ display:flex; gap:12px; align-items:center }
.testimonial-left{ flex:0 0 auto }
.avatar-wrap{ width:64px; height:64px; border-radius:12px; overflow:hidden }
.avatar{ width:64px; height:64px; border-radius:10px; object-fit:cover; border:1px solid rgba(255,255,255,.12) }
.avatar-placeholder{ width:64px; height:64px; border-radius:10px; display:grid; place-items:center; font-weight:700; font-size:1.05rem; color:#0b1220; border:1px solid rgba(255,255,255,.06) }
.testimonial-info{ display:flex; flex-direction:column }
.who-name{ font-weight:800; color:#fff; font-size:1rem }
.who-role{ color: var(--muted, #cfd2ffb0); font-size:.95rem; margin-top:4px }
.testimonial-body{ margin-top:12px }
.quote{ font-size:1.08rem; color:#fff; margin:0; line-height:1.45 }

/* ASIDE mejorado */
.stack{ display:flex; gap:8px; flex-wrap:wrap; padding:0; list-style:none; margin:6px 0 2px }
.stack li{
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius:999px; padding:6px 12px; font-size:.85rem; color:var(--muted, #cfd2ffb0);
  background: rgba(255,255,255,.06);
}
.timeline{
  position:relative; list-style:none; padding:0; margin:12px 0 0; display:grid; gap:0;
  /* Línea vertical */
}
.timeline::before{
  content:''; position:absolute; left:8px; top:0; bottom:0; width:2px;
  background: linear-gradient(180deg, transparent, var(--accent, #22d3ee) 10%, var(--accent, #22d3ee) 90%, transparent);
}
.timeline li{ 
  position:relative; display:flex; align-items:flex-start; gap:16px; padding:12px 0; 
  transition: all 0.2s ease;
}
.timeline li:hover{ transform: translateX(2px) }
/* Punto dinámico */
.timeline li::before{
  content:''; position:absolute; left:2px; top:16px; width:14px; height:14px; 
  border-radius:50%; background: var(--accent, #22d3ee); 
  border:3px solid rgba(11,18,32,1); /* fondo oscuro */
  box-shadow: 0 0 0 1px rgba(34,211,238,.3), 0 4px 12px rgba(34,211,238,.2);
  transition: all 0.25s ease; z-index:2;
}
.timeline li:hover::before{ 
  transform: scale(1.15);
  box-shadow: 0 0 0 2px rgba(34,211,238,.5), 0 6px 20px rgba(34,211,238,.35);
}
/* Contenido del timeline */
.timeline li > div{ padding-left:24px; min-width:0 }
.timeline strong{ display:block; font-weight:700; color:#fff; font-size:1rem; margin-bottom:4px }
.timeline .dot{ display:none }
.tiny{ color: var(--muted, #cfd2ffb0); font-size:.92rem; margin-top:2px; display:block }
.links{ display:grid; gap:8px }
.links a{ color:#fff; text-decoration:none; border-bottom:1px dashed rgba(255,255,255,.25); padding-bottom:2px }
.links a:hover{ color: var(--accent, #22d3ee) }

/* CTA final */
.cta{ margin:26px 0 8px; display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between }
.cta-copy{ max-width:720px }
.cta-copy strong{ font-size:1.06rem; color:#fff; display:block }
.cta-copy .muted{ color: var(--muted, #cfd2ffb0); font-size:.95rem; margin-top:6px }
.cta-actions{ display:flex; gap:10px; align-items:center }
.btn.cta{ padding:12px 18px; border-radius:12px; text-decoration:none; font-weight:800; letter-spacing:.2px; border:1px solid rgba(255,255,255,.12); }
.btn.cta.primary{ background: linear-gradient(90deg, #22d3ee, #a78bfa); color:#0b1220 }
.btn.cta.primary:hover{ transform: translateY(-3px); box-shadow: 0 20px 60px rgba(34,211,238,.16) }

@media (max-width: 700px){
  .cta{ flex-direction:column; align-items:stretch }
  .cta-actions{ width:100%; justify-content:stretch }
  .btn.cta{ flex:1 }
}

/* Lightbox */
.lightbox{ position:fixed; inset:0; z-index:50; display:grid; place-items:center }
.lightbox__overlay{ position:absolute; inset:0; background:rgba(4,6,14,.8); backdrop-filter: blur(2px); border:none }
.lightbox__inner{ position:relative; max-width:min(92vw, 1100px); max-height:80vh; display:grid; place-items:center }
.lightbox__inner img{ max-width:100%; max-height:80vh; border-radius:12px; border:1px solid rgba(255,255,255,.2); box-shadow: 0 20px 60px rgba(0,0,0,.5) }
.lightbox__close{ position:absolute; top:-44px; right:0; width:36px; height:36px; border-radius:10px; color:#e9ecff; background: rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); cursor:pointer }
.lightbox__nav{ position:absolute; top:50%; transform:translateY(-50%); width:42px; height:42px; border-radius:999px; color:#0b1220; background: linear-gradient(90deg, #22d3ee, #a78bfa); border:none; cursor:pointer; display:grid; place-items:center }
.lightbox__nav.prev{ left:-22px }
.lightbox__nav.next{ right:-22px }
.lightbox__caption{ margin-top:10px; color:#cfd2ff; text-align:center }

.toast{ position:fixed; bottom:18px; left:50%; transform:translateX(-50%); background:#0b1220; color:#e9ecff; border:1px solid rgba(255,255,255,.2); border-radius:10px; padding:8px 12px; opacity:0; transition: opacity .2s ease }
.toast.show{ opacity:1 }

/* RESPONSIVE */
@media (max-width: 1100px){
  .grid{ grid-template-columns: 1fr }
  .side{ position:static }
  .kpis{ grid-template-columns:1fr 1fr }
  .lightbox__nav.prev{ left:6px } .lightbox__nav.next{ right:6px }
  .lightbox__close{ top:8px; right:8px }
}
@media (max-width: 700px){
  .kpis{ grid-template-columns:1fr }
  .gallery{ grid-template-columns: repeat(2, 1fr) }
  .gallery figure, .gallery figure.span-2{ grid-column: span 2 }
}

/* Accesibilidad */
.sr-only{ position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0 }
.section a:focus-visible, .links a:focus-visible{ outline:2px solid #22d3ee; outline-offset:2px }
</style>
