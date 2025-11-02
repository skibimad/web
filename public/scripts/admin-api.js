// Admin API Helper for Laravel Backend
// This replaces localStorage with Laravel API calls

const API_BASE = '/api';

// Generic API helper functions
async function apiGet(endpoint) {
    const response = await fetch(`${API_BASE}${endpoint}`);
    if (!response.ok) throw new Error(`API error: ${response.statusText}`);
    return await response.json();
}

async function apiPost(endpoint, data) {
    const response = await fetch(`${API_BASE}${endpoint}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(data)
    });
    if (!response.ok) throw new Error(`API error: ${response.statusText}`);
    return await response.json();
}

async function apiPut(endpoint, data) {
    const response = await fetch(`${API_BASE}${endpoint}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(data)
    });
    if (!response.ok) throw new Error(`API error: ${response.statusText}`);
    return await response.json();
}

async function apiDelete(endpoint) {
    const response = await fetch(`${API_BASE}${endpoint}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    });
    if (!response.ok) throw new Error(`API error: ${response.statusText}`);
    return response.status === 204 ? null : await response.json();
}

// Heroes API
const HeroesAPI = {
    getAll: () => apiGet('/heroes'),
    get: (id) => apiGet(`/heroes/${id}`),
    create: (data) => apiPost('/heroes', data),
    update: (id, data) => apiPut(`/heroes/${id}`, data),
    delete: (id) => apiDelete(`/heroes/${id}`)
};

// Episodes API
const EpisodesAPI = {
    getAll: () => apiGet('/episodes'),
    get: (id) => apiGet(`/episodes/${id}`),
    create: (data) => apiPost('/episodes', data),
    update: (id, data) => apiPut(`/episodes/${id}`, data),
    delete: (id) => apiDelete(`/episodes/${id}`)
};

// Blog Posts API
const BlogPostsAPI = {
    getAll: (includeUnpublished = false) => apiGet(`/blog-posts${includeUnpublished ? '?all=1' : ''}`),
    get: (id) => apiGet(`/blog-posts/${id}`),
    create: (data) => apiPost('/blog-posts', data),
    update: (id, data) => apiPut(`/blog-posts/${id}`, data),
    delete: (id) => apiDelete(`/blog-posts/${id}`),
    getRecent: (limit = 3) => apiGet(`/blog-posts-recent?limit=${limit}`)
};

// Helper functions for compatibility with existing admin code
function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
}

function generateId(prefix = '') {
    return prefix + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`);
}
