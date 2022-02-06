import ClimbingCard from './ClimbingCard';
import LastClimbedRoutes from './LastClimbedRoutes';
import Counter from '../utils/Counter';

document.addEventListener('DOMContentLoaded', function () {
    window.ClimbingCard = new ClimbingCard();
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
            {threshold: [0.5], root: document},
        );

        observer.observe(document.querySelector('.club-stats-counters'));
    }
});
