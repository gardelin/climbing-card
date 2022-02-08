import {createApp} from 'vue';
import router from './router';
import store from './store';
import App from './components/App';

class Admin {
    constructor() {
        this.app = createApp(App);
        this.app.config.devtools = this.debug;
        this.app.config.globalProperties.window = window;
        this.app.use(router);
        this.app.use(store);
        this.app.mount('#app');
    }
}

export default Admin;

window.ClimbingCardAdmin = new Admin();
