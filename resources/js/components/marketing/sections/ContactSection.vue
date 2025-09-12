<template>
  <section id="contact" class="section contact-section">
    <BaseContainer>
      <div class="contact-grid">
        <div class="contact-intro">
          <h2 class="section-title">Cuéntame sobre tu idea</h2>
          <p class="lead">Completa el formulario y te responderé con una propuesta clara en menos de 24h (días hábiles).</p>
          <ul class="benefits" aria-label="Beneficios incluidos">
            <li>✔ Respuesta en 24h</li>
            <li>✔ Propuesta clara y transparente</li>
            <li>✔ Sin spam ni suscripciones</li>
          </ul>
          <div class="alt">
            <a href="mailto:hello@vondrak.dev">hello@vondrak.dev</a>
            <span class="sep" aria-hidden="true">·</span>
            <a target="_blank" rel="noopener noreferrer" href="https://wa.me/00000000000">WhatsApp</a>
          </div>
        </div>

        <form class="contact-form glass" @submit.prevent="handleSubmit" novalidate aria-describedby="contact-status" aria-live="polite">
          <!-- Nombre -->
          <label class="sr-only" for="name">Nombre</label>
          <input v-model="form.name" id="name" name="name" type="text"
                 placeholder="Tu nombre" autocomplete="name" required />

          <!-- Email -->
          <label class="sr-only" for="email">Correo</label>
          <input v-model="form.email" id="email" name="email" type="email"
                 placeholder="Correo electrónico" autocomplete="email" required />

          <!-- Servicio -->
          <select v-model="form.serviceType" name="serviceType" class="contact-select" required>
            <option value="" disabled>Selecciona el tipo de servicio</option>
            <option value="informativa">Página Informativa ($399 USD)</option>
            <option value="landing">Landing Page ($799 USD)</option>
            <option value="tienda">Tienda Online ($1,299 USD)</option>
          </select>

          <!-- Presupuesto -->
          <select v-model="form.budget" name="budget" class="contact-select" required>
            <option value="" disabled>¿Cuál es tu presupuesto estimado?</option>
            <option value="menos-400">Menos de $400 USD</option>
            <option value="400-800">$400 - $800 USD</option>
            <option value="800-1500">$800 - $1,500 USD</option>
            <option value="1500-3000">$1,500 - $3,000 USD</option>
            <option value="3000-5000">$3,000 - $5,000 USD</option>
            <option value="mas-5000">Más de $5,000 USD</option>
          </select>

          <!-- Mensaje -->
          <textarea v-model="form.message" name="message" rows="4"
                    placeholder="¿Qué necesitas? Cuéntame más detalles sobre tu proyecto..." required />

          <!-- Consentimiento -->
          <label class="consent">
            <input type="checkbox" v-model="form.consent" />
            Acepto ser contactado y que mis datos sean usados para responder a mi solicitud.
          </label>

          <!-- Honeypot -->
          <input v-model="form.company" name="company" type="text" tabindex="-1"
                 autocomplete="off" class="hp" aria-hidden="true" />

          <!-- Tracking oculto (UTM/referrer/landing/gclid) -->
          <input type="hidden" v-model="form.utm_source" />
          <input type="hidden" v-model="form.utm_medium" />
          <input type="hidden" v-model="form.utm_campaign" />
          <input type="hidden" v-model="form.utm_term" />
          <input type="hidden" v-model="form.utm_content" />
          <input type="hidden" v-model="form.referrer" />
          <input type="hidden" v-model="form.landing_url" />
          <input type="hidden" v-model="form.gclid" />

          <!-- Botón -->
          <button class="btn submit-btn" type="submit" :disabled="loading">
            <span class="loader" v-if="loading" aria-hidden="true"></span>
            <span v-if="loading">Enviando…</span>
            <span v-else>Solicitar presupuesto</span>
          </button>
        </form>
        <p v-if="status==='ok'" id="contact-status" class="status ok" role="status">
          ¡Gracias! Recibí tu solicitud y te responderé pronto.
        </p>
        <p v-if="status==='error'" id="contact-status" class="status error" role="alert">
          Hubo un error al enviar. Intenta nuevamente.
        </p>
      </div>
    </BaseContainer>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import BaseContainer from '@/components/marketing/base/BaseContainer.vue'

type Budget = 'menos-400'|'400-800'|'800-1500'|'1500-3000'|'3000-5000'|'mas-5000'|''

const form = ref({
  name:'', email:'', serviceType:'', budget:'' as Budget, message:'',
  consent: false, company: '', // honeypot

  // tracking
  utm_source:'', utm_medium:'', utm_campaign:'', utm_term:'', utm_content:'',
  referrer:'', landing_url:'', gclid:''
})

const loading = ref(false)
const status = ref<'idle'|'ok'|'error'>('idle')

// Lee CSRF de la meta tag de Blade
const csrf = () => (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ''

onMounted(() => {
  const url = new URL(window.location.href)
  form.value.utm_source   = url.searchParams.get('utm_source')   || ''
  form.value.utm_medium   = url.searchParams.get('utm_medium')   || ''
  form.value.utm_campaign = url.searchParams.get('utm_campaign') || ''
  form.value.utm_term     = url.searchParams.get('utm_term')     || ''
  form.value.utm_content  = url.searchParams.get('utm_content')  || ''
  form.value.gclid        = url.searchParams.get('gclid')        || ''
  form.value.referrer     = document.referrer || ''
  form.value.landing_url  = window.location.href
})

async function handleSubmit() {
  if (form.value.company) return // bot
  loading.value = true
  status.value = 'idle'
  try {
    const res = await fetch('/leads', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrf()
      },
      body: JSON.stringify(form.value)
    })
    if (!res.ok) throw new Error('bad status')
    status.value = 'ok'

    // Evento de analytics opcional:
    // window.gtag?.('event','lead_submitted',{ service: form.value.serviceType, budget: form.value.budget })

    // reset suave
    form.value = {
      name:'', email:'', serviceType:'', budget:'' as Budget, message:'',
      consent:false, company:'',
      utm_source:'', utm_medium:'', utm_campaign:'', utm_term:'', utm_content:'',
      referrer:'', landing_url:'', gclid:''
    }
  } catch {
    status.value = 'error'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped src="./ContactSection.css"></style>
