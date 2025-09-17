<template>
  <DefaultLayout>
    <!-- HERO -->
    <section class="hero">
      <div class="cover-wrap" :style="`--cover:url('${project.cover}')`">
        <div class="cover"></div>
        <div class="hero-inner">
          <BaseContainer>
            <div class="hero-content">
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

              <!-- VALOR Y CREDIBILIDAD INMEDIATA -->
              <div class="hero-results animate-section reveal-delay-4">
                <!-- KPIs Compactos -->
                <div class="results-kpis">
                  <div v-for="(kpi, index) in project.kpis" :key="index" class="kpi-compact" 
                       :class="[{ 'has-tooltip': kpi.tooltip }, `reveal-delay-${5 + index}`]"
                       :title="kpi.tooltip">
                    <div class="kpi-icon" v-html="getKpiIcon(kpi)"></div>
                    <div class="kpi-data">
                      <div class="kpi-value" :data-target="parseFloat(kpi.value)" data-suffix="">{{ kpi.value }}</div>
                      <div class="kpi-label">{{ kpi.label }}</div>
                    </div>
                  </div>
                </div>
                
                <!-- Resumen Ejecutivo -->
                <div class="executive-summary">
                  <h3>¿Qué logramos?</h3>
                  <p>{{ project.summary }}</p>
                  <div class="social-proof">
                    <div class="client-badge">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                      </svg>
                      <span>{{ project.client }}</span>
                    </div>
                    <div class="industry-badge">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                      </svg>
                      <span>{{ project.industry }}</span>
                    </div>
                  </div>
                  
                  <!-- CTA Estratégico -->
                  <div class="hero-cta">
                    <a href="/#contact" class="cta-subtle">
                      <span>¿Necesitas resultados similares?</span>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17l9.2-9.2M17 17V7H7"/>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
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
          <!-- MAIN: Conversion-optimized flow -->
          <article class="main">
            <!-- 1. STORY HOOK - Context sin redundancia -->
            <div id="contexto" class="block block--context section-block animate-section reveal">
              <!-- Section Header Consistente -->
              <div class="section-header reveal-delay-1">
                <div class="section-meta">
                  <span class="section-tag">{{ project.industry }}</span>
                  <span class="section-tag secondary">{{ project.timeline?.length ? `${project.timeline.length} semanas` : 'Proyecto ágil' }}</span>
                </div>
                <h2 class="section-title">El reto que resolvimos</h2>
                <p class="section-subtitle">Contexto del problema y nuestro enfoque estratégico</p>
              </div>
              
              <!-- Section Content -->
              <div class="section-content">
                <div class="story-content">
                  <div class="challenge-summary reveal-delay-2">
                    <h3>🚨 El Desafío</h3>
                    <p>{{ project.problem }}</p>
                  </div>
                  <div class="solution-preview reveal-delay-3">
                    <h3>💡 Nuestro Enfoque</h3>
                    <p>{{ project.summary }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- 2. TECHNICAL SOLUTION - Para developers -->
            <div id="solucion" class="block block--solution section-block animate-section reveal">
              <!-- Section Header Consistente -->
              <div class="section-header reveal-delay-1">
                <div class="section-meta">
                  <span class="section-tag">{{ project.role }}</span>
                  <span v-for="tech in project.stack.slice(0, 3)" :key="tech" class="section-tag secondary">{{ tech }}</span>
                  <span v-if="project.stack.length > 3" class="section-tag secondary">+{{ project.stack.length - 3 }} más</span>
                </div>
                <h2 class="section-title">Cómo lo resolvimos</h2>
                <p class="section-subtitle">Estrategia técnica y características implementadas</p>
              </div>
              
              <!-- Section Content -->
              <div class="section-content">
                <div class="solution-grid">
                  <div class="approach-list reveal-delay-2">
                    <h3>Estrategia técnica</h3>
                    <ul class="approach-items">
                      <li v-for="(item, i) in project.solution" :key="i" class="approach-item">
                        <div class="approach-icon">{{ i + 1 }}</div>
                        <span>{{ item }}</span>
                      </li>
                    </ul>
                  </div>
                  <div class="key-features reveal-delay-3" v-if="project.features?.length">
                    <h3>Características clave</h3>
                    <div class="features-grid">
                      <div v-for="(f, i) in project.features" :key="i" class="feature-card">
                        <div class="feature-icon">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20,6 9,17 4,12"/>
                          </svg>
                        </div>
                        <span>{{ f }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 3. RESULTS VALIDATION - Proof vs claims -->  
            <div id="resultados" class="block block--results section-block animate-section reveal">
              <!-- Section Header Consistente -->
              <div class="section-header reveal-delay-1">
                <div class="section-meta">
                  <span class="section-tag">Resultados</span>
                  <span class="section-tag secondary">Métricas Reales</span>
                  <span class="section-tag secondary">Impacto Medible</span>
                </div>
                <h2 class="section-title">Resultados conseguidos</h2>
                <p class="section-subtitle">Métricas reales del impacto generado en el proyecto</p>
              </div>
              
              <!-- Section Content -->
              <div class="section-content">
                <div class="results-showcase">
                  <div class="impact-narrative reveal-delay-2">
                    <p class="results-copy">{{ project.outcomes }}</p>
                  </div>
                  <div class="impact-metrics reveal-delay-3" v-if="project.impactBullets?.length">
                    <div v-for="(bullet, i) in project.impactBullets" :key="i" class="metric-highlight">
                      <div class="metric-value">{{ bullet.split(' ')[0] }}</div>
                      <div class="metric-label">{{ bullet.split(' ').slice(1).join(' ') }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 5. VISUAL EVIDENCE - Galería con contexto -->
            <div id="galeria" class="block section-block animate-section reveal" v-if="displayGallery.length">
              <!-- Section Header Consistente -->
              <div class="section-header reveal-delay-1">
                <div class="section-meta">
                  <span class="section-tag">Visual</span>
                  <span class="section-tag secondary">{{ displayGallery.length }} Capturas</span>
                  <span class="section-tag secondary">UI/UX</span>
                </div>
                <h2 class="section-title">Evidencia visual</h2>
                <p class="section-subtitle">Capturas del producto en funcionamiento</p>
              </div>
              
              <!-- Section Content -->
              <div class="section-content">
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
            </div>

            <!-- 4. TESTIMONIAL - Validación social -->
            <div id="testimonial" class="testimonial section-block reveal" v-if="project.testimonial">
              <!-- Section Header Consistente -->
              <div class="section-header reveal-delay-1">
                <div class="section-meta">
                  <span class="section-tag">Testimonial</span>
                  <span class="section-tag secondary">{{ project.client }}</span>
                  <span class="section-tag secondary">Validación</span>
                </div>
                <h2 class="section-title">Lo que dicen nuestros clientes</h2>
                <p class="section-subtitle">Experiencia directa del equipo que trabajó con nosotros</p>
              </div>
              
              <!-- Section Content -->
              <div class="section-content">
                <div class="testimonial-card">
                  <div class="testimonial-top reveal-delay-2">
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
              </div>
            </div>

            <!-- 6. ACTION ZONE - CTA optimizado -->
            <div class="cta-zone section-block animate-section reveal" role="region" aria-label="Llamada a la acción">
              <div class="cta-container">
                <div class="cta-content">
                  <div class="cta-header">
                    <h2>¿Listo para resultados similares?</h2>
                    <p class="cta-subtitle">Transformamos ideas en productos escalables con métricas comprobadas</p>
                  </div>
                  <div class="cta-stats">
                    <div class="stat-item">
                      <div class="stat-value">50+</div>
                      <div class="stat-label">Proyectos entregados</div>
                    </div>
                    <div class="stat-item">
                      <div class="stat-value">98%</div>
                      <div class="stat-label">Clientes satisfechos</div>
                    </div>
                    <div class="stat-item">
                      <div class="stat-value">2-8</div>
                      <div class="stat-label">Semanas promedio</div>
                    </div>
                  </div>
                </div>
                <div class="cta-actions">
                  <a href="/#contact" class="btn cta primary" aria-label="Solicitar presupuesto">
                    <span>Solicitar presupuesto</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M7 17l9.2-9.2M17 17V7H7"/>
                    </svg>
                  </a>
                  <a href="/#projects" class="btn cta secondary">Ver más casos</a>
                </div>
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
  
  <!-- STICKY CTA -->
  <Transition name="sticky-cta">
    <div v-if="showStickyCTA" class="sticky-cta" role="banner" aria-label="Llamada a la acción flotante">
      <BaseContainer>
        <div class="sticky-cta-inner">
          <div class="sticky-cta-text">
            <strong>{{ project.title }}</strong>
            <span>Solicita tu presupuesto personalizado</span>
          </div>
          <a href="/#contact" class="btn sticky-primary">Solicitar presupuesto</a>
        </div>
      </BaseContainer>
    </div>
  </Transition>

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

type KPI = { label: string; value: string; tooltip?: string }
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
    { label: 'Tiempo de ciclo', value: '−42%', tooltip: 'Reducción del tiempo promedio entre inicio y finalización de procesos críticos' },
    { label: 'LCP', value: '1.4s', tooltip: 'Largest Contentful Paint - Tiempo de carga del elemento más grande visible' },
    { label: 'Adopción', value: '+80%', tooltip: 'Incremento en la tasa de adopción interna de la plataforma por parte de los equipos' },
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
  { id: 'contexto', label: 'Contexto' },
  { id: 'solucion', label: 'Solución' },
  { id: 'resultados', label: 'Resultados' },
  { id: 'testimonial', label: 'Testimonial' },
  { id: 'galeria', label: 'Galería' },
]
const activeSection = ref<string>('contexto')
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
  createKpiObserver()
  createStickyObserver()
  initializeScrollAnimations()
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
  if (stickyObserver.value) stickyObserver.value.disconnect()
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

// --- KPIs: icon mapping & counters ---
const getKpiIcon = (kpi: KPI): string => {
  const l = kpi.label.toLowerCase()
  if (l.includes('tiempo') || l.includes('ciclo')) {
    return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M7 13l3 3 7-7" stroke="#22d3ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 2L8 6l4 4 4-4-4-4z" fill="#22d3ee" opacity="0.2"/></svg>`
  }
  if (l.includes('lcp') || l.includes('performance') || l.includes('core web vitals')) {
    return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#22d3ee" stroke-width="2"/><path d="M12 6v6l4 2" stroke="#22d3ee" stroke-width="2" stroke-linecap="round"/></svg>`
  }
  return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="#22d3ee"/></svg>`
}

// Animated counters para KPIs del hero
const kpiCounters = ref<Record<string, number>>({})
const kpiAnimated = ref<Record<string, boolean>>({})

const animateCounter = (target: number, key: string) => {
  const duration = 1500
  const start = performance.now()
  const isNegative = target < 0
  const absTarget = Math.abs(target)
  
  const animate = (currentTime: number) => {
    const elapsed = currentTime - start
    const progress = Math.min(elapsed / duration, 1)
    const easeOut = 1 - Math.pow(1 - progress, 3)
    const current = Math.floor(absTarget * easeOut)
    kpiCounters.value[key] = isNegative ? -current : current
    
    if (progress < 1) requestAnimationFrame(animate)
  }
  requestAnimationFrame(animate)
}

const createKpiObserver = () => {
  const options = { root: null, rootMargin: '0px', threshold: 0.3 }
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        project.kpis.forEach((kpi) => {
          if (!kpiAnimated.value[kpi.label]) {
            const numValue = parseInt(kpi.value.replace(/[^\d-]/g, ''))
            if (!isNaN(numValue)) {
              animateCounter(numValue, kpi.label)
              kpiAnimated.value[kpi.label] = true
            }
          }
        })
        observer.disconnect()
      }
    })
  }, options)
  
  const kpiContainer = document.querySelector('.kpis')
  if (kpiContainer) observer.observe(kpiContainer)
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

// --- Sticky CTA ---
const showStickyCTA = ref(false)
const stickyObserver = ref<IntersectionObserver | null>(null)

const createStickyObserver = () => {
  const options = { root: null, rootMargin: '0px', threshold: 0 }
  stickyObserver.value = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      // Show sticky CTA when main CTA is out of view
      showStickyCTA.value = !entry.isIntersecting
    })
  }, options)
  
  const mainCTA = document.querySelector('.cta')
  if (mainCTA) stickyObserver.value.observe(mainCTA)
}

// --- Scroll Animations ---
const initializeScrollAnimations = () => {
  const animationObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Delay para que la animación sea más apreciable
          setTimeout(() => {
            entry.target.classList.add('animate-in')
          }, 150)
        }
      })
    },
    { 
      threshold: 0.2,  // Requiere más visibilidad antes de animar
      rootMargin: '0px 0px -100px 0px'  // Más margen para activar más tarde
    }
  )

  // Observar secciones principales con delay escalonado
  const sections = document.querySelectorAll('.block, .testimonial, .timeline, .gallery, .hero-results')
  sections.forEach((section, index) => {
    section.classList.add('animate-section')
    // Delay escalonado para efecto cascade más pronunciado
    setTimeout(() => {
      animationObserver.observe(section)
    }, index * 200)
  })
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
  position:relative; min-height: 90vh; isolation:isolate;
  background:
    radial-gradient(1200px 60% at 50% 10%, rgba(34,211,238,.22), transparent 60%),
    radial-gradient(800px 40% at 20% 0%, rgba(167,139,250,.18), transparent 60%);
}
.cover{
  position:absolute; inset:0;
  background:
    linear-gradient(180deg, rgba(11,18,32,0) 0%, rgba(11,18,32,.65) 60%, rgba(11,18,32,.9) 100%),
    var(--cover) center/cover no-repeat;
  filter: saturate(108%) contrast(106%);
  z-index:-1;
}
.hero-inner{ 
  display:flex; align-items:center; justify-content:center; flex-direction:column;
  min-height: inherit; padding: 32px 0;
}
.hero-content{
  display:grid; 
  grid-template-areas: 
    "header header"
    "results results";
  grid-template-rows: auto 1fr;
  gap: 32px; 
  width: 100%; max-width: 1100px;
  min-height: 70vh; /* Asegurar uso del espacio vertical */
}
.hero-head{
  grid-area: header;
  padding: clamp(20px, 4vw, 32px);
  text-align: center; /* Centrar para mayor impacto */
}
.hero-head.glass{
  background: rgba(8,12,24,.34);
  border:1px solid rgba(255,255,255,.16);
  border-radius: 16px;
  backdrop-filter: blur(10px) saturate(130%);
  box-shadow: 0 10px 40px rgba(0,0,0,.28);
}
.hero-actions{ display:flex; gap:12px; margin-bottom:16px; flex-wrap:wrap }
.btn.action{
  display:inline-flex; align-items:center; justify-content:center; gap:8px;
  height:40px; padding:0 16px; border-radius:12px; color:#e9ecff; background: rgba(255,255,255,.08);
  border:1px solid rgba(255,255,255,.18); cursor:pointer; font-weight:600; font-size:.92rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn.action .label{ line-height:1; }
.btn.action:hover{ 
  color:#0b1220; background: linear-gradient(90deg, #22d3ee, #a78bfa); 
  box-shadow: 0 8px 24px rgba(34,211,238,.3); transform: translateY(-2px);
}
.btn.action:focus-visible{ outline:2px solid #22d3ee; outline-offset:2px }
.eyebrow{ 
  color: var(--accent); 
  font-size:.9rem; 
  letter-spacing:.6px; 
  text-transform:uppercase; 
  font-weight: 600;
  margin-bottom: 8px;
}
.title{ 
  margin:0 0 16px; 
  font-size: clamp(28px, 4.2vw, 48px); 
  line-height:1.1; 
  color: var(--foreground);
  text-shadow: 0 2px 4px rgba(0,0,0,.3);
}
.title span{ 
  color: var(--accent); 
  background: var(--accent);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.subtitle{ 
  color: var(--foreground-muted); 
  max-width: 600px; 
  font-size: 1.05rem;
  line-height: 1.5;
  margin: 0 auto;
}
.tags{ display:flex; gap:8px; list-style:none; padding:0; margin:14px 0 0 }
.tags li{
  border:1px solid var(--stroke, rgba(255,255,255,.15));
  border-radius:999px; padding:6px 12px; font-size:.85rem; color:var(--muted, #cfd2ffb0);
  background: rgba(255,255,255,.06);
}

/* Hero Results Section - Con tu estética */
.hero-results{
  grid-area: results;
  display: grid; 
  grid-template-columns: auto 1fr; 
  gap: 32px; 
  align-items: start;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  padding: 32px;
  backdrop-filter: blur(10px);
  box-shadow: 0 10px 30px rgba(34, 211, 238, .15);
}

/* KPIs Compactos - Perfectamente alineados */
.results-kpis{
  display: flex; 
  flex-direction: column; 
  gap: 16px;
  min-width: 160px;
}
.kpi-compact{
  display: flex; 
  align-items: center; 
  gap: 14px;
  padding: 16px 18px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  min-height: 68px; /* Altura consistente */
}
.kpi-compact:hover{
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateX(6px);
  box-shadow: 0 4px 20px rgba(34, 211, 238, .2);
}
.kpi-compact .kpi-icon{
  color: var(--accent);
  flex-shrink: 0;
  width: 24px; /* Ancho consistente */
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.kpi-data{
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.kpi-compact .kpi-value{
  font-size: 1.5rem; 
  font-weight: 800; 
  color: var(--accent);
  line-height: 1.1; 
  margin: 0;
}
.kpi-compact .kpi-label{
  font-size: 0.8rem; 
  color: var(--muted); 
  text-transform: uppercase; 
  letter-spacing: 0.5px;
  margin-top: 2px;
  font-weight: 600;
}

/* Executive Summary - Convierte */
.executive-summary{
  display: flex; 
  flex-direction: column; 
  gap: 16px;
}
.executive-summary h3{
  margin: 0; 
  font-size: 1.2rem; 
  color: #fff; 
  font-weight: 600;
  border-bottom: 2px solid rgba(34,211,238,.3);
  padding-bottom: 8px;
}
.executive-summary p{
  margin: 0; 
  font-size: 1rem; 
  color: #e2e8f0; 
  line-height: 1.6;
  max-width: 500px;
}
.social-proof{
  display: flex; 
  gap: 16px; 
  flex-wrap: wrap;
}
.client-badge, .industry-badge{
  display: flex; 
  align-items: center; 
  gap: 8px;
  padding: 8px 12px;
  background: rgba(167,139,250,.1);
  border: 1px solid rgba(167,139,250,.2);
  border-radius: 8px;
  font-size: 0.85rem;
  color: #c4b5fd;
  font-weight: 500;
}
.client-badge svg, .industry-badge svg{
  opacity: 0.7;
}

/* CTA Estratégico Hero */
.hero-cta{
  margin-top: 8px;
}
.cta-subtle{
  display: inline-flex; 
  align-items: center; 
  gap: 8px;
  padding: 10px 16px;
  background: linear-gradient(135deg, rgba(34,211,238,.12), rgba(167,139,250,.08));
  border: 1px solid rgba(34,211,238,.25);
  border-radius: 12px;
  color: #22d3ee;
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(4px);
}
.cta-subtle:hover{
  background: linear-gradient(135deg, rgba(34,211,238,.18), rgba(167,139,250,.12));
  border-color: rgba(34,211,238,.4);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(34,211,238,.2);
}
.cta-subtle svg{
  transition: transform 0.3s ease;
}
.cta-subtle:hover svg{
  transform: translate(2px, -2px);
}

/* === NUEVA ESTRUCTURA DE SECCIONES === */

/* Story Section - Contexto con tu estética */
.block--context{
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  padding: 32px;
  margin-bottom: 32px;
  transition: all 0.4s ease;
}
.block--context:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
}
.story-header{
  margin-bottom: 24px;
}
.story-meta{
  display: flex; gap: 16px; margin-bottom: 12px;
}
.project-type, .timeline{
  padding: 6px 14px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  font-size: 0.8rem;
  color: var(--accent);
  font-weight: 600;
}
.story-content{
  display: grid; grid-template-columns: 1fr 1fr; gap: 32px;
}
.challenge-summary, .solution-preview{
  padding: 20px;
  background: var(--glass);
  border-radius: var(--radius);
  border: 1px solid var(--stroke);
  transition: all 0.3s ease;
}
.challenge-summary{
  border-left: 3px solid var(--destructive);
}
.challenge-summary:hover{
  border-left-color: var(--destructive);
  background: rgba(239, 68, 68, .04);
}
.solution-preview{
  border-left: 3px solid var(--accent);
}
.solution-preview:hover{
  border-left-color: var(--accent);
  background: rgba(34,211,238,.04);
}
.solution-preview h3{
  margin: 0 0 12px; font-size: 1.1rem; color: var(--accent);
}

/* Solution Section - Técnica con tu estética */
.solution-header{
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
}
.tech-stack{
  display: flex; gap: 8px; flex-wrap: wrap;
}
.tech-badge{
  padding: 6px 12px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  font-size: 0.8rem;
  color: var(--accent);
  font-weight: 600;
  transition: all 0.3s ease;
}
.tech-badge:hover{
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateY(-1px);
}
.solution-grid{
  display: grid; grid-template-columns: 1fr 1fr; gap: 32px;
}
.approach-items{
  list-style: none; padding: 0; margin: 0;
  display: flex; flex-direction: column; gap: 16px;
}
.approach-item{
  display: flex; align-items: flex-start; gap: 12px;
  padding: 16px;
  background: var(--glass);
  border-radius: var(--radius);
  border: 1px solid var(--stroke);
  transition: all 0.3s ease;
}
.approach-item:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
  transform: translateX(4px);
}
.approach-icon{
  width: 28px; height: 28px;
  background: var(--accent);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--background); font-weight: 700; font-size: 0.9rem;
  flex-shrink: 0;
}
.features-grid{
  display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
}
.feature-card{
  display: flex; align-items: center; gap: 10px;
  padding: 12px;
  background: var(--glass);
  border-radius: var(--radius);
  border: 1px solid var(--stroke);
  font-size: 0.9rem;
  transition: all 0.3s ease;
}
.feature-card:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
}
.feature-icon{
  color: var(--accent); flex-shrink: 0;
}

/* Results Section - Showcase con tu estética */
.results-header{
  text-align: center; margin-bottom: 32px;
}
.results-subtitle{
  margin: 8px 0 0; color: var(--muted); font-size: 1rem;
}
.results-showcase{
  display: grid; grid-template-columns: 1fr auto; gap: 32px; align-items: center;
}
.impact-narrative{
  font-size: 1.1rem; line-height: 1.6; color: var(--foreground-muted);
}
.impact-metrics{
  display: flex; flex-direction: column; gap: 16px; min-width: 200px;
}
.metric-highlight{
  padding: 16px 20px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  text-align: center;
  transition: all 0.3s ease;
}
.metric-highlight:hover{
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(34, 211, 238, .15);
}
.metric-value{
  font-size: 1.8rem; font-weight: 900; color: var(--accent); line-height: 1;
}
.metric-label{
  font-size: 0.85rem; color: var(--muted); margin-top: 4px;
  text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;
}

/* Social Proof - Testimonial con tu estética */
.social-proof-header{
  text-align: center; margin-bottom: 32px;
}
.proof-subtitle{
  margin: 8px 0 0; color: var(--muted); font-size: 1rem;
}
.testimonial-card{
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  padding: 32px;
  position: relative;
  transition: all 0.4s ease;
}
.testimonial-card:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(34, 211, 238, .15);
}
.testimonial-content{
  margin-bottom: 24px; position: relative;
}
.quote-mark{
  position: absolute; top: -10px; left: -10px;
  font-size: 4rem; color: var(--accent);
  font-family: serif; line-height: 1; opacity: 0.4;
}
.quote{
  font-size: 1.2rem; line-height: 1.6; color: var(--foreground);
  font-style: italic; margin: 0; padding-left: 20px;
}
.testimonial-author{
  display: flex; align-items: center; gap: 16px;
}
.author-avatar .avatar, .author-avatar .avatar-placeholder{
  width: 56px; height: 56px;
  border-radius: var(--radius);
  border: 2px solid var(--stroke);
}
.author-name{
  color: var(--foreground); font-size: 1.1rem; font-weight: 600;
}
.author-role{
  color: var(--muted); font-size: 0.9rem; margin-top: 2px;
}

/* Gallery Header */
.gallery-header{
  text-align: center; margin-bottom: 32px;
}
.gallery-subtitle{
  margin: 8px 0 0; color: var(--muted); font-size: 1rem;
}

/* CTA Zone - Conversion Optimizada con tu estética */
.cta-zone{
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  padding: 40px;
  margin: 48px 0;
  text-align: center;
  transition: all 0.4s ease;
}
.cta-zone:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
  box-shadow: 0 12px 32px rgba(34, 211, 238, .1);
}
.cta-container{
  max-width: 800px; margin: 0 auto;
}
.cta-header h2{
  margin: 0 0 12px; font-size: 2rem; color: var(--foreground);
}
.cta-subtitle{
  color: var(--muted); font-size: 1.1rem; margin: 0 0 32px;
}
.cta-stats{
  display: flex; justify-content: center; gap: 48px; margin-bottom: 32px;
}
.stat-item{
  text-align: center;
}
.stat-value{
  font-size: 2.2rem; font-weight: 900; color: var(--accent); line-height: 1;
}
.stat-label{
  font-size: 0.9rem; color: var(--muted); margin-top: 4px;
  text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;
}
.cta-actions{
  display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;
}
.btn.cta{
  padding: 16px 32px; font-size: 1.1rem; font-weight: 600;
  border-radius: var(--radius); text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: inline-flex; align-items: center; gap: 8px;
}
.btn.cta.primary{
  background: linear-gradient(135deg, #22d3ee, #a78bfa);
  color: #0b1220; box-shadow: 0 4px 16px rgba(34,211,238,.3);
}
.btn.cta.primary:hover{
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(34,211,238,.4);
}
.btn.cta.secondary{
  background: rgba(255,255,255,.08); color: #fff;
  border: 1px solid rgba(255,255,255,.2);
}
.btn.cta.secondary:hover{
  background: rgba(255,255,255,.12);
  transform: translateY(-1px);
}

/* === ESTILOS ESTANDARIZADOS PARA TODAS LAS SECCIONES === */
/* Section Header - Patrón consistente */
.section-header{
  margin-bottom: 32px;
  text-align: center;
}
.section-meta{
  display: flex; 
  gap: 8px; 
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 16px;
}
.section-tag{
  padding: 6px 14px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  font-size: 0.8rem;
  color: var(--accent);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}
.section-tag.secondary{
  color: var(--muted);
  background: rgba(255,255,255,.02);
}
.section-tag:hover{
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateY(-1px);
}
.section-title{
  margin: 0 0 12px;
  font-size: 2.2rem;
  font-weight: 800;
  color: var(--foreground);
  text-align: center;
}
.section-subtitle{
  margin: 0;
  font-size: 1.1rem;
  color: var(--muted);
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.5;
}

/* Section Content - Contenedor estándar (sin estilos base) */

/* Mejorar testimonial card */
.testimonial-card{
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  padding: 32px;
  transition: all 0.4s ease;
  position: relative;
  max-width: 800px;
  margin: 0 auto;
}
.testimonial-card:hover{
  background: rgba(34,211,238,.04);
  border-color: var(--accent);
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(34, 211, 238, .15);
}

/* ------ NAV SECCIONES ------ */
.section-nav{
  position: sticky; top: 0; z-index: 20;
  background: linear-gradient(180deg, rgba(11,18,32,.90), rgba(11,18,32,.80));
  border-bottom: 1px solid rgba(255,255,255,.12);
  backdrop-filter: blur(8px);
}
.section-nav ul{ display:flex; flex-wrap:wrap; gap:8px; padding:12px 0; margin:0; list-style:none }
.section-nav a{
  display:inline-block; padding:8px 16px; border-radius:24px; color:#cfd2ff; text-decoration:none; font-size:.92rem;
  border:1px solid rgba(255,255,255,.16); background: rgba(255,255,255,.05);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.section-nav a:hover{ color:#0b1220; background: linear-gradient(90deg, #22d3ee, #a78bfa); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34,211,238,.2); }
.section-nav a.active{ color:#0b1220; font-weight:600; background: linear-gradient(90deg, #22d3ee, #a78bfa); border-color: transparent; box-shadow: 0 2px 8px rgba(34,211,238,.3); }

/* ------ LAYOUT ------ */
.grid{
  display:grid; grid-template-columns: 1fr 320px; gap:22px;
}
.main{ min-width:0 }
.side{ position:sticky; top:80px; align-self:start; display:grid; gap:14px }

/* ------ CARDS & ELEMENTS ------ */
.card{
  background: var(--glass, rgba(255,255,255,.06));
  border:1px solid var(--stroke, rgba(255,255,255,.16));
  border-radius: 16px; padding:16px;
  box-shadow: 0 8px 32px rgba(0,0,0,.3);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.card:hover{
  border-color: rgba(255,255,255,.24);
  box-shadow: 0 12px 40px rgba(0,0,0,.35);
  transform: translateY(-2px);
}
.card h3{ margin:6px 0 8px; font-size:1.05rem; color:#fff }
.quick-nav ul{ list-style:none; padding:0; margin:0; display:grid; gap:6px }
.quick-nav a{ color:#cfd2ff; text-decoration:none; border-bottom:1px dashed rgba(255,255,255,.2) }
.quick-nav a.active, .quick-nav a:hover{ color:#22d3ee }

/* KPIs */
.kpis{
  display:grid; grid-template-columns: repeat(3, 1fr); gap:16px; margin-bottom: 24px;
}
.kpi{
  position: relative;
  background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
  border:1px solid var(--stroke, rgba(255,255,255,.16));
  border-radius: 16px; padding:20px;
  text-align:center;
  box-shadow: 0 12px 40px rgba(0,0,0,.15);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: help;
}
.kpi:hover{
  transform: translateY(-4px);
  border-color: rgba(34,211,238,.35);
  box-shadow: 0 20px 60px rgba(34,211,238,.12);
}
.kpi-icon{ width:32px; height:32px; margin: 0 auto 8px; color:#22d3ee; transition: transform 0.3s ease }
.kpi:hover .kpi-icon{ transform: scale(1.1) }
.kpi-value{ font-size:1.8rem; font-weight:800; color:#fff; transition: color 0.3s ease }
.kpi-value.animated{ font-variant-numeric: tabular-nums }
.kpi-label{ color: var(--muted, #cfd2ffb0); font-size:.95rem; margin-top:4px }
.kpi-tooltip{
  position: absolute; bottom: -44px; left: 50%; transform: translateX(-50%);
  background: rgba(11,18,32,.95); color: #e9ecff; padding: 8px 12px; border-radius: 8px;
  font-size: .85rem; white-space: nowrap; max-width: 280px; text-align: left;
  border: 1px solid rgba(255,255,255,.12);
  box-shadow: 0 8px 32px rgba(0,0,0,.4);
  z-index: 10;
}
.kpi-tooltip::before{
  content: ''; position: absolute; top: -6px; left: 50%; transform: translateX(-50%);
  border: 6px solid transparent; border-bottom-color: rgba(11,18,32,.95);
}

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
/* Responsive Hero - UX Optimizado */
@media (max-width: 900px){
  .hero-results{
    grid-template-columns: 1fr;
    gap: 24px;
    padding: 24px;
  }
  .results-kpis{
    flex-direction: row;
    justify-content: space-between;
    min-width: auto;
  }
  .kpi-compact{
    flex: 1;
    flex-direction: column;
    text-align: center;
    gap: 8px;
  }
}

@media (max-width: 900px){
  .story-content, .solution-grid, .results-showcase{
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .features-grid{
    grid-template-columns: 1fr;
  }
  .cta-stats{
    gap: 24px;
  }
}

@media (max-width: 700px){
  .cover-wrap{
    min-height: 100vh;
  }
  .hero-inner{
    padding: 16px 0;
  }
  .hero-content{
    gap: 20px;
    min-height: 60vh;
  }
  .results-kpis{
    flex-direction: column;
    gap: 12px;
  }
  .kpi-compact{
    flex-direction: row;
    text-align: left;
  }
  .executive-summary h3{
    font-size: 1.1rem;
  }
  .executive-summary p{
    font-size: 0.95rem;
  }
  
  /* Nuevas secciones responsive */
  .block--context{
    padding: 24px;
  }
  .story-meta{
    flex-direction: column;
    gap: 8px;
  }
  .solution-header{
    flex-direction: column;
    align-items: flex-start;
  }
  .approach-items{
    gap: 12px;
  }
  .approach-item{
    padding: 12px;
  }
  .testimonial-card{
    padding: 24px;
  }
  .quote{
    font-size: 1.1rem;
  }
  .cta-zone{
    padding: 32px 20px;
    margin: 32px 0;
  }
  .cta-header h2{
    font-size: 1.5rem;
  }
  .cta-stats{
    flex-direction: column;
    gap: 16px;
  }
  .cta-actions{
    flex-direction: column;
    align-items: center;
  }
  .btn.cta{
    width: 100%;
    max-width: 280px;
  }
  .kpis{ grid-template-columns:1fr }
  .gallery{ grid-template-columns: repeat(2, 1fr) }
  .gallery figure, .gallery figure.span-2{ grid-column: span 2 }
}

/* Sticky CTA */
.sticky-cta{
  position: fixed; bottom: 0; left: 0; right: 0; z-index: 30;
  background: linear-gradient(90deg, rgba(11,18,32,.95), rgba(11,18,32,.98));
  border-top: 1px solid rgba(255,255,255,.12);
  backdrop-filter: blur(12px) saturate(120%);
  box-shadow: 0 -8px 32px rgba(0,0,0,.4);
}
.sticky-cta-inner{
  display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 12px 0;
}
.sticky-cta-text strong{ display: block; color: #fff; font-size: .95rem; font-weight: 700 }
.sticky-cta-text span{ color: var(--muted, #cfd2ffb0); font-size: .9rem }
.btn.sticky-primary{
  padding: 10px 16px; border-radius: 10px; background: linear-gradient(90deg, #22d3ee, #a78bfa);
  color: #0b1220; font-weight: 700; text-decoration: none; white-space: nowrap;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn.sticky-primary:hover{ transform: translateY(-2px); box-shadow: 0 8px 24px rgba(34,211,238,.25) }

/* Sticky CTA animations */
.sticky-cta-enter-active, .sticky-cta-leave-active{ transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) }
.sticky-cta-enter-from{ transform: translateY(100%); opacity: 0 }
.sticky-cta-leave-to{ transform: translateY(100%); opacity: 0 }

@media (max-width: 700px){
  .sticky-cta-inner{ flex-direction: column; gap: 8px; text-align: center }
  .btn.sticky-primary{ width: 100% }
}

/* Scroll-triggered animations - Más dramáticas */
.animate-section {
  opacity: 0;
  transform: translateY(48px) scale(0.95);
  filter: blur(2px);
  transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.animate-section.animate-in {
  opacity: 1;
  transform: translateY(0) scale(1);
  filter: blur(0px);
}

/* Hero Results animation override */
.hero-results.animate-section {
  transform: translateY(32px) scale(0.98);
  transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.hero-results.animate-section.animate-in {
  transform: translateY(0) scale(1);
}

/* Staggered animation delays for child elements */
.animate-section .kpi:nth-child(1) { 
  transition-delay: 0.2s; 
  transition-duration: 0.6s;
}
.animate-section .kpi:nth-child(2) { 
  transition-delay: 0.4s; 
  transition-duration: 0.6s;
}
.animate-section .kpi:nth-child(3) { 
  transition-delay: 0.6s; 
  transition-duration: 0.6s;
}

.animate-section .timeline-item:nth-child(odd) { 
  transition-delay: 0.2s; 
}
.animate-section .timeline-item:nth-child(even) { 
  transition-delay: 0.4s; 
}

/* Accesibilidad */
.sr-only{ position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0 }
.section a:focus-visible, .links a:focus-visible{ outline:2px solid #22d3ee; outline-offset:2px }
</style>
