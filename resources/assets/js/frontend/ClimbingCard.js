import $ from 'jquery';

export default class ClimbingCard {
    constructor() {
        this.form = document.getElementById('climbing-card-form');

        if (!this.form) return;

        this.select = this.form ? this.form.querySelector('select[name="users"]') : null;
        this.table = document.getElementById('cards-table');
        this.filter = document.getElementById('table-filter');
        this.rowTemplate = document.getElementById('table-row');

        this.select.addEventListener('change', this.formSubmitEventHandler.bind(this));
        this.filter.addEventListener('keyup', this.filterKeyupHandler.bind(this));

        if (this.select.value) this.select.dispatchEvent(new Event('change'));
    }

    formSubmitEventHandler = e => {
        let that = this;
        e.preventDefault();

        if (!this.select.value) return;

        let apiData = climbingCardWordpressData;
        let url = apiData.rest_url + '/cards/' + this.select.value;

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                let tbody = that.table.querySelector('tbody');
                tbody.innerHTML = '';

                data.data.cards.forEach((card, index) => {
                    let row = that.rowTemplate.cloneNode(true);
                    let columns = row.content.querySelectorAll('td');
                    let style = card.style.replace(' ', '-');

                    columns[0].textContent = index + 1;
                    columns[1].textContent = card.route;
                    columns[2].textContent = card.crag;
                    columns[3].innerHTML = `<span class="dot ${style}" title="${card.style}"></span>`;
                    columns[4].textContent = card.grade;
                    columns[5].textContent = card.comment;
                    columns[6].textContent = card.climbed_at;

                    tbody.appendChild(row.content);
                });

                $(that.table).trigger('update');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    filterKeyupHandler = e => {
        var value = $(e.target).val().toLowerCase();

        $(this.table)
            .find('tbody tr')
            .filter(function () {
                if ($(this).text().toLowerCase().indexOf(value) > -1) return $(this).show();

                return $(this).hide();
            });
    };
}
