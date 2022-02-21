import Vue from 'vue'
import router from '../router'
import App from '../Composents/App'



 const vue = new Vue({
    el: '#app',
    router,
    components: {
        App
    }
});