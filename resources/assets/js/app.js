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
    '/IncomingOrders': {
        component: require('./components/orders/IncomingOrders.vue'),
    },
    '/PurchaseOrders': {
        component: require('./components/orders/PurchaseOrders.vue'),
    },
});


route.start(App, '#app-layout');
