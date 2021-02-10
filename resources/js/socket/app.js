import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'qwerty',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});


window.Echo.join('users')
    .here((e) => {
    })
    .joining((user) => {
    })
    .listen(('PostCreated'), (data) => {
        console.log(123)
    })
    .leaving((user) => {
    })

window.Echo.private('ticket-created')
    .listen('TicketCreated', (e) => {
        axios.get(`tickets/notification/${e.ticket.id}`,).then(res => {
            if (res.status === 200) {
                notifyMe(res.data.message)
            }
        }).catch(err => {
            console.log(err);
            console.log('error')
        })
    });

function notifyMe(notification) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
        var notification = new Notification(notification);
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                var notification = new Notification(notification);
            }
        });
    }

    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}