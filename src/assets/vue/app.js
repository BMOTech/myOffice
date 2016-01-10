// main.js
var Vue = require('vue'),
    App = require('./app.vue');

new Vue({
    el: 'body',
    components: {
        app: App
    }
})