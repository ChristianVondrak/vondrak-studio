<template>
  <section 
    id="galeria" 
    class="block section-block" 
    v-if="displayImages.length" 
    v-reveal:up
  >
    <SectionHeader
      :tags="[
        { label: 'Visual', type: 'primary' as const },
        { label: `${displayImages.length} Capturas`, type: 'secondary' as const },
        { label: 'UI/UX', type: 'secondary' as const }
      ]"
      :title="title"
      :subtitle="subtitle"
      :centered="false"
    />
    
    <!-- Gallery Grid -->
    <div class="section-content">
      <div class="gallery-grid" :class="{ 'is-loading': isLoading }">
        <!-- Primera imagen (principal) -->
        <div 
          v-if="displayImages.length > 0"
          class="gallery-item gallery-item--main"
          @click="openLightbox(0)"
        >
          <div class="gallery-image">
            <img 
              :src="displayImages[0].src" 
              :alt="displayImages[0].caption || fallbackAlt"
              loading="eager"
              @load="onImageLoad(0)"
              @error="onImageError(0)"
            />
            <div class="gallery-overlay">
              <svg class="expand-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1" stroke="currentColor" stroke-width="2"/>
              </svg>
            </div>
          </div>
        </div>
        
        <!-- Columna derecha con imágenes secundarias -->
        <div class="gallery-secondary" v-if="displayImages.length > 1">
          <!-- Segunda imagen -->
          <div 
            v-if="displayImages[1]"
            class="gallery-item gallery-item--secondary"
            @click="openLightbox(1)"
          >
            <div class="gallery-image">
              <img 
                :src="displayImages[1].src" 
                :alt="displayImages[1].caption || fallbackAlt"
                loading="lazy"
                @load="onImageLoad(1)"
                @error="onImageError(1)"
              />
              <div class="gallery-overlay">
                <svg class="expand-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1" stroke="currentColor" stroke-width="2"/>
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Tercera imagen -->
          <div 
            v-if="displayImages[2]"
            class="gallery-item gallery-item--secondary"
            @click="openLightbox(2)"
          >
            <div class="gallery-image">
              <img 
                :src="displayImages[2].src" 
                :alt="displayImages[2].caption || fallbackAlt"
                loading="lazy"
                @load="onImageLoad(2)"
                @error="onImageError(2)"
              />
              <div class="gallery-overlay">
                <svg class="expand-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1" stroke="currentColor" stroke-width="2"/>
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Cuarta imagen con contador de restantes -->
          <div 
            v-if="displayImages[3]"
            class="gallery-item gallery-item--secondary gallery-item--more"
            @click="openLightbox(3)"
          >
            <div class="gallery-image">
              <img 
                :src="displayImages[3].src" 
                :alt="displayImages[3].caption || fallbackAlt"
                loading="lazy"
                @load="onImageLoad(3)"
                @error="onImageError(3)"
              />
              <div class="gallery-overlay gallery-overlay--count">
                <div class="more-count" v-if="displayImages.length > 4">
                  +{{ displayImages.length - 4 }}
                </div>
                <svg class="expand-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M15 3h6v6M14 10l6.1-6.1M9 21H3v-6M10 14l-6.1 6.1" stroke="currentColor" stroke-width="2"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <Teleport to="body">
      <Transition name="lightbox">
        <div 
          v-if="isLightboxOpen && displayImages.length" 
          class="lightbox" 
          role="dialog" 
          aria-modal="true" 
          aria-label="Visor de imágenes" 
          @keydown="handleKeydown"
          @click.self="closeLightbox"
          tabindex="-1" 
          ref="lightboxRef"
        >
          <!-- Background overlay -->
          <div class="lightbox__overlay" @click="closeLightbox"></div>
          
          <!-- Main content -->
          <div class="lightbox__content">
            <!-- Close button -->
            <button 
              class="lightbox__close" 
              @click="closeLightbox" 
              aria-label="Cerrar visor"
              type="button"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
              </svg>
            </button>

            <!-- Navigation buttons -->
            <button 
              v-if="displayImages.length > 1"
              class="lightbox__nav lightbox__nav--prev" 
              @click="previousImage" 
              :aria-label="`Anterior (${currentIndex + 1} de ${displayImages.length})`"
              :disabled="currentIndex === 0 && !allowLoop"
              type="button"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M15 18L9 12l6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <button 
              v-if="displayImages.length > 1"
              class="lightbox__nav lightbox__nav--next" 
              @click="nextImage" 
              :aria-label="`Siguiente (${currentIndex + 1} de ${displayImages.length})`"
              :disabled="currentIndex === displayImages.length - 1 && !allowLoop"
              type="button"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <!-- Image container -->
            <div class="lightbox__image-container">
              <img 
                :src="displayImages[currentIndex]?.src" 
                :alt="displayImages[currentIndex]?.caption || fallbackAlt"
                class="lightbox__image"
                @load="onLightboxImageLoad"
                @error="onLightboxImageError"
                ref="lightboxImageRef"
              />
              
              <!-- Loading state for lightbox -->
              <div v-if="lightboxImageLoading" class="lightbox__loading">
                <div class="loading-spinner loading-spinner--large"></div>
              </div>
            </div>

            <!-- Image counter and caption -->
            <div class="lightbox__info">
              <div v-if="displayImages.length > 1" class="lightbox__counter">
                {{ currentIndex + 1 }} de {{ displayImages.length }}
              </div>
              <div 
                v-if="displayImages[currentIndex]?.caption" 
                class="lightbox__caption"
              >
                {{ displayImages[currentIndex].caption }}
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount, nextTick, watch } from 'vue'
import SectionHeader from './SectionHeader.vue'

// Types
export interface GalleryImage {
  src: string
  caption?: string
  aspectRatio?: string
}

export interface ProjectGalleryProps {
  images?: GalleryImage[]
  title?: string
  subtitle?: string
  fallbackAlt?: string
  allowLoop?: boolean
  preloadCount?: number
}

// Props with defaults
const props = withDefaults(defineProps<ProjectGalleryProps>(), {
  images: () => [],
  title: 'Evidencia visual',
  subtitle: 'Capturas del producto en funcionamiento',
  fallbackAlt: 'Imagen del proyecto',
  allowLoop: true,
  preloadCount: 3
})

// Emits
const emit = defineEmits<{
  imageClick: [index: number, image: GalleryImage]
  lightboxOpen: [index: number]
  lightboxClose: []
  imageLoad: [index: number, success: boolean]
}>()

// Reactive state
const isLoading = ref(true)
const imageLoadStates = ref<boolean[]>([])
const isLightboxOpen = ref(false)
const currentIndex = ref(0)
const lightboxImageLoading = ref(false)

// Refs
const lightboxRef = ref<HTMLElement>()
const lightboxImageRef = ref<HTMLImageElement>()

// Computed properties  
const displayImages = computed<GalleryImage[]>(() => {
  return props.images
})



// Image loading handlers
const onImageLoad = (index: number) => {
  imageLoadStates.value[index] = true
  emit('imageLoad', index, true)
  
  // Check if all images are loaded
  if (imageLoadStates.value.every(Boolean)) {
    isLoading.value = false
  }
}

const onImageError = (index: number) => {
  imageLoadStates.value[index] = true // Still mark as "loaded" to remove placeholder
  emit('imageLoad', index, false)
  console.warn(`Failed to load gallery image at index ${index}`)
}

// Lightbox handlers
const openLightbox = (index: number) => {
  currentIndex.value = index
  isLightboxOpen.value = true
  lightboxImageLoading.value = true
  emit('lightboxOpen', index)
  emit('imageClick', index, displayImages.value[index])
  
  nextTick(() => {
    lightboxRef.value?.focus()
    preloadAdjacentImages(index)
  })
}

const closeLightbox = () => {
  isLightboxOpen.value = false
  lightboxImageLoading.value = false
  emit('lightboxClose')
}

const nextImage = () => {
  if (currentIndex.value < displayImages.value.length - 1) {
    currentIndex.value++
  } else if (props.allowLoop) {
    currentIndex.value = 0
  }
  lightboxImageLoading.value = true
  preloadAdjacentImages(currentIndex.value)
}

const previousImage = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
  } else if (props.allowLoop) {
    currentIndex.value = displayImages.value.length - 1
  }
  lightboxImageLoading.value = true
  preloadAdjacentImages(currentIndex.value)
}

const onLightboxImageLoad = () => {
  lightboxImageLoading.value = false
}

const onLightboxImageError = () => {
  lightboxImageLoading.value = false
  console.warn(`Failed to load lightbox image at index ${currentIndex.value}`)
}

// Keyboard navigation
const handleKeydown = (event: KeyboardEvent) => {
  switch (event.key) {
    case 'Escape':
      closeLightbox()
      break
    case 'ArrowLeft':
      event.preventDefault()
      previousImage()
      break
    case 'ArrowRight':
      event.preventDefault()
      nextImage()
      break
  }
}

// Preload adjacent images for better UX
const preloadAdjacentImages = (centerIndex: number) => {
  const toPreload = []
  
  for (let i = 1; i <= props.preloadCount; i++) {
    const nextIdx = centerIndex + i
    const prevIdx = centerIndex - i
    
    if (nextIdx < displayImages.value.length) toPreload.push(nextIdx)
    if (prevIdx >= 0) toPreload.push(prevIdx)
  }
  
  toPreload.forEach(index => {
    const img = new Image()
    img.src = displayImages.value[index].src
  })
}

// Initialize component
onMounted(() => {
  // Initialize load states
  imageLoadStates.value = new Array(displayImages.value.length).fill(false)
  
  if (displayImages.value.length === 0) {
    isLoading.value = false
  }
})

// Handle escape key globally when lightbox is open
const handleGlobalKeydown = (event: KeyboardEvent) => {
  if (isLightboxOpen.value && event.key === 'Escape') {
    closeLightbox()
  }
}

onMounted(() => {
  document.addEventListener('keydown', handleGlobalKeydown)
})

onBeforeUnmount(() => {
  document.removeEventListener('keydown', handleGlobalKeydown)
})

// Watch for changes in images prop
watch(() => props.images, (newImages) => {
  imageLoadStates.value = new Array(newImages.length).fill(false)
  isLoading.value = newImages.length > 0
}, { immediate: true })
</script>

<style scoped>
/* Gallery Grid */
.gallery-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 0.75rem;
  margin-top: 2rem;
  height: 400px;
  overflow: hidden;
}

@media (max-width: 768px) {
  .gallery-grid {
    grid-template-columns: 1fr;
    height: auto;
    max-height: none;
  }
}

.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.gallery-item:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.gallery-item--main {
  grid-row: span 3;
  height: 100%;
  max-height: 400px;
}

@media (max-width: 768px) {
  .gallery-item--main {
    grid-row: span 1;
    aspect-ratio: 16/9;
    max-height: 250px;
  }
}

.gallery-secondary {
  display: grid;
  grid-template-rows: repeat(3, 1fr);
  gap: 0.75rem;
}

@media (max-width: 768px) {
  .gallery-secondary {
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: 1fr;
  }
}

.gallery-item--secondary {
  aspect-ratio: 16/9;
}

/* Gallery Image */
.gallery-image {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-radius: 0.5rem;
  background: var(--surface-2);
}

.gallery-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-image img {
  transform: scale(1.1);
}

/* Image Placeholder */
.image-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--surface-3);
  border-radius: 0.75rem;
  min-height: 200px;
}

/* Loading Spinner */
.loading-spinner {
  width: 2rem;
  height: 2rem;
  border: 2px solid var(--surface-4);
  border-top: 2px solid var(--primary);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.loading-spinner--large {
  width: 3rem;
  height: 3rem;
  border-width: 3px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* Gallery Overlay */
.gallery-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s ease;
  border-radius: 0.5rem;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-overlay--count {
  flex-direction: column;
  gap: 0.5rem;
}

.more-count {
  color: white;
  font-size: 1.5rem;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.expand-icon {
  color: white;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}



/* Lightbox Styles */
.lightbox {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.9);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(4px);
}

.lightbox__overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: transparent;
  cursor: pointer;
}

.lightbox__content {
  position: relative;
  max-width: 90vw;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.lightbox__close {
  position: absolute;
  top: -3rem;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  width: 2.5rem;
  height: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: white;
  backdrop-filter: blur(8px);
  transition: all 0.2s ease;
  z-index: 10;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.lightbox__close:hover {
  background: rgba(0, 0, 0, 0.9);
  border-color: rgba(255, 255, 255, 0.4);
  transform: scale(1.05);
}

.lightbox__nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0, 0, 0, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  width: 3rem;
  height: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: white;
  backdrop-filter: blur(8px);
  transition: all 0.2s ease;
  z-index: 10;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.lightbox__nav:hover:not(:disabled) {
  background: rgba(0, 0, 0, 0.9);
  border-color: rgba(255, 255, 255, 0.4);
  transform: translateY(-50%) scale(1.05);
}

.lightbox__nav:disabled {
  opacity: 0.4;
  cursor: not-allowed;
  background: rgba(0, 0, 0, 0.4);
}

.lightbox__nav--prev {
  left: -4rem;
}

.lightbox__nav--next {
  right: -4rem;
}

@media (max-width: 768px) {
  .lightbox__nav--prev {
    left: 1rem;
  }
  
  .lightbox__nav--next {
    right: 1rem;
  }
  
  .lightbox__close {
    top: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.8);
    width: 2.75rem;
    height: 2.75rem;
  }
}

.lightbox__image-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 100%;
  max-height: 70vh;
}

.lightbox__image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  border-radius: 0.5rem;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.lightbox__loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.lightbox__info {
  margin-top: 1.5rem;
  text-align: center;
  color: white;
}

.lightbox__counter {
  font-size: 0.875rem;
  opacity: 0.8;
  margin-bottom: 0.5rem;
}

.lightbox__caption {
  font-size: 1rem;
  line-height: 1.4;
  max-width: 600px;
  color: white;
  text-shadow: 
    0 2px 4px rgba(0, 0, 0, 0.8),
    0 0 8px rgba(0, 0, 0, 0.6);
  background: rgba(0, 0, 0, 0.6);
  padding: 0.75rem 1rem;
  border-radius: 8px;
  backdrop-filter: blur(8px);
}

/* Transitions */
.lightbox-enter-active,
.lightbox-leave-active {
  transition: opacity 0.3s ease;
}

.lightbox-enter-from,
.lightbox-leave-to {
  opacity: 0;
}

.lightbox-enter-active .lightbox__content,
.lightbox-leave-active .lightbox__content {
  transition: transform 0.3s ease;
}

.lightbox-enter-from .lightbox__content,
.lightbox-leave-to .lightbox__content {
  transform: scale(0.9);
}

/* Loading state for gallery */
.gallery.is-loading {
  opacity: 0.7;
}

.gallery-item.is-loading {
  opacity: 0.5;
}
</style>
