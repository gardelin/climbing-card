import Accordion from 'accordion-js';

export default class LastClimbedRoutes {
    constructor() {
        let lastClimedRoutes = document.querySelector('.climbed-routes-container');

        if (!lastClimedRoutes) return;

        let accordion = new Accordion(lastClimedRoutes);
    }
}
