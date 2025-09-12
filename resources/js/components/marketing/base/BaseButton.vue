<template>
  <a :href="href" class="btn" :class="{ 'btn--ghost': ghost }"><slot /></a>
</template>

<script setup lang="ts">
defineProps<{ href?: string; ghost?: boolean }>()

</script>

<style scoped src="./BaseButton.css"></style>
