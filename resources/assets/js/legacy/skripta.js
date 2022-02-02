jQuery(document).ready(function () {
    // call the tablesorter plugin
    jQuery('table').tablesorter({
        // sort on the first column and third column, order asc
        sortList: [
            [3, 1],
            [5, 0],
        ],
    });
    jQuery('.clearField').clearField();
    jQuery('#thetable').tableScroll({height: 250});

    jQuery('#table_smjerovi').click(function (e) {
        jQuery('.uredi_form').lightbox_me({
            centered: true,
            closeSelect: '.close',
        });
        e.preventDefault();
    });

    jQuery('#dodaj_smjer_form').on('click', function (e) {
        jQuery('.dodaj_form').lightbox_me({
            centered: true,
            closeSelect: '.close',
        });
        e.preventDefault();
    });

    // jQuery(function () {
    //     jQuery('#datum').datepicker({
    //         dateFormat: 'yy-mm-dd',
    //     })
    //     jQuery('#dodaj_datum').datepicker({
    //         dateFormat: 'yy-mm-dd',
    //     })
    // })

    jQuery.expr[':'].econtains = function (obj, index, meta, stack) {
        return (
            (
                obj.textContent ||
                obj.innerText ||
                jQuery(obj).text() ||
                ''
            ).toLowerCase() == meta[3].toLowerCase()
        );
    };

    jQuery('tr.pojedini_smjer').click(function () {
        jQuery(this).find('.smjer').addClass('KEYsmjer');
        jQuery(this).find('.penjaliste').addClass('KEYpenjaliste');
        var smjer = jQuery(this).find('.smjer').text();
        var penjaliste = jQuery(this).find('.penjaliste').text();
        var nacin = jQuery(this).find('.nacin').text();
        var ocjena = jQuery(this).find('.ocjena').text();
        var komentar = jQuery(this).find('.komentar').text();
        var datum = jQuery(this).find('.datum').text();
        var id_podatak = jQuery(this).find('.id_podatak').text();

        jQuery('input#smjer').val(smjer);
        jQuery('input#penjaliste').val(penjaliste);
        jQuery('select#nacin option:contains(' + nacin + ')').attr(
            'selected',
            'selected',
        );
        jQuery('select#ocjena option:econtains(' + ocjena + ')').attr(
            'selected',
            'selected',
        );
        jQuery('input#komentar').val(komentar);
        jQuery('input#datum').val(datum);
        jQuery('input#id_podatak').val(id_podatak);
    });
    jQuery('tr.pojedini_smjer').hover(
        function () {
            jQuery(this).find('td').css('background', '#e6efee');
        },
        function () {
            jQuery(this).find('td').css('background', '#fff');
        },
    );
    jQuery('input#update').click(function () {
        var smjer = jQuery('input#smjer').val();
        var penjaliste = jQuery('input#penjaliste').val();
        var nacin = jQuery('select#nacin').val();
        var ocjena = jQuery('select#ocjena').val();
        var komentar = jQuery('input#komentar').val();
        var datum = jQuery('input#datum').val();
        var user = jQuery('input#user').val();
        var id_podatak = jQuery('input#id_podatak').val();
        jQuery('input').removeClass('border');
        if (smjer == '') {
            jQuery('input#smjer').addClass('border');
            var prov = 1;
        }
        if (penjaliste == '') {
            jQuery('input#penjaliste').addClass('border');
            var prov = 1;
        }
        if (nacin == '') {
            jQuery('input#nacin').addClass('border');
            var prov = 1;
        }
        if (datum == '') {
            jQuery('input#datum').addClass('border');
            var prov = 1;
        }
        if (komentar == 'Komentar') {
            var komentar = '';
        }
        if (prov == 1) {
            return;
        } else {
            ocjena = encodeURIComponent(ocjena);

            jQuery.ajax({
                url: '/wp-content/plugins/novikarton/administracija/update_sql.php',
                type: 'POST',
                data:
                    'smjer=' +
                    smjer +
                    '&penjaliste=' +
                    penjaliste +
                    '&nacin=' +
                    nacin +
                    '&ocjena=' +
                    ocjena +
                    '&komentar=' +
                    komentar +
                    '&datum=' +
                    datum +
                    '&id_podatak=' +
                    id_podatak,
                success: function () {
                    location.reload();
                },
            });
        }
    });

    jQuery('input.del').click(function () {
        var id_podatak = jQuery('input#id_podatak').val();
        jQuery.ajax({
            url: '/wp-content/plugins/climbing-card/resources/views/admin/crags/delete.php',
            type: 'POST',
            data: 'id_podatak=' + id_podatak,
            success: function () {
                location.reload();
            },
        });
    });

    jQuery('input#dodaj').click(function () {
        var dodaj_smjer = jQuery('input#dodaj_smjer').val();
        var dodaj_penjaliste = jQuery('input#dodaj_penjaliste').val();
        var dodaj_nacin = jQuery('select#dodaj_nacin').val();
        var dodaj_ocjena = jQuery('select#dodaj_ocjena').val();
        var dodaj_komentar = jQuery('input#dodaj_komentar').val();
        var dodaj_datum = jQuery('input#dodaj_datum').val();
        var user = jQuery('input#dodaj_user').val();
        jQuery('input').removeClass('border');
        if (dodaj_smjer == '') {
            jQuery('input#dodaj_smjer').addClass('border');
            var prov = 1;
        }
        if (dodaj_penjaliste == '') {
            jQuery('input#dodaj_penjaliste').addClass('border');
            var prov = 1;
        }
        if (dodaj_datum == '') {
            jQuery('input#dodaj_datum').addClass('border');
            var prov = 1;
        }
        if (dodaj_komentar == 'Komentar') {
            var dodaj_komentar = '';
        }
        if (prov == 1) {
            return;
        } else {
            dodaj_ocjena = encodeURIComponent(dodaj_ocjena);
            jQuery.ajax({
                url: '/wp-content/plugins/novikarton/administracija/dodaj_sql.php',
                type: 'POST',
                data:
                    'smjer=' +
                    dodaj_smjer +
                    '&penjaliste=' +
                    dodaj_penjaliste +
                    '&nacin=' +
                    dodaj_nacin +
                    '&ocjena=' +
                    dodaj_ocjena +
                    '&komentar=' +
                    dodaj_komentar +
                    '&datum=' +
                    dodaj_datum +
                    '&userName=' +
                    user +
                    '&penjaliste=' +
                    dodaj_penjaliste +
                    '&datum_upisa= now()',
                success: function () {
                    location.reload();
                },
            });
        }
    });
});
