<template>
  <aside class="project-aside" aria-label="Resumen del proyecto">
    <!-- Navegación rápida -->
    <nav v-if="sections?.length" class="aside-card aside-nav" aria-label="Navegación de secciones">
      <h3 class="aside-title">Contenido</h3>
      <ul>
        <li v-for="s in sections" :key="s.id">
          <button :class="['nav-link', { active: activeSection === s.id }]" @click="onNavigate(s.id)">{{ s.label }}</button>
        </li>
      </ul>
    </nav>

    <!-- Overview -->
    <div class="aside-card overview" aria-label="Ficha del proyecto">
      <h3 class="aside-title">Resumen</h3>
      <ul class="meta-list">
        <li><strong>Cliente</strong><span>{{ project.client }}</span></li>
        <li><strong>Industria</strong><span>{{ project.industry }}</span></li>
        <li v-if="project.role"><strong>Rol</strong><span>{{ project.role }}</span></li>
  <li v-if="project.timeline?.length"><strong>Hitos</strong><span>{{ project.timeline.length }}</span></li>
      </ul>
    </div>

    <!-- KPIs principales -->
    <div v-if="project.kpis?.length" class="aside-card kpis" aria-label="Indicadores clave">
      <h3 class="aside-title">KPIs</h3>
      <div class="kpi-list">
        <div v-for="k in topKpis" :key="k.label" class="kpi-item" :title="k.tooltip">
          <div class="kpi-value">{{ k.value }}</div>
          <div class="kpi-label">{{ k.label }}</div>
        </div>
      </div>
    </div>

    <!-- Stack -->
    <div v-if="project.stack?.length" class="aside-card stack" aria-label="Stack tecnológico">
      <h3 class="aside-title">Stack</h3>
      <ul class="stack-list">
        <li v-for="tech in limitedStack" :key="tech">{{ tech }}</li>
      </ul>
      <button v-if="project.stack.length > maxStack" class="more-stack" @click="showAllStack = !showAllStack" :aria-expanded="showAllStack">
        {{ showAllStack ? 'Ver menos' : `+${project.stack.length - maxStack} más` }}
      </button>
    </div>

    <!-- Etiquetas -->
    <div v-if="project.tags?.length" class="aside-card tags" aria-label="Etiquetas del proyecto">
      <h3 class="aside-title">Etiquetas</h3>
      <ul class="tags-list">
        <li v-for="tag in project.tags" :key="tag">{{ tag }}</li>
      </ul>
    </div>

    <!-- Acciones -->
    <div class="aside-card actions" aria-label="Acciones rápidas">
      <button class="btn primary" @click="goToContact">Solicitar presupuesto</button>
  <button class="btn ghost" @click="emit('share')">Compartir</button>
      <a v-if="project.live" class="ext-link" :href="project.live" target="_blank" rel="noopener">Ver sitio</a>
      <a v-if="project.repo" class="ext-link" :href="project.repo" target="_blank" rel="noopener">Ver código</a>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import type { Project } from '@/composables/useProjectUtils'

interface SectionLink { id: string; label: string }
interface Props {
  project: Project & { kpis?: Array<{ label: string; value: string; tooltip?: string }>; stack: string[]; timeline?: Array<{ label: string; when: string }>; tags?: string[] }
  sections?: SectionLink[]
  activeSection?: string
}
const props = defineProps<Props>()

const emit = defineEmits<{ (e: 'navigate', id: string): void; (e: 'share'): void }>()

const maxStack = 5
const showAllStack = ref(false)
const limitedStack = computed(() => showAllStack.value ? props.project.stack : props.project.stack.slice(0, maxStack))
const topKpis = computed(() => props.project.kpis?.slice(0, 2) || [])

const onNavigate = (id: string) => emit('navigate', id)
const goToContact = () => { window.location.href = '/#contact' }
</script>

<style scoped>
.project-aside { display: grid; gap: 14px; position: sticky; top: 80px; align-self: start }
.aside-card { background: var(--glass); border: 1px solid var(--stroke); border-radius: var(--radius); padding: 16px; display: flex; flex-direction: column; gap: 12px }
.aside-title { margin: 0; font-size: .92rem; letter-spacing: .5px; text-transform: uppercase; font-weight: 700; color: var(--muted); }

/* Nav */
.aside-nav ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 6px }
.nav-link { width: 100%; text-align: left; background: rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.12); color:#cfd2ff; padding:8px 10px; border-radius:8px; cursor:pointer; font-size:.8rem; transition:.25s }
.nav-link:hover { background: rgba(255,255,255,.07) }
.nav-link.active { background: linear-gradient(90deg,#22d3ee,#a78bfa); color:#0b1220; font-weight:600; box-shadow:0 2px 8px rgba(34,211,238,.3); }

/* Meta */
.meta-list { list-style:none; margin:0; padding:0; display:grid; gap:8px; font-size:.8rem }
.meta-list li { display:flex; justify-content: space-between; gap:8px; border-top:1px dashed rgba(255,255,255,.08); padding-top:6px }
.meta-list li:first-of-type { border-top:none; padding-top:0 }
.meta-list strong { color: var(--foreground); font-weight:600 }
.meta-list span { color: var(--muted) }

/* KPIs */
.kpi-list { display:grid; gap:8px }
.kpi-item { background: rgba(255,255,255,.05); border:1px solid var(--stroke); border-radius:10px; padding:10px 12px; display:flex; flex-direction:column; gap:4px; transition:.25s }
.kpi-item:hover { border-color: var(--accent); background: rgba(34,211,238,.07) }
.kpi-value { font-size:1.1rem; font-weight:700; color: var(--accent); line-height:1 }
.kpi-label { font-size:.65rem; letter-spacing:.5px; text-transform:uppercase; color: var(--muted); font-weight:600 }

/* Stack */
.stack-list { list-style:none; padding:0; margin:0; display:flex; flex-wrap:wrap; gap:6px }
.stack-list li { font-size:.7rem; padding:6px 10px; background: rgba(255,255,255,.05); border:1px solid var(--stroke); border-radius:999px; color: var(--muted); font-weight:500 }
.more-stack { align-self:flex-start; background:none; border:none; color: var(--accent); font-size:.7rem; cursor:pointer; padding:0; }
.more-stack:hover { text-decoration:underline }

/* Acciones */
.actions { gap:8px }
.btn { width:100%; border:none; cursor:pointer; border-radius:10px; font-weight:600; font-size:.8rem; padding:10px 14px; display:inline-flex; align-items:center; justify-content:center; gap:6px; transition:.25s }
.btn.primary { background: linear-gradient(90deg,#22d3ee,#a78bfa); color:#0b1220; }
.btn.primary:hover { transform: translateY(-2px); box-shadow:0 6px 18px rgba(34,211,238,.35) }
.btn.ghost { background: rgba(255,255,255,.06); color:#cfd2ff; border:1px solid rgba(255,255,255,.15) }
.btn.ghost:hover { background: rgba(255,255,255,.1) }
.ext-link { font-size:.7rem; color: var(--muted); text-decoration:none; border-bottom:1px dashed rgba(255,255,255,.2); align-self:flex-start }
.ext-link:hover { color: var(--accent); border-bottom-color: var(--accent) }
</style>
