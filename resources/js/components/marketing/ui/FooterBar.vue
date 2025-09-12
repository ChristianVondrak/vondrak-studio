<template>
  <footer class="footer">
    <BaseContainer>
      <div class="footer-grid">
        <div class="brand">
          <div class="logo">VS</div>
          <div>
            <div class="brand-name">Vondrak Studio</div>
            <div class="tag">Sitios web que convierten</div>
          </div>
        </div>

        <nav class="links" aria-label="footer">
          <a href="#work">Portafolio</a>
          <a href="#services">Servicios</a>
          <a href="#contact">Contacto</a>
        </nav>
      </div>

      <div class="bottom">
        <p class="muted">© {{ new Date().getFullYear() }} Vondrak Studio</p>
        <div class="social">
          <a href="/" aria-label="twitter" class="icon" title="Twitter">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 5.92c-.63.28-1.31.47-2.02.56.73-.44 1.29-1.13 1.55-1.96-.69.41-1.46.71-2.28.87C18.65 4.62 17.66 4 16.54 4c-1.8 0-3.26 1.46-3.26 3.26 0 .26.03.52.08.77C10.2 8 7.21 6.35 5.17 3.75c-.29.5-.45 1.08-.45 1.7 0 1.17.6 2.2 1.52 2.8-.56-.02-1.09-.17-1.55-.42v.04c0 1.59 1.13 2.92 2.63 3.22-.28.08-.57.12-.87.12-.21 0-.41-.02-.6-.06.41 1.27 1.6 2.2 3.01 2.22C7.57 18.3 6.18 19 4.64 19c-.32 0-.63-.02-.93-.06C5.38 20 6.86 20.66 8.48 20.66 16.53 20.66 20.24 14.08 20.24 8.16c0-.2 0-.39-.01-.58.52-.37.96-.83 1.31-1.35z" fill="currentColor"/></svg>
          </a>
          <a href="/" aria-label="github" class="icon" title="GitHub">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56 0-.28-.01-1.02-.02-2-3.2.7-3.88-1.54-3.88-1.54-.53-1.35-1.3-1.71-1.3-1.71-1.06-.72.08-.71.08-.71 1.17.08 1.79 1.2 1.79 1.2 1.04 1.78 2.72 1.27 3.38.97.11-.75.41-1.27.75-1.56-2.55-.29-5.23-1.28-5.23-5.7 0-1.26.45-2.28 1.19-3.09-.12-.3-.52-1.53.11-3.18 0 0 .97-.31 3.18 1.18.92-.26 1.9-.39 2.88-.39.98 0 1.96.13 2.88.39 2.2-1.49 3.17-1.18 3.17-1.18.63 1.65.23 2.88.11 3.18.74.81 1.19 1.83 1.19 3.09 0 4.43-2.69 5.4-5.25 5.68.43.37.82 1.1.82 2.22 0 1.6-.01 2.89-.01 3.28 0 .31.21.68.8.56C20.71 21.39 24 17.08 24 12c0-6.27-5.23-11.5-12-11.5z" fill="currentColor"/></svg>
          </a>
          <a href="/" aria-label="instagram" class="icon" title="Instagram">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 6.5a4 4 0 1 0 0 8 4 4 0 0 0 0-8zm5-.75a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5z" fill="currentColor"/></svg>
          </a>
          <a href="/" aria-label="tiktok" class="icon" title="TikTok">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z" fill="currentColor"/></svg>
          </a>
        </div>
      </div>
    </BaseContainer>
  </footer>
</template>

<script setup lang="ts">
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'
</script>

<style scoped src="./FooterBar.css"></style>
