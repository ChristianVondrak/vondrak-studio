<template>
  <div class="section-header" :class="{ 'text-center': centered }">
    <div v-if="tags.length" class="section-meta">
      <span v-for="tag in tags" :key="tag.label" :class="['section-tag', tag.type]">
        {{ tag.label }}
      </span>
    </div>
    <h2 class="section-title">{{ title }}</h2>
    <p v-if="subtitle" class="section-subtitle">{{ subtitle }}</p>
  </div>
</template>

<script setup lang="ts">
interface Tag {
  label: string
  type?: 'primary' | 'secondary'
}

interface Props {
  title: string
  subtitle?: string
  tags?: Tag[]
  centered?: boolean
}

withDefaults(defineProps<Props>(), {
  tags: () => [],
  centered: true
})
</script>

<style scoped>
.section-header {
  margin-bottom: 32px;
}

.section-header.text-center {
  text-align: center;
}

.section-meta {
  display: flex;
  gap: 8px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 16px;
}

.section-header:not(.text-center) .section-meta {
  justify-content: flex-start;
}

.section-tag {
  padding: 6px 14px;
  background: var(--glass);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  font-size: 0.8rem;
  color: var(--accent);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
}

.section-tag.secondary {
  color: var(--muted);
  background: rgba(255,255,255,.02);
}

.section-tag:hover {
  background: rgba(34,211,238,.08);
  border-color: var(--accent);
  transform: translateY(-1px);
}

.section-title {
  margin: 0 0 12px;
  font-size: 2.2rem;
  font-weight: 800;
  color: var(--foreground);
}

.section-subtitle {
  margin: 0;
  font-size: 1.1rem;
  color: var(--muted);
  line-height: 1.5;
  max-width: 600px;
}

.text-center .section-subtitle {
  margin: 0 auto;
}
</style>
