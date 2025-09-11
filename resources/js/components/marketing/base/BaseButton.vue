<template>
  <a :href="href" class="btn" :class="{ 'btn--ghost': ghost }"><slot /></a>
</template>

<script setup lang="ts">
defineProps<{ href?: string; ghost?: boolean }>()
</script>

<style scoped>
.btn{
  display:inline-block; padding:10px 14px; border-radius:10px; text-decoration:none;
  border:1px solid rgba(255,255,255,.2); font-weight:700;
  background: var(--accent, #22d3ee); color:#0b1220;
}
.btn--ghost{
  background: transparent; color:#fff; border-color: rgba(255,255,255,.4);
}
</style>
