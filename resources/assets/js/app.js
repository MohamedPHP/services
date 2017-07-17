var Vue = require('vue');

// for http requests
var VueResource = require('vue-resource');

Vue.use(VueResource);


Vue.http.headers.common['X-CSRF-TOKEN'] = $('#_token').attr('value');

var VueRouter = require('vue-router');

Vue.use(VueRouter);

var App = Vue.extend({});

var route = new VueRouter();


route.map({
    '/': {
        component: require('./components/pages/MainPage.vue'),
    },
    '/Categories': {
        component: require('./components/categories/Categories.vue'),
    },
    '/Cat/:cat_id/:cat_name': {
        name: '/Cat',
        component: require('./components/categories/Category.vue'),
    },
    '/AddService': {
        component: require('./components/services/AddService.vue'),
    },
    '/MyServices': {
        component: require('./components/services/MyServices.vue'),
    },
    '/ServiceDetails/:service_id/:service_name': {
        name: 'ServiceDetails',
        component: require('./components/services/ServiceDetails.vue'),
    },
    '/User/:user_id/:name': {
        name: 'User',
        component: require('./components/users/UserServices.vue'),
    },
    '/IncomingOrders': {
        component: require('./components/orders/IncomingOrders.vue'),
    },
    '/PurchaseOrders': {
        component: require('./components/orders/PurchaseOrders.vue'),
    },
    '/Order/:order_id': {
        name: 'Order',
        component: require('./components/orders/SingleOrder.vue'),
    },
    '/SendMessage/:user_id': {
        name: '/SendMessage',
        component: require('./components/messages/SendMessage.vue'),
    },
    '/Inbox': {
        name: '/Inbox',
        component: require('./components/messages/IncomingMessages.vue'),
    },
    '/SentMessages': {
        name: '/SentMessages',
        component: require('./components/messages/SentMessages.vue'),
    },
    '/UnreadMessages': {
        name: '/UnreadMessages',
        component: require('./components/messages/UnreadMessages.vue'),
    },
    '/ReadMessages': {
        name: '/ReadMessages',
        component: require('./components/messages/ReadMessages.vue'),
    },
    '/GetMessageById/:msg_id/:message_title': {
        name: '/GetMessageById',
        component: require('./components/messages/MessageDetails.vue'),
    },
    '/Wishlist': {
        name: '/Wishlist',
        component: require('./components/wishlist/Wishlist.vue'),
    },
    '/AddCredit': {
        component: require('./components/credit/AddCredit.vue'),
    },
    '/AllCharges': {
        component: require('./components/credit/AllCharges.vue'),
    },
    '/AllPayments': {
        component: require('./components/credit/AllPayments.vue'),
    },
    '/Profits': {
        component: require('./components/credit/Profits.vue'),
    },
    '/Balance': {
        component: require('./components/credit/Balance.vue'),
    },
    '/AllNotifications': {
        component: require('./components/notifications/AllNotifications.vue'),
    },

});


route.start(App, '#app-layout');
