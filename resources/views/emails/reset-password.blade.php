<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña METRA</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #333333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8f9fa; padding-top: 40px; padding-bottom: 40px; }
        .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 8px; border: 1px solid #e9ecef; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background-color: #0A0A0A; padding: 30px; text-align: center; border-bottom: 3px solid #D4AF37; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        .header span { color: #D4AF37; }
        .content { padding: 40px 30px; text-align: center; }
        .title { font-size: 22px; font-weight: bold; color: #0A0A0A; margin-top: 0; margin-bottom: 20px; }
        .text { font-size: 16px; line-height: 1.6; color: #666666; margin-bottom: 30px; }
        .btn-container { text-align: center; margin-bottom: 30px; }
        .btn { display: inline-block; background-color: #0A0A0A; color: #ffffff; text-decoration: none; font-weight: bold; padding: 14px 30px; border-radius: 4px; font-size: 16px; transition: background-color 0.3s; }
        .btn:hover { background-color: #333333; }
        .warning-text { font-size: 14px; color: #999999; margin-bottom: 0; border-top: 1px dashed #e9ecef; padding-top: 20px; text-align: left; }
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
                    <h2 class="title">Restablecer contraseña</h2>
                    <p class="text">
                        Hemos recibido una solicitud para cambiar la contraseña de tu cuenta asociada al correo <strong>{{ $email ?? 'usuario' }}</strong>.
                        Para continuar con el proceso, por favor haz clic en el siguiente botón:
                    </p>
                    <div class="btn-container">
                        <a href="{{ $url ?? url('/') }}" class="btn">Restablecer contraseña</a>
                    </div>
                    <p class="warning-text">
                        <strong>Aviso de seguridad:</strong> Si no solicitaste este cambio, puedes ignorar y eliminar este correo con total tranquilidad. Tu contraseña actual seguirá funcionando.
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    &copy; {{ date('Y') }} METRA SaaS. Todos los derechos reservados.<br>
                    Este mensaje fue enviado porque se solicitó un restablecimiento de contraseña.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
