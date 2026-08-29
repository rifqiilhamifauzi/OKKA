import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

export function usePushNotifications() {
    const page = usePage();

    const urlB64ToUint8Array = (base64String) => {
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
    };

    const subscribeToPushNotifications = async () => {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.warn('Push notifications are not supported by the browser.');
            return;
        }

        try {
            // Register Service Worker
            const registration = await navigator.serviceWorker.register('/sw.js');
            
            // Wait for it to be ready
            await navigator.serviceWorker.ready;

            // Request permission
            const permission = await Notification.requestPermission();
            
            if (permission !== 'granted') {
                console.warn('Notification permission not granted.');
                return;
            }

            // Get VAPID key from Inertia props
            const vapidPublicKey = page.props.vapidPublicKey;
            
            if (!vapidPublicKey) {
                console.error('VAPID public key not found.');
                return;
            }

            const applicationServerKey = urlB64ToUint8Array(vapidPublicKey);

            // Subscribe
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: applicationServerKey
            });

            // Send subscription to backend
            await axios.post('/push/subscribe', subscription);
            console.log('Successfully subscribed to push notifications.');

        } catch (error) {
            console.error('Error during push subscription:', error);
        }
    };

    return {
        subscribeToPushNotifications
    };
}
