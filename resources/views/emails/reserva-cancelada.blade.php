<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservación Cancelada</title>

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

.btn-container{
text-align:center;
margin-bottom:30px;
}

.btn{
display:inline-block;
background-color:#D4AF37;
color:#ffffff;
text-decoration:none;
font-weight:bold;
padding:14px 30px;
border-radius:4px;
font-size:16px;
}

.footer{
background-color:#f1f3f5;
padding:20px 30px;
text-align:center;
font-size:13px;
color:#888888;
border-top:1px solid #e9ecef;
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

<h2 class="title">Actualización de tu reservación</h2>

<p class="text">
Hola, <strong>{{ $reservacion->nombre_cliente }}</strong>
</p>

<p class="text">
Te informamos que tu reservación para el día <strong>{{ $reservacion->fecha }}</strong> a las <strong>{{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('H:i') }}</strong> en <strong>{{ $reservacion->cafeteria->nombre }}</strong> ha sido cancelada.
</p>

<div class="reserva-box">
<p><strong>Folio:</strong> {{ $reservacion->folio }}</p>
<p><strong>Fecha:</strong> {{ $reservacion->fecha }}</p>
<p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('H:i') }}</p>
@if($reservacion->zona)
<p><strong>Zona:</strong> {{ $reservacion->zona->nombre_zona }}</p>
@endif
</div>

<p class="text">
Si tienes alguna duda o deseas realizar una nueva reservación, puedes ponerte en contacto directamente con el establecimiento.
</p>

<div class="btn-container">
<a href="{{ url('/cafeteria/' . $reservacion->cafeteria->slug) }}" class="btn">
    Hacer nueva reservación
</a>
</div>

<p class="text" style="font-size: 14px; color: #888888;">
    Agradecemos tu comprensión.
</p>

</td>
</tr>

<tr>
<td class="footer">
&copy; {{ date('Y') }} METRA - {{ $reservacion->cafeteria->nombre }}.<br>
Este es un mensaje automático, por favor no respondas a este correo.
</td>
</tr>

</table>

</div>

</body>
</html>
