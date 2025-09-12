import { ref, onMounted, onBeforeUnmount } from 'vue'

export function useNavbarScroll(threshold = 10) {
  const isSolid = ref(false)

  const onScroll = () => {
    if (typeof window === 'undefined') return
    isSolid.value = window.scrollY > threshold
  }

  onMounted(() => {
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
  })

  onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll)
  })

  return { isSolid }
}
