<div class="space-y-6">
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Push Notifications</h3>
                <p class="mt-1 text-sm text-gray-600">Receive real-time notifications on your device when payment requests are submitted or updated</p>
            </div>
            <div class="ml-4">
                @if($checking)
                    <div class="text-sm text-gray-500">Checking...</div>
                @else
                    <button 
                        type="button"
                        id="push-toggle"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 {{ $pushEnabled ? 'bg-orange-600' : 'bg-gray-200' }}"
                        role="switch"
                        aria-checked="{{ $pushEnabled ? 'true' : 'false' }}"
                    >
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $pushEnabled ? 'translate-x-5' : 'translate-x-0' }}"></span>
                    </button>
                @endif
            </div>
        </div>

        <div class="mt-4 rounded-lg bg-orange-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-orange-700">
                        <strong>Note:</strong> Your browser will ask for permission to show notifications. Make sure to allow notifications for the best experience.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            let isProcessing = false;

            // Check actual browser subscription status
            async function checkBrowserSubscription() {
                try {
                    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                        return false;
                    }
                    const registration = await navigator.serviceWorker.ready;
                    const subscription = await registration.pushManager.getSubscription();
                    return subscription !== null;
                } catch (error) {
                    console.error('Error checking subscription:', error);
                    return false;
                }
            }

            async function initToggle() {
                const toggle = document.getElementById('push-toggle');
                if (!toggle) {
                    console.log('Toggle not found, retrying...');
                    setTimeout(initToggle, 100);
                    return;
                }

                // Check if browser subscription matches the toggle state
                const browserHasSubscription = await checkBrowserSubscription();
                const toggleState = toggle.getAttribute('aria-checked') === 'true';
                
                console.log('Browser subscription:', browserHasSubscription, 'Toggle state:', toggleState);
                
                // Sync the toggle with actual browser state
                if (browserHasSubscription !== toggleState) {
                    console.log('Syncing toggle state with browser...');
                    if (browserHasSubscription) {
                        toggle.setAttribute('aria-checked', 'true');
                        toggle.classList.remove('bg-gray-200');
                        toggle.classList.add('bg-orange-600');
                        toggle.querySelector('span').classList.remove('translate-x-0');
                        toggle.querySelector('span').classList.add('translate-x-5');
                        @this.set('pushEnabled', true);
                    } else {
                        toggle.setAttribute('aria-checked', 'false');
                        toggle.classList.remove('bg-orange-600');
                        toggle.classList.add('bg-gray-200');
                        toggle.querySelector('span').classList.remove('translate-x-5');
                        toggle.querySelector('span').classList.add('translate-x-0');
                        @this.set('pushEnabled', false);
                    }
                }

                // Remove any existing listeners
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);

                // Helper function
                function urlBase64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
                    const rawData = window.atob(base64);
                    const outputArray = new Uint8Array(rawData.length);
                    for (let i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }
                    return outputArray;
                }

                // Subscribe function
                async function subscribeToPush() {
                    try {
                        console.log('Starting subscription...');
                        
                        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                            alert('Push notifications are not supported in your browser');
                            return false;
                        }

                        // Wait for service worker to be ready
                        await navigator.serviceWorker.ready;
                        console.log('Service worker ready');

                        const permission = await Notification.requestPermission();
                        console.log('Permission:', permission);
                        
                        if (permission !== 'granted') {
                            alert('Please allow notifications to enable push notifications');
                            return false;
                        }

                        const registration = await navigator.serviceWorker.ready;
                        
                        // Check if already subscribed
                        let subscription = await registration.pushManager.getSubscription();
                        
                        if (!subscription) {
                            const response = await fetch('/api/webpush/vapid-public-key');
                            const vapidPublicKey = await response.text();
                            console.log('Got VAPID key');
                            
                            subscription = await registration.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
                            });
                            console.log('Subscribed to push');
                        } else {
                            console.log('Already subscribed, reusing subscription');
                        }

                        const subscribeResponse = await fetch('/api/webpush/subscribe', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(subscription)
                        });

                        if (!subscribeResponse.ok) {
                            throw new Error('Failed to save subscription');
                        }

                        console.log('Subscription saved');
                        return true;
                    } catch (error) {
                        console.error('Failed to subscribe:', error);
                        alert('Failed to enable notifications: ' + error.message);
                        return false;
                    }
                }

                // Unsubscribe function
                async function unsubscribeFromPush() {
                    try {
                        console.log('Starting unsubscribe...');
                        const registration = await navigator.serviceWorker.ready;
                        const subscription = await registration.pushManager.getSubscription();
                        
                        if (subscription) {
                            await fetch('/api/webpush/unsubscribe', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(subscription)
                            });
                            await subscription.unsubscribe();
                        }
                        console.log('Unsubscribed');
                        return true;
                    } catch (error) {
                        console.error('Failed to unsubscribe:', error);
                        alert('Failed to disable notifications: ' + error.message);
                        return false;
                    }
                }

                // Toggle click handler
                newToggle.addEventListener('click', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (isProcessing) {
                        console.log('Already processing...');
                        return;
                    }

                    isProcessing = true;
                    console.log('Toggle clicked');
                    
                    const isEnabled = newToggle.getAttribute('aria-checked') === 'true';
                    console.log('Current state:', isEnabled ? 'enabled' : 'disabled');
                    
                    try {
                        if (isEnabled) {
                            const success = await unsubscribeFromPush();
                            if (success) {
                                newToggle.setAttribute('aria-checked', 'false');
                                newToggle.classList.remove('bg-orange-600');
                                newToggle.classList.add('bg-gray-200');
                                newToggle.querySelector('span').classList.remove('translate-x-5');
                                newToggle.querySelector('span').classList.add('translate-x-0');
                                @this.set('pushEnabled', false);
                            }
                        } else {
                            const success = await subscribeToPush();
                            if (success) {
                                newToggle.setAttribute('aria-checked', 'true');
                                newToggle.classList.remove('bg-gray-200');
                                newToggle.classList.add('bg-orange-600');
                                newToggle.querySelector('span').classList.remove('translate-x-0');
                                newToggle.querySelector('span').classList.add('translate-x-5');
                                @this.set('pushEnabled', true);
                            }
                        }
                    } finally {
                        isProcessing = false;
                    }
                });

                console.log('Toggle initialized');
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initToggle);
            } else {
                initToggle();
            }
        })();
    </script>
</div>
