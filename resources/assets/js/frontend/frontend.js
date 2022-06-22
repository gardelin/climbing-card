import { createApp } from 'vue';
import store from './store';
import router from './router';
import language from '../language';
import App from './components/App';
const { $gettext } = language;

class Frontend {
    constructor() {
        this.app = createApp(App);
        this.app.config.devtools = true;
        this.app.config.globalProperties.window = window;
        this.app.config.globalProperties.$gettext = $gettext;

        this.app.use(router);
        this.app.use(store);
        this.app.use(language);

        this.app.mount('#app');
    }
}

export default Frontend;

window.ClimbingCardFrontend = new Frontend();
