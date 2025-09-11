<template>
  <div ref="el" class="vanta-globe-container"></div>
</template>
<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const el = ref<HTMLElement | null>(null)
let effect: any = null
let cancelled = false

declare global {
  interface Window { VANTA?: any }
}

function waitForVanta(timeout = 6000): Promise<void> {
  const start = performance.now()
  return new Promise((resolve, reject) => {
    const tick = () => {
      if (cancelled) return reject(new Error('cancelled'))
      if ((window as any).VANTA?.GLOBE && (window as any).THREE) return resolve()
      if (performance.now() - start > timeout) return reject(new Error('timeout'))
      requestAnimationFrame(tick)
    }
    tick()
  })
}

onMounted(async () => {
  if (!el.value) return

  if (el.value.clientHeight < 200) el.value.style.minHeight = '100vh'

  try {
    await waitForVanta()
    if (!el.value || cancelled) return

    effect = (window as any).VANTA.GLOBE({
      el: el.value,
      backgroundColor: 0x0b1220,
      color: 0x22d3ee,
      color2: 0xa78bfa,
      size: 1.4,
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.0,
      minWidth: 200.0,
      scale: 1.0,
      scaleMobile: 1.0,
    })
  } catch {
    // fail silently
  }
})

onUnmounted(() => {
  cancelled = true
  if (effect?.destroy) {
    effect.destroy()
    effect = null
  }
})
</script>

<style scoped>
.vanta-globe-container{
  position: absolute;
  inset: 0;
  z-index: -1;
  width: 100%;
  height: 100%;
  min-height: 100vh;
}
</style>
