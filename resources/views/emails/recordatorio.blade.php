<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recordatorio de tu reservación – METRA</title>

<style>
body{
margin:0;
padding:0;
font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;
background-color:#f8f9fa;
color:#333333;
}

.wrapper{
width:100%;
background-color:#f8f9fa;
padding-top:40px;
padding-bottom:40px;
}

.main{
background-color:#ffffff;
margin:0 auto;
width:100%;
max-width:600px;
border-radius:8px;
border:1px solid #e9ecef;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
overflow:hidden;
}

.header{
background-color:#0A0A0A;
padding:30px;
text-align:center;
border-bottom:3px solid #D4AF37;
}

.header h1{
color:#ffffff;
margin:0;
font-size:24px;
letter-spacing:2px;
text-transform:uppercase;
font-weight:bold;
}

.header span{
color:#D4AF37;
}

.content{
padding:40px 30px;
text-align:center;
}

.title{
font-size:22px;
font-weight:bold;
color:#0A0A0A;
margin-top:0;
margin-bottom:20px;
}

.text{
font-size:16px;
line-height:1.6;
color:#666666;
margin-bottom:25px;
}

.reserva-box{
background:#f8f9fa;
border:1px solid #e9ecef;
border-radius:6px;
padding:20px;
margin-bottom:25px;
text-align:left;
}

.reserva-box p{
margin:6px 0;
font-size:15px;
}

.folio{
font-size:18px;
font-weight:bold;
color:#D4AF37;
}

.btn-container{
text-align:center;
margin-top:20px;
margin-bottom:30px;
}

.btn{
display:inline-block;
background-color:#0A0A0A;
color:#ffffff;
text-decoration:none;
font-weight:bold;
padding:14px 30px;
border-radius:4px;
font-size:16px;
border:1px solid #0A0A0A;
}

.btn-outline{
display:inline-block;
background-color:transparent;
color:#c62828;
text-decoration:none;
font-weight:bold;
padding:12px 25px;
border-radius:4px;
font-size:14px;
border:1px solid #c62828;
margin-top:10px;
}

.footer{
background-color:#f1f3f5;
padding:20px 30px;
text-align:center;
font-size:13px;
color:#888888;
border-top:1px solid #e9ecef;
}

.highlight{
color:#D4AF37;
font-weight:bold;
}
</style>

</head>

<body>

<div class="wrapper">

<table class="main" width="100%" cellpadding="0" cellspacing="0">

<tr>
<td class="header">
<h1>METRA<span>.</span></h1>
</td>
</tr>

<tr>
<td class="content">

<h2 class="title">
    @if($tipo === 'diario')
        ¡Hoy es el día de tu reserva!
    @else
        Tu reserva comienza en <span class="highlight">2 horas</span>
    @endif
</h2>

<p class="text">
    Hola <strong>{{ $reservacion->nombre_cliente }}</strong>, @if($tipo === 'diario') nos gustaría recordarte que tienes una reserva pendiente para el día de hoy. @else ¡Ya casi es hora! Te recordamos los detalles de tu llegada. @endif
</p>

<div class="reserva-box">

<p><strong>Lugar:</strong> {{ $reservacion->cafeteria->nombre }}</p>
<p><strong>Folio:</strong> <span class="folio">{{ $reservacion->folio }}</span></p>
<p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}</p>
<p><strong>Hora:</strong> {{ substr($reservacion->hora_inicio, 0, 5) }} hrs</p>
<p><strong>Personas:</strong> {{ $reservacion->numero_personas }}</p>

</div>

<p class="text" style="font-size: 14px;">
    Si todo está en orden, no es necesario que respondas a este correo. ¡Te esperamos!
</p>

<div class="btn-container">
    <a href="{{ url('/confirmacion/' . $reservacion->folio) }}" class="btn">
        Gestionar mi reserva
    </a>
    <br>
    <p style="margin-top:25px; font-size: 13px; color: #888;">Si no vas a poder asistir, por favor cancela aquí:</p>
    <a href="{{ url('/confirmacion/' . $reservacion->folio) }}" class="btn-outline">
        Cancelar reserva
    </a>
</div>

</td>
</tr>

<tr>
<td class="footer">
&copy; {{ date('Y') }} METRA. Reservaciones Inteligentes.<br>
Este es un mensaje automático para {{ $reservacion->email }}.
</td>
</tr>

</table>

</div>

</body>
</html>
