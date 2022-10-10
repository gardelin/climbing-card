/**
 * Get full list of climbing grades.
 *
 * @param {Boolean} slashGrades e.g. 6c+/7a
 * @returns {Array}
 */
export function grades(slashGrades = false) {
    let numbers = [4, 5, 6, 7, 8, 9];
    let letters = ['a', 'a+', 'b', 'b+', 'c', 'c+'];
    let grades = [];

    if (slashGrades) letters = ['a', 'a/a+', 'a+', 'a+/b', 'b', 'b/b+', 'b+', 'b+/c', 'c', 'c+'];

    numbers.forEach((number, index) => {
        letters.forEach(letter => {
            grades.push(`${number}${letter}`);

            if (slashGrades && letter === 'c+' && !!numbers[index + 1]) {
                const nextNumber = number + 1;
                grades.push(`${number}c+/${nextNumber}a`);
            }
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
export function getSiblings(element) {
    const parent = element.parentNode;
    const children = [...parent.children];

    return children.filter(child => child !== element);
}

/**
 * Convert mysql datetime so it's readable for human.
 *
 * @param {String} datetime
 * @return {String}
 */
export function datetimeToHuman(datetime) {
    const options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
    };

    const parsed = Date.parse(datetime);
    const date = new Date(parsed);
    const localized = date.toLocaleDateString('en-GB', options);

    return localized;
}

export default { grades, getSiblings, datetimeToHuman };
