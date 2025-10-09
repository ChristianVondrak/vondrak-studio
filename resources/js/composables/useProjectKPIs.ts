import { ref, onMounted } from 'vue'

// Tipos
interface KPI {
  label: string
  value: string
  tooltip?: string
}

// Composable para manejo de KPIs con animaciones
export function useProjectKPIs(kpis: KPI[]) {
  const kpiCounters = ref<Record<string, number>>({})
  const kpiAnimated = ref<Record<string, boolean>>({})

  // Obtener icono basado en el tipo de KPI
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

  // Animar contador numérico
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
      
      if (progress < 1) {
        requestAnimationFrame(animate)
      }
    }
    
    requestAnimationFrame(animate)
  }

  // Observer para activar animaciones
  const createKpiObserver = () => {
    const options = { 
      root: null, 
      rootMargin: '0px', 
      threshold: 0.3 
    }
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          kpis.forEach((kpi) => {
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
    
    const kpiContainer = document.querySelector('.results-kpis')
    if (kpiContainer) {
      observer.observe(kpiContainer)
    }
  }

  onMounted(() => {
    createKpiObserver()
  })

  return {
    kpiCounters,
    getKpiIcon,
  }
}
