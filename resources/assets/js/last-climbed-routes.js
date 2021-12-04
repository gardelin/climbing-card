import jQuery from 'jquery'
window.$ = window.jQuery = jQuery
import Accordion from 'accordion-js'

class LastClimbedRoutes {
    constructor() {
        let accordion = new Accordion('.climbed-routes-container')
    }
}

export default LastClimbedRoutes

document.addEventListener('DOMContentLoaded', function () {
    window.LastClimbedRoutes = new LastClimbedRoutes()
})
