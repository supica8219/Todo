// Define cache name
const cacheName = 'test';

const filesToCache = []
console.log(cacheName);

// Service worker installation event
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.addAll(filesToCache);
    })
  );
  // Skip waiting and install the service worker immediately
  self.skipWaiting();
});

// Service worker activation event
self.addEventListener('activate', function(event) {
  event.waitUntil(
    // Get all cache keys
    caches.keys().then(function(keyList) {
      // Map through the keys and delete all caches that don't match the current cache name
      return Promise.all(keyList.map(function(key) {
        if (key !== cacheName) {
          console.log("caches_deleted")
          return caches.delete(key);
        }
      }));
    })
    .then(function() {
      // Claim all clients for the service worker
      return self.clients.claim();
    })
  );
});

// Fetch event
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      // If the request matches something in the cache, return it
      if (response) {
        return response;
      }
      // Otherwise, fetch the request from the network
      return fetch(event.request);
    })
  );
});
