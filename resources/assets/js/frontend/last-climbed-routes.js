import Accordion from 'accordion-js';

export default class LastClimbedRoutes {
    constructor() {
        let lastClimedRoutes = document.querySelector('.climbed-routes-container');

        if (!lastClimedRoutes) return;

        new Accordion(lastClimedRoutes);
    }
}
