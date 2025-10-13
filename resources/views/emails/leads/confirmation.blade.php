<!doctype html>
<html lang="es" style="margin:0;padding:0;">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Confirmación de solicitud</title>
  <style>
    /* Estilos básicos compatibles con clientes de correo */
    body { margin:0; padding:0; background:#0f1217; color:#e8eef7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif; }
    .wrap { max-width:640px; margin:0 auto; background:#0b0e13; }
    .hero { background: linear-gradient(135deg,#0ea5e9,#22d3ee 50%, #a855f7); padding: 40px 28px; text-align:center; color:#05253b; }
    .hero h1 { margin:0; font-size:28px; line-height:1.2; color:#031726; }
    .card { background:#0f172a; border:1px solid rgba(255,255,255,0.06); box-shadow:0 10px 30px rgba(2,8,23,0.6); border-radius:16px; padding:28px; margin: -24px 16px 24px; }
    h2 { color:#e2e8f0; margin:0 0 12px; font-size:20px; }
    p { color:#cbd5e1; margin: 0 0 12px; font-size:15px; }
    .pill { display:inline-block; padding:6px 10px; border-radius:999px; background:#0ea5e9; color:#031726; font-weight:600; font-size:12px; letter-spacing:.3px; }
    .cta { display:inline-block; background:#22c55e; color:#052e13; text-decoration:none; font-weight:700; padding:12px 18px; border-radius:12px; margin-top:8px; }
    .muted { color:#94a3b8; font-size:12px; }
    .footer { padding: 18px 28px 32px; color:#94a3b8; font-size:12px; text-align:center; }
    .list { list-style:none; padding:0; margin:8px 0 0; }
    .list li { margin:6px 0; }

    /* Responsive (móvil) */
    @media only screen and (max-width: 600px) {
      .wrap { width:100% !important; margin:0 !important; }
      .hero { padding: 28px 16px !important; }
      .hero h1 { font-size:22px !important; line-height:1.25 !important; }
      .card { margin: -16px 12px 16px !important; padding:20px !important; border-radius:14px !important; }
      h2 { font-size:18px !important; }
      p { font-size:14px !important; }
      .cta { display:block !important; width:100% !important; box-sizing:border-box !important; text-align:center !important; padding:14px 16px !important; }
      .pill { margin-bottom:8px !important; }
      .footer { padding:16px !important; }
    }
  </style>
</head>
<body>
  <!-- Preheader (texto previo que algunos clientes muestran en la bandeja) -->
  <div style="display:none!important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden; mso-hide:all;">
    Gracias por tu solicitud. Te contactaremos a la brevedad con próximos pasos.
  </div>
  <div class="wrap">
    <div class="hero">
      <span class="pill">Vondrak Studio</span>
      <h1>¡Gracias {{ $lead->name ?? '' }}! Recibimos tu solicitud ✅</h1>
      <p style="color:#063045;">En breve te contactaremos con una propuesta clara y pasos a seguir.</p>
    </div>

    <div class="card">
      <h2>Resumen de tu solicitud</h2>
      <p><strong>Servicio:</strong> {{ $lead->serviceType }}</p>
      <p><strong>Presupuesto estimado:</strong> {{ $lead->budget }}</p>
      <p><strong>Mensaje:</strong><br>{{ $lead->message }}</p>
      <p class="muted">Si necesitas corregir algo, simplemente responde a este correo.</p>
      <a class="cta" href="https://vondrak.dev" target="_blank" rel="noopener">Visitar sitio</a>
    </div>

    <div class="footer">
      <p>Este mensaje fue enviado por Vondrak Studio respecto a tu solicitud de servicios.</p>
      <p class="muted">Si no fuiste tú, ignora este correo.</p>
    </div>
  </div>
</body>
</html>
