<template>
  <div>
    <Navbar />
    <main>
      <slot />
    </main>
    <FooterBar />
  </div>
</template>

<script setup lang="ts">
import Navbar from '@/components/marketing/ui/Navbar.vue'
import FooterBar from '@/components/marketing/ui/FooterBar.vue'
</script>
