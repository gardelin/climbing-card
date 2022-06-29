import { createApp } from 'vue';
import store from './store';
import router from './router';
import language from '../language';
import App from './components/App';
const { $gettext } = language;

import LastClimbedRoutes from './last-climbed-routes';
import Counter from '../utils/Counter';

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

document.addEventListener('DOMContentLoaded', function () {
    window.LastClimbedRoutes = new LastClimbedRoutes();

    let counters = document.querySelectorAll('.counter');

    if (counters.length) {
        var observer = new IntersectionObserver(
            function (entries) {
                if (entries[0].isIntersecting === true) {
                    this.disconnect();

                    counters.forEach(counter => {
                        let type = counter.getAttribute('data-type');
                        let start = counter.getAttribute('data-start');
                        let end = counter.getAttribute('data-end');
                        let duration = counter.getAttribute('data-duration');

                        new Counter(counter, {
                            type: type,
                            start: start,
                            end: end,
                            duration: parseInt(duration),
                        });
                    });
                }
            },
            { threshold: [0.5], root: document },
        );

        observer.observe(document.querySelector('.club-stats-counters'));
    }
});
