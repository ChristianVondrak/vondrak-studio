<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Nuevo lead</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Preheader (texto oculto que algunos clientes muestran en la bandeja) -->
  <style>
    .preheader { display:none!important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; overflow:hidden; mso-hide:all; }
    @media (max-width: 600px) {
      .container { width:100%!important; }
      .stack-col { display:block!important; width:100%!important; }
      .p-24 { padding:20px!important; }
      .btn { display:block!important; width:100%!important; text-align:center!important; }
      .chips { display:block!important; }
      .chips span { display:block!important; margin:6px 0!important; }
    }
  </style>
</head>
<body style="margin:0; padding:0; background:#0f1217; color:#e8eef7; font-family:Arial, Helvetica, sans-serif; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
  <div class="preheader">Nuevo lead recibido. Responde rápido para aumentar la conversión.</div>

  <!-- Outer wrapper -->
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#0f1217;">
    <tr>
      <td align="center" style="padding:24px;">
        <!-- Container -->
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="640" class="container" style="width:640px; max-width:640px; background:#0b0e13; border-radius:16px; overflow:hidden;">
          <!-- HERO -->
          <tr>
            <td style="background:linear-gradient(135deg,#22d3ee,#0ea5e9 50%, #6366f1); padding:28px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td>
                    <div style="font-size:22px; line-height:28px; font-weight:800; color:#031726;">Nuevo lead recibido 🚀</div>
                    <div style="margin-top:6px; font-size:13px; line-height:18px; color:#05253b;">
                      Fecha: {{ now()->format('Y-m-d H:i') }} · IP: <span style="font-family:Courier, monospace;">{{ $lead->ip }}</span>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Quick summary chips -->
          <tr>
            <td style="padding:16px 24px 0 24px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td class="stack-col chips" style="padding-bottom:8px;">
                    <span style="display:inline-block; background:#0f172a; border:1px solid rgba(255,255,255,0.08); color:#e2e8f0; font-size:12px; line-height:18px; padding:6px 10px; border-radius:999px; margin-right:8px;">
                      Servicio: <strong>{{ $lead->serviceType ?? '—' }}</strong>
                    </span>
                    <span style="display:inline-block; background:#0f172a; border:1px solid rgba(255,255,255,0.08); color:#e2e8f0; font-size:12px; line-height:18px; padding:6px 10px; border-radius:999px; margin-right:8px;">
                      Presupuesto: <strong>{{ $lead->budget ?? '—' }}</strong>
                    </span>
                    <span style="display:inline-block; background:#0f172a; border:1px solid rgba(255,255,255,0.08); color:#e2e8f0; font-size:12px; line-height:18px; padding:6px 10px; border-radius:999px;">
                      Email: <strong>{{ $lead->email }}</strong>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Datos del contacto -->
          <tr>
            <td style="padding:16px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0f172a; border:1px solid rgba(255,255,255,0.06); border-radius:14px;">
                <tr>
                  <td class="p-24" style="padding:22px;">
                    <div style="font-size:16px; font-weight:700; color:#e2e8f0; margin-bottom:12px;">Datos del contacto</div>
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Nombre</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px; font-weight:600;">{{ $lead->name }}</td>
                      </tr>
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Email</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px;">
                          <a href="mailto:{{ $lead->email }}" style="color:#e8eef7; text-decoration:none; border-bottom:1px dotted rgba(255,255,255,0.35);">{{ $lead->email }}</a>
                        </td>
                      </tr>
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Servicio</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px;">{{ $lead->serviceType ?? '—' }}</td>
                      </tr>
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Presupuesto</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px;">{{ $lead->budget ?? '—' }}</td>
                      </tr>
                      @isset($lead->phone)
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Teléfono</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px;">{{ $lead->phone }}</td>
                      </tr>
                      @endisset
                      @isset($lead->source)
                      <tr>
                        <td width="160" style="padding:6px 0; color:#94a3b8; font-size:13px;">Fuente</td>
                        <td style="padding:6px 0; color:#cbd5e1; font-size:14px;">{{ $lead->source }}</td>
                      </tr>
                      @endisset
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Mensaje (ajustado) -->
          <tr>
            <td style="padding:0 24px 8px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0f172a; border:1px solid rgba(255,255,255,0.06); border-radius:14px;">
                <tr>
                  <td class="p-24" style="padding:22px;">
                    <div style="font-size:16px; font-weight:700; color:#e2e8f0; margin-bottom:12px;">Mensaje</div>

                    <div style="
                      font-size:14px;
                      line-height:1.7;
                      color:#cbd5e1;
                      margin:0;
                      background:#0c1324;
                      border:1px solid rgba(255,255,255,0.05);
                      border-radius:10px;
                      padding:14px;              /* padding uniforme */
                      white-space:pre-line;       /* NO conserva espacios al inicio */
                      word-break:break-word;
                      text-indent:0;              /* por si algún cliente aplica sangría */
                    ">
                      {{ $lead->message }}
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CTA Buttons -->
          <tr>
            <td align="center" style="padding:8px 24px 24px 24px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" style="padding:6px 4px;">
                    <a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('¡Gracias por contactarnos!') }}" 
                       style="display:inline-block; text-decoration:none; background:#0ea5e9; color:#031726; font-weight:800; font-size:14px; padding:12px 18px; border-radius:999px;" class="btn">
                      Responder al lead
                    </a>
                  </td>
                  @isset($lead->adminUrl)
                  <td align="center" style="padding:6px 4px;">
                    <a href="{{ $lead->adminUrl }}" 
                       style="display:inline-block; text-decoration:none; background:#111827; border:1px solid rgba(255,255,255,0.12); color:#e8eef7; font-weight:700; font-size:14px; padding:12px 18px; border-radius:999px;" class="btn">
                      Ver en panel
                    </a>
                  </td>
                  @endisset
                </tr>
              </table>
              <div style="margin-top:10px; font-size:12px; color:#94a3b8;">
                Puedes responder a este correo; <span style="white-space:nowrap;">Reply-To</span> está configurado al email del lead.
              </div>
            </td>
          </tr>

          <!-- Divider -->
          <tr>
            <td style="padding:0 24px;">
              <hr style="border:none; height:1px; background:linear-gradient(90deg, rgba(99,102,241,0.0), rgba(34,211,238,0.35), rgba(99,102,241,0.0)); margin:0;">
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:16px 24px 22px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="font-size:12px; color:#94a3b8; line-height:18px;">
                    Recibiste este correo porque alguien completó el formulario de contacto.
                    Si no reconoces este lead, ignora este mensaje.
                  </td>
                  <td align="right" style="font-size:12px; color:#94a3b8;">
                    {{ config('app.name') }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
        <!-- /Container -->
      </td>
    </tr>
  </table>
  <!-- /Outer wrapper -->
</body>
</html>
