 

require('./bootstrap');

window.Vue = require('vue');

 import router from './router'
import vuetify from './vuitify'

import App from './components/AppComponent'

 

  new Vue({
    el: '#app',
    router,
    vuetify,
    components:{
        'app':App
    },
});
