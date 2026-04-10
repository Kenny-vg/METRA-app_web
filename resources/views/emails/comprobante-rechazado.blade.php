<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante Rechazado — METRA</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f5f5; font-family:'Helvetica Neue', Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="580" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#1a1a1a; padding: 32px 40px; text-align:center;">
                            <span style="color:#D4AF37; font-size:28px; font-weight:800; letter-spacing:-1px;">METRA</span>
                        </td>
                    </tr>

                    <!-- Alert bar -->
                    <tr>
                        <td style="background:#c62828; padding: 14px 40px;">
                            <p style="margin:0; color:#fff; font-weight:700; font-size:14px; text-align:center;">
                                ⚠️ Tu comprobante de pago fue rechazado
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 36px 40px 24px;">
                            <p style="margin:0 0 16px; color:#333; font-size:15px; line-height:1.6;">
                                Hola, <strong>{{ $nombreCafeteria }}</strong>,
                            </p>
                            <p style="margin:0 0 16px; color:#555; font-size:14px; line-height:1.7;">
                                Lamentablemente, tu comprobante de pago <strong>no pudo ser validado</strong> por el administrador de METRA. Por favor, revisa los siguientes puntos antes de volver a intentarlo:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff8f8; border-radius:8px; border-left: 4px solid #c62828; padding: 0; margin-bottom:20px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <p style="margin:0 0 10px; font-weight:700; color:#b71c1c; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">¿Qué puede haber salido mal?</p>
                                        <ul style="margin:0; padding-left:18px; color:#555; font-size:14px; line-height:2;">
                                            <li>La transferencia no se realizó a la cuenta correcta del administrador</li>
                                            <li>El monto transferido no corresponde al plan seleccionado</li>
                                            <li>El comprobante subido no es legible o está incompleto</li>
                                            <li>El archivo no se visualizó correctamente</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 24px; color:#555; font-size:14px; line-height:1.7;">
                                Puedes volver a intentarlo desde tu panel de administración o directamente desde la pantalla de inicio de sesión. Si el problema persiste, <strong>contacta a nuestro equipo de soporte</strong>.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/login') }}"
                                           style="display:inline-block; background:#1a1a1a; color:#ffffff; text-decoration:none; padding:14px 36px; border-radius:8px; font-weight:700; font-size:14px; letter-spacing:0.5px;">
                                            Iniciar Sesión y Reenviar
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; border-top: 1px solid #eeeeee; text-align:center;">
                            <p style="margin:0; color:#aaa; font-size:12px; line-height:1.6;">
                                Este correo fue enviado automáticamente por METRA.<br>
                                Si tienes dudas, responde a este correo o contáctanos en
                                <a href="mailto:{{ config('mail.from.address') }}" style="color:#1a1a1a;">{{ config('mail.from.address') }}</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
