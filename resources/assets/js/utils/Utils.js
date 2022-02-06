import $ from 'jquery';

export default class Utils {
    /**
     * Get full list of climbing grades.
     *
     * @returns {Array}
     */
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

    /**
     * Get element siblings
     *
     * @param {*} element
     * @param {*} parent
     * @returns
     */
    static getSiblings(element) {
        const parent = element.parentNode;
        const children = [...parent.children];

        return children.filter(child => child !== element);
    }
}
