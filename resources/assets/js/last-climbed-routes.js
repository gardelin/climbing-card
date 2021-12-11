import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
import Accordion from 'accordion-js';

class LastClimbedRoutes {
    constructor() {
        let lastClimedRoutes = document.querySelector(
            '.climbed-routes-container',
        );

        if (!lastClimedRoutes) return;

        let accordion = new Accordion(lastClimedRoutes);
    }
}

export default LastClimbedRoutes;

document.addEventListener('DOMContentLoaded', function () {
    window.LastClimbedRoutes = new LastClimbedRoutes();
});
