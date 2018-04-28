
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.axios = require('axios');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('sheepfold', require('./components/Sheepfold.vue'));

const app = new Vue({
    el: '#app',

    data: {
        sheepfolds: [],
        sheeps: [],
        count: 0,
        day: 0
    },

    created() {
        this.addSheeps();
        this.getCount();
        this.getSheepfolds();
    },

    ready() {
        window.setInterval(() => {
            this.count++;
            if (this.count%10==0) {
                this.day++;
                this.newSheeps(this.day);
                this.getSheepfolds();
            }
            if (this.count%100==0) {
                this.killSheep(this.day);
                this.getSheepfolds();
            }
        },500);
    },

    methods: {
        getSheepfolds() {
            axios.get('/sheepfolds').then(response => {
                this.sheepfolds = response.data;
            });
        },
        addSheeps() {
            axios.post('/sheeps').then(response => {

            });
        },
        newSheeps(day) {
            axios.post('/sheeps/'+day).then(response => {
                console.log(response.data);
            });
        },
        killSheep(day) {
            axios.post('/sheeps/'+day+'/delete').then(response => {
                console.log(response.data);
            });
        },
        getCount() {
            axios.get('/day').then(response => {
                this.day = response.data;
                this.count = this.day * 10;
            });
        }

    }

});
