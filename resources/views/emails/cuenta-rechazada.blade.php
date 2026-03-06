<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización sobre su registro en METRA</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #333333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8f9fa; padding-top: 40px; padding-bottom: 40px; }
        .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 8px; border: 1px solid #e9ecef; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background-color: #0A0A0A; padding: 30px; text-align: center; border-bottom: 3px solid #D32F2F; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        .header span { color: #D32F2F; }
        .content { padding: 40px 30px; text-align: center; }
        .title { font-size: 22px; font-weight: bold; color: #0A0A0A; margin-top: 0; margin-bottom: 20px; }
        .text { font-size: 16px; line-height: 1.6; color: #666666; margin-bottom: 30px; }
        .motivo-box { background-color: #fff5f5; border: 1px solid #feb2b2; padding: 20px; border-radius: 4px; margin-bottom: 30px; text-align: left; }
        .motivo-label { font-weight: bold; color: #c53030; display: block; margin-bottom: 8px; font-size: 14px; text-transform: uppercase; }
        .motivo-text { color: #2d3748; font-size: 15px; }
        .footer { background-color: #f1f3f5; padding: 20px 30px; text-align: center; font-size: 13px; color: #888888; border-top: 1px solid #e9ecef; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="header">
                    <h1>METRA<span>.</span></h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2 class="title">Actualización sobre su solicitud</h2>
                    <p class="text">
                        Hola, le informamos que tras revisar su solicitud de registro de negocio, lamentamos comunicarle que en esta ocasión no ha sido posible proceder con su activación.
                    </p>
                    
                    @if($motivo)
                    <div class="motivo-box">
                        <span class="motivo-label">Motivo de la resolución:</span>
                        <div class="motivo-text">{{ $motivo }}</div>
                    </div>
                    @endif

                    <p class="text" style="font-size: 14px; margin-bottom: 0;">
                        Si considera que ha habido un error o desea enviarnos información adicional para una nueva revisión, por favor póngase en contacto con nuestro equipo de soporte respondiendo a este correo o a través de nuestros canales oficiales.
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    &copy; {{ date('Y') }} METRA SaaS. Todos los derechos reservados.<br>
                    Este es un mensaje automático, por favor no respondas a este correo directamente.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
