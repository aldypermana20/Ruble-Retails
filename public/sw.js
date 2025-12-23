const CACHE_NAME = 'ruble-retails-v3';
const urlsToCache = [
    '/',
    '/offline.html',
    '/css/app.css',
    '/js/app.js',
    '/manifest.json',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png'
];

// Install Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
    self.skipWaiting();
});

// Activate Service Worker (Clean up old caches)
self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch Data
self.addEventListener('fetch', event => {
    // Strategi untuk Navigasi Halaman (HTML): Network First, lalu Cache, lalu Offline Page
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Jika berhasil fetch dari network, simpan salinannya ke cache (Dynamic Caching)
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }
                    var responseToCache = response.clone();
                    caches.open(CACHE_NAME)
                        .then(cache => {
                            cache.put(event.request, responseToCache);
                        });
                    return response;
                })
                .catch(() => {
                    // Jika offline, coba ambil dari cache. Jika tidak ada, tampilkan halaman offline.
                    return caches.match(event.request)
                        .then(response => {
                            return response || caches.match('/offline.html');
                        });
                })
        );
    } else {
        // Strategi untuk Aset (CSS, JS, Images): Cache First, lalu Network
        event.respondWith(
            caches.match(event.request)
                .then(response => {
                    return response || fetch(event.request);
                })
        );
    }
});
