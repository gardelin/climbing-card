// require('./climbing-card')
import ClimbingCard from './ClimbingCard';
import LastClimbedRoutes from './LastClimbedRoutes';
import Counter from './Counter';
import Utils from './Utils';

document.addEventListener('DOMContentLoaded', function () {
    window.ClimbingCard = new ClimbingCard();
    window.LastClimbedRoutes = new LastClimbedRoutes();

    let counters = document.querySelectorAll('.counter');

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
        {threshold: [1]},
    );

    observer.observe(document.querySelector('.club-stats-counters'));
});
