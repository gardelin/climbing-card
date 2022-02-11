import Utils from './Utils';

export default class Counter {
    /**
     * Constructor
     *
     * @param {Object} element
     * @param {Object} options
     * @returns {Void}
     */
    constructor(element, options) {
        this.element = element;

        if (!this.element) throw 'Counter: Provide HTMLObject as first parameter!';

        let defaultOptions = {
            type: 'numeric',
            start: 0,
            end: 1000,
            duration: 3000,
        };
        this.options = { ...defaultOptions, ...options };

        if (this.options.type === 'numeric') {
            this.animateNumber();
        } else if (this.options.type === 'grade') {
            this.animateClimbingGrade();
        }
    }

    animateNumber() {
        const value = +this.options.end;
        const data = +this.element.innerText;

        const time = value / this.options.duration;

        if (data < value) {
            this.element.innerText = Math.ceil(data + time);
            setTimeout(this.animateNumber.bind(this), 1);
        } else {
            this.element.innerText = value;
        }
    }

    animateClimbingGrade() {
        let grades = Utils.grades();
        let end = this.options.end;
        let duration = 300;
        let flag = true;

        grades.forEach(grade => {
            if (flag) {
                if (grade === end) flag = false;

                setTimeout(() => {
                    this.element.innerText = grade;
                }, (duration += 30));
            }
        });
    }
}
