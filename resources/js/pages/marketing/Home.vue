<script setup lang="ts">
import HeroSection from '@/components/marketing/sections/HeroSection.vue'
import ServicesSection from '@/components/marketing/sections/ServicesSection.vue';
import DefaultLayout from '@/layouts/marketing/DefaultLayout.vue';
import HowWeWorkSection from '@/components/marketing/sections/HowWeWorkSection.vue';
import WorkSection from '@/components/marketing/sections/WorkSection.vue';
import ContactSection from '@/components/marketing/sections/ContactSection.vue';
</script>

<template>
    <DefaultLayout>
      <HeroSection />
      <ServicesSection />
      <HowWeWorkSection />
      <WorkSection />
      <ContactSection />
    </DefaultLayout>
</template>
