<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$results = [];

function runRequest($method, $uri, $data = [], $token = null)
{
    global $kernel;
    $server = [
        'CONTENT_TYPE' => 'application/json',
        'HTTP_ACCEPT'  => 'application/json',
    ];
    if ($token) {
        $server['HTTP_AUTHORIZATION'] = "Bearer $token";
    }

    // For nested arrays (like gerente.*), we need to pass actual PHP array
    $request = Illuminate\Http\Request::create(
        $uri, $method, [],
        [], [], $server,
        json_encode($data)
    );
    // Mark as JSON
    $request->headers->set('Content-Type', 'application/json');

    $response = $kernel->handle($request);
    $kernel->terminate($request, $response);

    return [
        'status'  => $response->getStatusCode(),
        'content' => json_decode($response->getContent(), true),
        'cookies' => $response->headers->getCookies(),
    ];
}

function check($name, $pass, $detail = '')
{
    global $results;
    $icon = $pass ? '✓' : '✗';
    $status = $pass ? 'PASS' : 'FAIL';
    $results[] = ['name' => $name, 'pass' => $pass, 'detail' => $detail];
    echo "[$icon] $status: $name" . ($detail ? " ($detail)" : '') . "\n";
}

echo "══════════════════════════════════════\n";
echo "  METRA - FINAL E2E API TEST SUITE\n";
echo "══════════════════════════════════════\n\n";

// ─────────────────────────────────────────
// 1. LOGIN TESTS
// ─────────────────────────────────────────
echo "── 1. LOGIN ──────────────────────────\n";

// 1a. Invalid credentials
$res = runRequest('POST', '/api/login', ['email' => 'superadmin@metra.com', 'password' => 'wrongpass']);
check('Invalid credentials → 401', $res['status'] === 401, "Status {$res['status']}");

// 1b. Superadmin login
$res = runRequest('POST', '/api/login', ['email' => 'superadmin@metra.com', 'password' => '12345678']);
check('Superadmin login → 200', $res['status'] === 200, "Status {$res['status']}");
check('Superadmin role = superadmin', ($res['content']['data']['usuario']['role'] ?? '') === 'superadmin');
$superadminToken = $res['content']['data']['token'] ?? null;

// Check metra_role cookie
$hasRoleCookie = false;
foreach ($res['cookies'] as $c) {
    if ($c->getName() === 'metra_role' && $c->getValue() === 'superadmin') $hasRoleCookie = true;
}
check('Superadmin metra_role cookie set', $hasRoleCookie);

// ─────────────────────────────────────────
// 2. REGISTRATION TESTS
// ─────────────────────────────────────────
echo "\n── 2. REGISTRATION ───────────────────\n";

$ts = time();
$uniqueEmail = "e2e_{$ts}@gmail.com";

// 2a. Invalid domain
$res = runRequest('POST', '/api/registro-negocio', [
    'nombre'   => 'E2E Cafe',
    'telefono' => '1234567890',
    'plan_id'  => 1,
    'gerente'  => [
        'name'                  => 'Test Gerente',
        'email'                 => 'test@fakeinvalid-xyz.com',
        'password'              => '12345678',
        'password_confirmation' => '12345678',
    ],
]);
check('Invalid email domain → 422', $res['status'] === 422, "Status {$res['status']}");

// 2b. Valid registration
$res = runRequest('POST', '/api/registro-negocio', [
    'nombre'   => 'E2E Cafe Test',
    'telefono' => '9991234567',
    'plan_id'  => 1,
    'gerente'  => [
        'name'                  => 'Gerente E2E',
        'email'                 => $uniqueEmail,
        'password'              => '12345678',
        'password_confirmation' => '12345678',
    ],
]);
check('Valid registration → 201', $res['status'] === 201 || $res['status'] === 200, "Status {$res['status']}. Errors: " . json_encode($res['content']['errors'] ?? []));

$cafeId = $res['content']['data']['cafeteria']['id']
       ?? $res['content']['data']['cafeteria_id']
       ?? null;
$gerenteToken = $res['content']['data']['token'] ?? null;

check('Cafeteria ID returned', !empty($cafeId));

// 2c. Duplicate email
$res2 = runRequest('POST', '/api/registro-negocio', [
    'nombre'   => 'Another Cafe',
    'plan_id'  => 1,
    'gerente'  => [
        'name'                  => 'Gerente Dup',
        'email'                 => $uniqueEmail,
        'password'              => '12345678',
        'password_confirmation' => '12345678',
    ],
]);
// Pending user with same email either updates (200) or gets blocked
check('Duplicate pending email → 200 or 409', in_array($res2['status'], [200, 409]), "Status {$res2['status']}");

// 2d. Try login while still pending without receipt
$res = runRequest('POST', '/api/login', ['email' => $uniqueEmail, 'password' => '12345678']);
check('Login pending (no receipt) → 423', $res['status'] === 423, "Status {$res['status']} Msg: " . ($res['content']['message'] ?? ''));

// 2e. Mock a receipt upload (set comprobante_url directly via Eloquent)
if ($cafeId) {
    $cafe = \App\Models\Cafeteria::find($cafeId);
    if ($cafe) {
        $cafe->comprobante_url = 'mocked-receipt-e2e.jpg';
        $cafe->save();
        echo "    [info] Mocked receipt upload for cafe_id=$cafeId\n";
    }
}

// 2f. Login after receipt uploaded → should say "in review"
$res = runRequest('POST', '/api/login', ['email' => $uniqueEmail, 'password' => '12345678']);
check('Login with receipt (in review) → 423', $res['status'] === 423, "Msg: " . ($res['content']['message'] ?? ''));
check('In-review message mentions validación', str_contains($res['content']['message'] ?? '', 'validación') || str_contains($res['content']['message'] ?? '', 'revisión'), "Msg: " . ($res['content']['message'] ?? ''));

// ─────────────────────────────────────────
// 3. SUPERADMIN PANEL
// ─────────────────────────────────────────
echo "\n── 3. SUPERADMIN PANEL ───────────────\n";

// 3a. List solicitudes
$res = runRequest('GET', '/api/superadmin/solicitudes', [], $superadminToken);
check('Superadmin list solicitudes → 200', $res['status'] === 200, "Status {$res['status']}");

$foundInReview = false;
foreach ($res['content']['data'] ?? [] as $item) {
    if ($item['id'] === $cafeId) $foundInReview = true;
}
check('New cafe appears in solicitudes', $foundInReview, "Looking for cafe_id=$cafeId");

// 3b. List cafeterias
$res = runRequest('GET', '/api/superadmin/cafeterias', [], $superadminToken);
check('Superadmin list cafeterias → 200', $res['status'] === 200, "Status {$res['status']}");

// 3c. List planes
$res = runRequest('GET', '/api/superadmin/planes', [], $superadminToken);
check('Superadmin list planes → 200', $res['status'] === 200, "Status {$res['status']}");
$planesList = $res['content']['data'] ?? [];
check('Plans list not empty', count($planesList) > 0);

// 3d. Approve cafeteria
if ($cafeId) {
    $res = runRequest('PATCH', "/api/superadmin/solicitudes/$cafeId/aprobar", [], $superadminToken);
    check("Approve cafeteria (id=$cafeId) → 200", $res['status'] === 200, "Msg: " . ($res['content']['message'] ?? ''));

    // Verify it's now activa
    $cafe = \App\Models\Cafeteria::find($cafeId);
    check('Cafeteria estado = activa after approval', $cafe && $cafe->estado === 'activa', "Estado: " . ($cafe->estado ?? 'null'));
}

// 3e. Login as approved gerente
$res = runRequest('POST', '/api/login', ['email' => $uniqueEmail, 'password' => '12345678']);
check('Approved gerente login → 200', $res['status'] === 200, "Status {$res['status']} Msg: " . ($res['content']['message'] ?? ''));
$approvedToken = $res['content']['data']['token'] ?? null;

// Check role cookie for gerente
$gerenteCookie = false;
foreach ($res['cookies'] as $c) {
    if ($c->getName() === 'metra_role' && $c->getValue() === 'gerente') $gerenteCookie = true;
}
check('Gerente metra_role cookie set on login', $gerenteCookie);

// 3f. Reject experiment — first, suspend so we can re-test reject
if ($cafeId) {
    $res = runRequest('PATCH', "/api/superadmin/solicitudes/$cafeId/rechazar", [], $superadminToken);
    check("Reject cafeteria → 200", $res['status'] === 200, "Msg: " . ($res['content']['message'] ?? ''));
    // Restore approval for subsequent tests
    runRequest('PATCH', "/api/superadmin/solicitudes/$cafeId/aprobar", [], $superadminToken);
}

// ─────────────────────────────────────────
// 4. SUBSCRIPTIONS
// ─────────────────────────────────────────
echo "\n── 4. SUBSCRIPTIONS ──────────────────\n";

if ($cafeId && $approvedToken) {
    // 4a. Gerente with active subscription can access API
    $res = runRequest('GET', '/api/gerente/zonas', [], $approvedToken);
    check('Gerente with active sub → access gerente API', $res['status'] === 200, "Status {$res['status']}");

    // 4b. Expire subscription  
    $cafe = \App\Models\Cafeteria::find($cafeId);
    $sub = $cafe ? $cafe->suscripciones()->latest()->first() : null;
    if ($sub) {
        $sub->fecha_fin = now()->subDay();
        $sub->estado_pago = 'pagado'; // Keep paid but expired by date
        $sub->save();
        echo "    [info] Mocked subscription expiration (fecha_fin = yesterday)\n";
    }

    // 4c. Login with expired subscription
    $res = runRequest('POST', '/api/login', ['email' => $uniqueEmail, 'password' => '12345678']);
    check('Expired sub → login blocked (403 or specific msg)', $res['status'] === 403 || ($res['status'] === 200 && str_contains($res['content']['message'] ?? '', 'suscripción')), "Status {$res['status']} Msg: " . ($res['content']['message'] ?? ''));

    // 4d. API with expired subscription (using old token)
    $res = runRequest('GET', '/api/gerente/zonas', [], $approvedToken);
    check('Expired sub → API access blocked (403)', $res['status'] === 403, "Status {$res['status']}");

    // Restore subscription  
    if ($sub) {
        $sub->fecha_fin = now()->addDays(30);
        $sub->save();
    }
}

// ─────────────────────────────────────────
// 5. STAFF ENDPOINTS
// ─────────────────────────────────────────
echo "\n── 5. STAFF ENDPOINTS ────────────────\n";

// Look for a staff user in DB
$staffUser = \App\Models\User::where('role', 'personal')->whereHas('cafeteria', function($q) {
    $q->where('estado', 'activa');
})->first();

if ($staffUser) {
    // Login as staff
    $staffLogin = runRequest('POST', '/api/login', ['email' => $staffUser->email, 'password' => '12345678']);
    $staffToken = $staffLogin['content']['data']['token'] ?? null;
    check('Staff login → 200', $staffLogin['status'] === 200 && $staffToken, "Status {$staffLogin['status']}");

    foreach (['/api/staff/mesas', '/api/staff/zonas', '/api/staff/promociones', '/api/staff/horarios'] as $endpoint) {
        $r = runRequest('GET', $endpoint, [], $staffToken);
        check("$endpoint → 200", $r['status'] === 200, "Status {$r['status']}");
    }

    // Verify unauthenticated request blocked
    $r = runRequest('GET', '/api/staff/mesas');
    check('/api/staff/mesas unauthenticated → 401', $r['status'] === 401, "Status {$r['status']}");

    // Role middleware test: gerente cannot access staff endpoints
    if ($approvedToken) {
        $r = runRequest('GET', '/api/staff/mesas', [], $approvedToken);
        check('Gerente cannot access /api/staff/mesas → 403', $r['status'] === 403, "Status {$r['status']}");
    }
} else {
    echo "    [skip] No active staff user found in DB — skipping staff endpoint tests\n";
    check('Staff endpoint tests', false, 'No staff user available in DB');
}

// ─────────────────────────────────────────
// CLEANUP
// ─────────────────────────────────────────
echo "\n── CLEANUP ───────────────────────────\n";
if ($cafeId) {
    $cafe = \App\Models\Cafeteria::find($cafeId);
    if ($cafe) {
        $cafe->gerente()->delete();
        $cafe->suscripciones()->delete();
        $cafe->delete();
        echo "    [info] Deleted test cafe_id=$cafeId and related records\n";
    }
}

// ─────────────────────────────────────────
// SUMMARY
// ─────────────────────────────────────────
echo "\n══════════════════════════════════════\n";
$passed = count(array_filter($results, fn($r) => $r['pass']));
$failed = count(array_filter($results, fn($r) => !$r['pass']));
$total  = count($results);
echo "  RESULTS: $passed/$total passed, $failed failed\n";
echo "══════════════════════════════════════\n";

if ($failed > 0) {
    echo "\nFailed tests:\n";
    foreach ($results as $r) {
        if (!$r['pass']) echo "  - {$r['name']}" . ($r['detail'] ? ": {$r['detail']}" : '') . "\n";
    }
}
