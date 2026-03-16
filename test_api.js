// Native fetch in Node

const BASE_URL = 'http://127.0.0.1:8000/api';
let token = '';

async function login() {
    console.log("1. Logging in...");
    const res = await fetch(`${BASE_URL}/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: 'gerente@metra.com',
            password: 'password' // Let's try password first, if not 12345678
        })
    });
    
    let data = await res.json();
    if (!data.data || !data.data.token) {
        console.log("Login failed with 'password', trying '12345678'...");
        const res2 = await fetch(`${BASE_URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: 'gerente@metra.com',
                password: '12345678'
            })
        });
        data = await res2.json();
    }
    
    if (data.data && data.data.token) {
        token = data.data.token;
        console.log("Login successful! Token:", token.substring(0, 10) + '...');
    } else {
        console.error("Login failed!", data);
        process.exit(1);
    }
}

async function apiCall(method, endpoint, body = null) {
    console.log(`\n=> [${method}] ${endpoint}`);
    const options = {
        method,
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    if (body) {
        options.body = JSON.stringify(body);
        console.log("   Body:", options.body);
    }
    
    const res = await fetch(`${BASE_URL}${endpoint}`, options);
    const data = await res.json();
    console.log(`   Status: ${res.status}`);
    console.log(`   Response:`, JSON.stringify(data, null, 2));
    return data;
}

    // Start tests
    login().then(async () => {
        // --- SEED DATA AS GERENTE ---
        console.log("\n--- SEEDING TEST DATA ---");
        // 1. Create zona
        const zonaRes = await apiCall('POST', '/gerente/zonas', {
            nombre_zona: 'Terraza Test'
        });
        
        let zonaId = null;
        if (zonaRes.success && zonaRes.data) {
            zonaId = zonaRes.data.id;
        } else {
            console.log("Failed to create zona. Maybe it already exists? Fetching...");
            const zonasGet = await apiCall('GET', '/gerente/zonas');
            if (zonasGet.success && zonasGet.data && zonasGet.data.length > 0) {
                zonaId = zonasGet.data[0].id;
            }
        }
        
        // 2. Create mesa
        let validMesaId = null;
        if (zonaId) {
            const mesaRes = await apiCall('POST', '/gerente/mesas', {
                zona_id: zonaId,
                numero_mesa: Math.floor(Math.random() * 100) + 1,
                capacidad: 4
            });
            if (mesaRes.success && mesaRes.data) {
                validMesaId = mesaRes.data.id;
                console.log("Created table with ID:", validMesaId);
            }
        }
        
        // 3. Create reservacion (need to find a valid horario or just use generic POST if possible, or skip reservation if complicated)
        // Skipping reservation creation for now, we'll only test ocupaciones fully if reservation requires too many relations.
        
        // --- STAFF TESTS ---
        console.log("\n--- RESERVACIONES TESTS ---");
        const resReservaciones = await apiCall('GET', '/staff/reservaciones');
        let reservacionId = null;
        
        if (resReservaciones.success && Array.isArray(resReservaciones.data) && resReservaciones.data.length > 0) {
            reservacionId = resReservaciones.data[0].id;
            await apiCall('GET', `/staff/reservaciones/${reservacionId}`);
            // await apiCall('PATCH', `/staff/reservaciones/${reservacionId}/completar`); // Un-comment if you want to complete it
        } else {
            console.log("   No reservations found to test detail and completion.");
        }
        
        console.log("\n--- OCUPACIONES TESTS ---");
        await apiCall('GET', '/staff/ocupaciones');
        
        console.log("\nFetching available tables...");
        const mesasRes = await apiCall('GET', '/staff/mesas');
        
        if (!validMesaId && mesasRes.success && Array.isArray(mesasRes.data) && mesasRes.data.length > 0) {
            validMesaId = mesasRes.data[0].id;
        }
        
        if (validMesaId) {
            console.log("Using mesa_id: " + validMesaId);
            
            // 5. Abrir mesa (sentar cliente)
            const abrirRes = await apiCall('POST', '/staff/ocupaciones', {
                mesa_id: validMesaId,
                numero_personas: 2
            });
            
            let ocupacionId = null;
            if (abrirRes.success && abrirRes.data) {
                ocupacionId = abrirRes.data.id;
                
                // 5.5 Intentar abrir mesa ya ocupada
                console.log("\nTesting opening already occupied table...");
                await apiCall('POST', '/staff/ocupaciones', {
                    mesa_id: validMesaId,
                    numero_personas: 2
                });
                
                // 6. Cerrar mesa
                console.log("\nClosing table...");
                await apiCall('PATCH', `/staff/ocupaciones/${ocupacionId}/finalizar`);
                
                // 7. Verify table is gone
                console.log("\nVerifying table is closed...");
                await apiCall('GET', '/staff/ocupaciones');
                
            } else {
                console.log("   Failed to open table, cannot test closing.");
            }
        } else {
            console.log("   No valid tables found to test opening occupation.");
        }
    });
