import { createApp } from 'vue';
import router from './router';
import store from './store';
import language from '../language';
import App from './components/App';

class Admin {
    constructor() {
        this.app = createApp(App);
        this.app.config.devtools = true;
        this.app.config.globalProperties.window = window;

        this.app.use(router);
        this.app.use(store);
        this.app.use(language);

        this.app.mount('#app');
    }
}

export default Admin;

window.ClimbingCardAdmin = new Admin();
