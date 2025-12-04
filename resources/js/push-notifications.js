export function initPushNotifications() {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        console.log('Push notifications are not supported');
        return;
    }

    // Register service worker
    navigator.serviceWorker.register('/sw.js')
        .then(registration => {
            console.log('Service Worker registered');
        })
        .catch(error => {
            console.error('Service Worker registration failed:', error);
        });
}

export async function subscribeToPush() {
    try {
        const permission = await Notification.requestPermission();

        if (permission !== 'granted') {
            throw new Error('Permission not granted for notifications');
        }

        const registration = await navigator.serviceWorker.ready;

        const response = await fetch('/api/webpush/vapid-public-key');
        const vapidPublicKey = await response.text();

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });

        // Send subscription to server
        await fetch('/api/webpush/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(subscription)
        });

        return true;
    } catch (error) {
        console.error('Failed to subscribe to push notifications:', error);
        return false;
    }
}

export async function unsubscribeFromPush() {
    try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (subscription) {
            await subscription.unsubscribe();

            // Notify server
            await fetch('/api/webpush/unsubscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(subscription)
            });
        }

        return true;
    } catch (error) {
        console.error('Failed to unsubscribe from push notifications:', error);
        return false;
    }
}

export async function checkSubscriptionStatus() {
    try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();
        return subscription !== null;
    } catch (error) {
        return false;
    }
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
