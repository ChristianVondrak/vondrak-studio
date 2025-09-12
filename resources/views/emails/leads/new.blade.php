<h2>Nuevo lead recibido 🚀</h2>

<p><strong>Nombre:</strong> {{ $lead->name }}</p>
<p><strong>Email:</strong> {{ $lead->email }}</p>
<p><strong>Servicio:</strong> {{ $lead->serviceType }}</p>
<p><strong>Presupuesto:</strong> {{ $lead->budget }}</p>

<p><strong>Mensaje:</strong><br>
{{ $lead->message }}</p>

<hr>

<h3>Tracking / Marketing</h3>
<ul>
  <li>utm_source: {{ $lead->utm_source ?? '—' }}</li>
  <li>utm_medium: {{ $lead->utm_medium ?? '—' }}</li>
  <li>utm_campaign: {{ $lead->utm_campaign ?? '—' }}</li>
  <li>utm_term: {{ $lead->utm_term ?? '—' }}</li>
  <li>utm_content: {{ $lead->utm_content ?? '—' }}</li>
  <li>Referrer: {{ $lead->referrer ?? '—' }}</li>
  <li>Landing URL: {{ $lead->landing_url ?? '—' }}</li>
  <li>GCLID: {{ $lead->gclid ?? '—' }}</li>
</ul>

<p><em>IP:</em> {{ $lead->ip }}<br>
<em>User-Agent:</em> {{ $lead->user_agent }}</p>
