<template>
  <div class="project-kpi" :class="{ 'has-tooltip': kpi.tooltip }" :title="kpi.tooltip">
    <div class="kpi-icon" v-html="getKpiIcon(kpi)"></div>
    <div class="kpi-data">
      <div class="kpi-value">
        <template v-if="typeof animatedValue === 'number'">
          {{ animatedValue }}{{ kpi.value.replace(/[\d-]/g, '') }}
        </template>
        <template v-else>{{ kpi.value }}</template>
      </div>
      <div class="kpi-label">{{ kpi.label }}</div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface KPI {
  label: string
  value: string
  tooltip?: string
}

interface Props {
  kpi: KPI
  animatedValue?: number
}

defineProps<Props>()

const getKpiIcon = (kpi: KPI): string => {
  const label = kpi.label.toLowerCase()
  
  if (label.includes('tiempo') || label.includes('ciclo')) {
    return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M7 13l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`
  }
  
  if (label.includes('lcp') || label.includes('performance') || label.includes('core web vitals')) {
    return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>`
  }
  
  if (label.includes('adopción') || label.includes('usuarios')) {
    return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="8.5" cy="7" r="4" stroke="currentColor" stroke-width="2"/></svg>`
  }
  
  return `<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/></svg>`
}
</script>

<style scoped>
.project-kpi {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 18px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  min-height: 68px;
}

.project-kpi:hover {
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateX(6px);
  box-shadow: 0 4px 20px rgba(34, 211, 238, .2);
}

.kpi-icon {
  color: var(--accent);
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.kpi-data {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.kpi-value {
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--accent);
  line-height: 1.1;
  margin: 0;
}

.kpi-label {
  font-size: 0.8rem;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 2px;
  font-weight: 600;
}
</style>
