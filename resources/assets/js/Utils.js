import $ from 'jquery';

export default class Utils {
    static grades() {
        let numbers = [4, 5, 6, 7, 8, 9];
        let letters = ['a', 'a+', 'b', 'b+', 'c', 'c+'];
        let grades = [];

        numbers.forEach(number => {
            letters.forEach(letter => {
                grades.push(`${number}${letter}`);
            });
        });

        return grades;
    }

    static isElementInView(element, fullyInView) {
        var pageTop = $(window).scrollTop();
        var pageBottom = pageTop + $(window).height();
        var elementTop = $(element).offset().top;
        var elementBottom = elementTop + $(element).height();

        if (fullyInView === true) {
            return pageTop < elementTop && pageBottom > elementBottom;
        } else {
            return elementTop <= pageBottom && elementBottom >= pageTop;
        }
    }
}
