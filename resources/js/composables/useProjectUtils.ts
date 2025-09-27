// Tipos
export interface Project {
  title: string
  excerpt?: string
  client: string
  industry: string
  role?: string
  stack: string[]
  timeline?: Array<{ label: string; when: string }>
  live?: string
  repo?: string
}

// Composable para utilidades de proyecto
export function useProjectUtils() {
  // Compartir o copiar URL
  const shareOrCopy = async () => {
    const data = { 
      title: document.title,
      text: 'Caso de estudio',
      url: window.location.href 
    }
    
    try {
      const nav = navigator as any
      if (typeof nav.share === 'function') {
        return await nav.share(data)
      }
    } catch {
      // Continúa al fallback
    }
    
    try {
      await navigator.clipboard.writeText(window.location.href)
      showToast('Enlace copiado')
    } catch {
      showToast('No se pudo copiar')
    }
  }

  // Volver atrás
  const goBack = () => {
    if (window.history.length > 1) {
      window.history.back()
    } else {
      window.location.href = '/'
    }
  }

  // Toast temporal
  const showToast = (message: string) => {
    const toast = document.createElement('div')
    toast.className = 'toast'
    toast.textContent = message
    document.body.appendChild(toast)
    
    setTimeout(() => toast.classList.add('show'), 10)
    setTimeout(() => {
      toast.classList.remove('show')
      setTimeout(() => toast.remove(), 300)
    }, 1600)
  }

  // Generar iniciales para avatar
  const initials = (name: string): string => {
    return name
      .split(' ')
      .map(word => word[0])
      .join('')
      .substring(0, 2)
      .toUpperCase()
  }

  // Estilo para avatar placeholder
  const avatarStyle = (name: string) => {
    const colors = [
      ['#22d3ee', '#a78bfa'],
      ['#f59e0b', '#ef4444'], 
      ['#10b981', '#3b82f6'],
      ['#8b5cf6', '#ec4899'],
      ['#f97316', '#84cc16']
    ]
    
    const sum = name.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)
    const colorPair = colors[sum % colors.length]
    
    return {
      background: `linear-gradient(135deg, ${colorPair[0]}, ${colorPair[1]})`,
      color: '#0b1220'
    }
  }

  // Duración del proyecto
  const getProjectDuration = (timeline?: Array<{ label: string; when: string }>) => {
    if (!timeline?.length) return 'Proyecto ágil'
    return `${timeline.length} semanas`
  }

  return {
    shareOrCopy,
    goBack,
    showToast,
    initials,
    avatarStyle,
    getProjectDuration,
  }
}
