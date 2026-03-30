class MetraAPI {
    static get baseUrl() {
        let url = window.API_URL || '';
        if (url.endsWith('/')) {
            url = url.slice(0, -1);
        }
        return url;
    }

    static get fileUrl() {
        return window.FILE_URL || '';
    }

    static getFileUrl(path) {
        if (!path) return '';
        if (path.startsWith('http')) return path;
        
        const cleanPath = path.replace(/^\/?(storage\/)?/, '');
        // Usamos storage directamente
        return `${this.fileUrl}/storage/${cleanPath}`;
    }

    static getHeaders(customHeaders = {}) {
        const token = localStorage.getItem('token');
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            ...customHeaders
        };

        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }
        return headers;
    }

    static async handleResponse(response) {
        if (response.status === 401 && window.location.pathname !== '/login') {
            localStorage.removeItem('token');
            window.location.href = '/login?session_expired=true';
            throw new Error('Sesión expirada');
        }

        const isJson = response.headers.get('content-type')?.includes('application/json');
        const data = isJson ? await response.json() : await response.text();

        if (!response.ok) {
            const errorObj = new Error((data && data.message) || response.statusText || 'Error en la petición');
            errorObj.status = response.status;
            errorObj.data = data;
            throw errorObj;
        }

        return data; 
    }

    static formatEndpoint(endpoint) {
        return endpoint.startsWith('/') ? endpoint : `/${endpoint}`;
    }

    static async get(endpoint) {
        const response = await fetch(`${this.baseUrl}${this.formatEndpoint(endpoint)}`, {
            method: 'GET',
            headers: this.getHeaders()
        });
        return this.handleResponse(response);
    }

    static async post(endpoint, body, customHeaders = {}) {
        const isFormData = body instanceof FormData;
        
        if (isFormData) {
            customHeaders['Content-Type'] = undefined;
        }

        const headers = this.getHeaders(customHeaders);
        if (isFormData) delete headers['Content-Type']; 

        const response = await fetch(`${this.baseUrl}${this.formatEndpoint(endpoint)}`, {
            method: 'POST',
            headers: headers,
            body: isFormData ? body : JSON.stringify(body)
        });
        return this.handleResponse(response);
    }

    static async put(endpoint, body) {
        const response = await fetch(`${this.baseUrl}${this.formatEndpoint(endpoint)}`, {
            method: 'PUT',
            headers: this.getHeaders(),
            body: JSON.stringify(body)
        });
        return this.handleResponse(response);
    }

    static async delete(endpoint) {
        const response = await fetch(`${this.baseUrl}${this.formatEndpoint(endpoint)}`, {
            method: 'DELETE',
            headers: this.getHeaders()
        });
        return this.handleResponse(response);
    }
}

if (typeof window !== 'undefined') {
    window.MetraAPI = MetraAPI;
}

export default MetraAPI;
