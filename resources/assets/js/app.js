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
    // '/': {
    //     component: "",
    // },
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

});


route.start(App, '#app-layout');
