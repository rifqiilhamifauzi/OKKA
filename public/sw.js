self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon || '/icon.png',
            badge: msg.badge || '/badge.png',
            data: msg.data || {},
            actions: msg.actions || []
        }));
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    // This looks to see if the current is already open and
    // focuses if it is
    event.waitUntil(
        clients.matchAll({
            type: "window"
        })
        .then(function (clientList) {
            var targetUrl = event.notification.data.url || '/';
            for (var i = 0; i < clientList.length; i++) {
                var client = clientList[i];
                if (client.url == targetUrl && 'focus' in client)
                    return client.focus();
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
