import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

export default class ClimbingCard {
    constructor() {
        this.form = document.getElementById('climbing-card-form');

        if (!this.form) return;

        this.select = this.form
            ? this.form.querySelector('select[name="users"]')
            : null;
        this.table = document.getElementById('journals-table');
        $(this.table).tablesorter();

        this.filter = document.getElementById('table-filter');

        $(this.filter).on(
            'keyup',
            function (e) {
                var value = $(e.target).val().toLowerCase();

                $(this.table)
                    .find('tbody tr')
                    .filter(function () {
                        if ($(this).text().toLowerCase().indexOf(value) > -1)
                            return $(this).show();

                        return $(this).hide();
                    });
            }.bind(this),
        );

        this.rowTemplate = document.getElementById('table-row');

        this.events();
    }

    events() {
        this.form.addEventListener('submit', this.formSubmitEventHandler);
    }

    formSubmitEventHandler = e => {
        e.preventDefault();

        if (!this.select.value) return;

        let apiData = climbingCardWordpressData;
        let url = apiData.rest_url + '/journals/' + this.select.value;
        let that = this;

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

                data.data.journals.forEach((journal, index) => {
                    let row = that.rowTemplate.cloneNode(true);
                    let columns = row.content.querySelectorAll('td');
                    let style = journal.nacin.replace(' ', '-');

                    columns[0].textContent = index + 1;
                    columns[1].textContent = journal.smjer;
                    columns[2].textContent = journal.penjaliste;
                    columns[3].innerHTML = `<span class="dot ${style}" title="${journal.nacin}"></span>`;
                    columns[4].textContent = journal.ocjena;
                    columns[5].textContent = journal.komentar;
                    columns[6].textContent = journal.datum;

                    tbody.appendChild(row.content);
                });

                $(that.table).trigger('update');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
}
