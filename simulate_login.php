<?php

// Simulamos los modelos
class MockSuscripcion {
    public $estado_pago;
    public $comprobante_url;
    public function __construct($estado, $url) {
        $this->estado_pago = $estado;
        $this->comprobante_url = $url;
    }
}

class MockCafeteria {
    public $estado;
    public $suscripcion;
    public function __construct($estado, $sub) {
        $this->estado = $estado;
        $this->suscripcion = $sub;
    }
    public function suscripciones() {
        return $this;
    }
    public function latest() {
        return $this;
    }
    public function first() {
        return $this->suscripcion;
    }
}

class MockUser {
    public $estado;
    public $role;
    public $cafeteria;
    public function __construct($estado, $role, $cafe) {
        $this->estado = $estado;
        $this->role = $role;
        $this->cafeteria = $cafe;
    }
}

function simulateLoginCheck($user) {
    echo "--- Simulando check de login ---\n";
    
    // Basado en Line 27 de LoginController.php
    if(!$user->estado && $user->role === 'gerente'){

        $cafeteria = $user->cafeteria;
        $suscripcion = $cafeteria ? $cafeteria->suscripciones()->latest()->first() : null;

        if(!$suscripcion){
            return "ERROR 423: Tu suscripción aún no ha sido creada.";
        }

        // Si NO ha subido comprobante
        if(!$suscripcion->comprobante_url){
            return "ERROR 423: Debes subir tu comprobante para continuar.";
        }

        // Si ya subió pero no está aprobado
        if($suscripcion->estado_pago !== 'pagado'){
            // Esto es lo que pasa tanto para 'pendiente' como para 'cancelado' (rechazado)
            return "ERROR 423: Tu comprobante fue enviado. Espera la validación del superadmin.";
        }
    }
    
    // Basado en Line 59
    if(in_array($user->role,['gerente','personal'])){
        $cafeteria = $user->cafeteria;
        if(!$cafeteria) return "ERROR 403: No tienes una cafetería asociada.";
        $suscripcion = $cafeteria->suscripciones()->latest()->first();
        if(!$suscripcion) return "ERROR 403: Tu suscripción aún no ha sido creada.";

        if($suscripcion->estado_pago !== 'pagado'){
            if($user->role === 'gerente'){
                return "ERROR 423: Tu suscripción está pendiente de aprobación. Por favor espera la validación del superadmin.";
            }
        }
    }

    return "SUCCESS: Login correcto";
}

// 1. Caso Pendiente
$subPendiente = new MockSuscripcion('pendiente', 'path/to/comprobante.png');
$cafePendiente = new MockCafeteria('en_revision', $subPendiente);
$userPendiente = new MockUser(0, 'gerente', $cafePendiente);

echo "ESCENARIO PENDIENTE:\n";
echo simulateLoginCheck($userPendiente) . "\n\n";

// 2. Caso Rechazado
$subRechazado = new MockSuscripcion('cancelado', 'path/to/comprobante.png');
$cafeRechazado = new MockCafeteria('suspendida', $subRechazado);
$userRechazado = new MockUser(0, 'gerente', $cafeRechazado);

echo "ESCENARIO RECHAZADO:\n";
echo simulateLoginCheck($userRechazado) . "\n";
