import { createApp } from 'vue';
import router from './router';
import store from './store';
import language from '../language';
import App from './components/App';
import axios from 'axios';
import SvgVue from 'svg-vue3';
const { $gettext } = language;

class Admin {
    constructor() {
        this.app = createApp(App);
        this.app.config.devtools = true;
        this.app.config.globalProperties.window = window;
        this.app.config.globalProperties.$gettext = $gettext;

        this.app.use(router);
        this.app.use(store);
        this.app.use(language);
        this.app.use(SvgVue);

        axios.defaults.headers.common['X-WP-Nonce'] = window.climbingcards.nonce;

        this.app.mount('#app');
    }
}

export default Admin;

window.ClimbingCardAdmin = new Admin();
