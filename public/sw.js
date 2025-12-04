self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    if (e.data) {
        const data = e.data.json();
        const options = {
            body: data.body,
            icon: data.icon || '/mnotify-logo.svg',
            badge: data.badge || '/mnotify-logo.svg',
            vibrate: [200, 100, 200],
            data: {
                url: data.data?.id ? `/payment-requests/${data.data.id}` : '/dashboard',
                ...data.data
            },
            actions: data.actions || []
        };

        e.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

self.addEventListener('notificationclick', function (e) {
    e.notification.close();
    e.waitUntil(
        clients.openWindow(e.notification.data.url || '/dashboard')
    );
});
