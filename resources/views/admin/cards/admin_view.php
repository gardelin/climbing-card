<?php

$repo = new \ClimbingCard\Repositories\Cards;
$current_user = wp_get_current_user();
$korisnik = $current_user->user_login;

?>

<div class="gore">
    <div class="gore_lijevo">
        <table class="statistika" border="0" cellspacing="1" cellpadding="0">
            <tbody>
                <tr class="row0">
                    <td class="naslov" colspan="2">STATISTIKA</td>
                </tr>
                <tr class="row2">
                    <td class="tr1" colspan="1"><b>NAJVEĆA OCJENA:</b></td>
                    <td class="tr1" colspan="1"><?php $repo->najveca_ocjena($korisnik) ?> (OS &gt;<?php $repo->najveca_ocjena_nacin($korisnik, 'on sight') ?>, FL&gt;<?php $repo->najveca_ocjena_nacin($korisnik, 'flash') ?>)</td>
                </tr>
                <tr class="row2">
                    <td class="tr1" colspan="1"><b>UKUPNO SMJEROVA:</b></td>
                    <td class="tr1" colspan="1"><?php $repo->ukupno_smjerova($korisnik) ?></td>
                </tr>
                <tr class="row2">
                    <td class="tr1" colspan="1"><b>ON SIGHT:</b></td>
                    <td class="tr1" colspan="1"><?php $repo->racunaj_smjerove($korisnik, 'on sight'); ?></td>
                </tr>
                <tr class="row2">
                    <td class="tr1" colspan="1"><b>FLASH:</b></td>
                    <td class="tr1" colspan="1"><?php $repo->racunaj_smjerove($korisnik, 'flash'); ?></td>
                </tr>
                <tr class="row2">
                    <td class="tr1" colspan="1"><b>RED POINT:</b></td>
                    <td class="tr1" colspan="1"><?php $repo->racunaj_smjerove($korisnik, 'red point'); ?></td>
                </tr>
            </tbody>
        </table>
        <a id="dodaj_smjer_form" href="#">DODAJ SMJER</a>
    </div>
    <div class="gore_sredina">
        <table class="statistika po_ocjenama" id="thetable" cellspacing="0">
            <tr class="row0">
                <td class="naslov" colspan="5"><b>PO OCJENAMA</b></td>
            </tr>
            <tr>
                <td><b>Ocjena</b></td>
                <td><b>Ukupno</b></td>
                <td><b>On sight</b></td>
                <td><b>Flash</b></td>
                <td><b>Red point</b></td>
            </tr>
            <?php $repo->po_ocjenama($korisnik) ?>
        </table>
    </div>
    <div class='smjerovi_graf'>
        <script>
            jQuery(document).ready(function() {
                jQuery('#legend-colors-graph').tufteBar({
                    data: [
                        <?php $repo->generiraj_graf($korisnik) ?>
                    ],
                    axisLabel: function(index) {
                        return this[1].label
                    },
                    legend: {
                        data: ["on sight", "flash", "red point"]
                    }
                });
            });
        </script>
        <div id='legend-colors-graph' class='graph' style='width:100%; height: 200px;'></div>

    </div>
    <div class="legend_smjerovi">
        <span class="on_sight">On sight</span>
        <span class="flash">Flash</span>
        <span class="red_point">Red point</span>
    </div>
</div>
<?php
$repo->get_all_korisnik($korisnik);
?>
<div class="forme dodaj_form">
    <span class="close">×</span>
    <form id="dodaj">
        <h2>Dodaj smjer</h2>
        <fieldset>
            <input type="hidden" name="dodaj_user" id="dodaj_user" value="<?php echo $korisnik; ?>" />
            <input type="text" name="dodaj_smjer" id="dodaj_smjer" class="clearField" value="Smjer" size="19" />
            <input type="text" name="dodaj_penjaliste" id="dodaj_penjaliste" class="clearField" value="Penjaliste" size="19" />
            <select name="dodaj_nacin" id="dodaj_nacin">
                <option>on sight</option>
                <option>flash</option>
                <option>red point</option>
            </select>
            <select name="dodaj_ocjena" id="dodaj_ocjena">
                <option>3a</option>
                <option>3b</option>
                <option>3c</option>
                <option>4a</option>
                <option>4b</option>
                <option>4c</option>
                <option>5a</option>
                <option>5b</option>
                <option>5c</option>
                <option>5c+</option>
                <option>5c+/6a</option>
                <option>6a</option>
                <option>6a/a+</option>
                <option>6a+</option>
                <option>6a+/6b</option>
                <option>6b</option>
                <option>6b/b+</option>
                <option>6b+</option>
                <option>6b+/6c</option>
                <option>6c</option>
                <option>6c/c+</option>
                <option>6c+</option>
                <option>6c+/7a</option>
                <option>7a</option>
                <option>7a/a+</option>
                <option>7a+</option>
                <option>7a+/7b</option>
                <option>7b</option>
                <option>7b/b+</option>
                <option>7b+</option>
                <option>7b+/7c</option>
                <option>7c</option>
                <option>7c/c+</option>
                <option>7c+</option>
                <option>7c+/8a</option>
                <option>8a</option>
                <option>8a/a+</option>
                <option>8a+</option>
                <option>8a+/8b</option>
                <option>8b</option>
                <option>8b/b+</option>
                <option>8b+</option>
                <option>8b+/8c</option>
                <option>8c</option>
                <option>8c/c+</option>
                <option>8c+</option>
                <option>8c+/9a</option>
                <option>9a</option>
                <option>9a/a+</option>
                <option>9a+</option>
                <option>9a+/9b</option>
                <option>9b</option>
                <option>9b/b+</option>
                <option>9b+</option>
                <option>9b+/9c</option>
                <option>9c</option>
            </select>
            <input type="text" name="dodaj_komentar" id="dodaj_komentar" class="clearField" value="Komentar" size="19" />
            <input type="date" name="dodaj_datum" id="dodaj_datum" value="" size="19" />
        </fieldset>
        <fieldset class="butts">
            <input type="button" class="update butt" id="dodaj" value="Potvrdi " />
        </fieldset>
    </form>
</div>
<div class="forme uredi_form">
    <span class="close">×</span>
    <form id="uredi">
        <h2>Uredi smjer</h2>
        <fieldset>
            <input type="hidden" name="user" id="user" value="<?php echo $korisnik; ?>" />
            <input type="text" name="smjer" id="smjer" value="" size="19" />
            <input type="hidden" name="id_podatak" id="id_podatak" value="" size="19" />
            <input type="text" name="penjaliste" id="penjaliste" value="" size="19" />
            <select name="nacin" id="nacin">
                <option>on sight</option>
                <option>flash</option>
                <option>red point</option>
            </select>
            <select name="ocjena" id="ocjena">
                <option>3a</option>
                <option>3b</option>
                <option>3c</option>
                <option>4a</option>
                <option>4b</option>
                <option>4c</option>
                <option>5a</option>
                <option>5b</option>
                <option>5c</option>
                <option>5c+</option>
                <option>5c+/6a</option>
                <option>6a</option>
                <option>6a/a+</option>
                <option>6a+</option>
                <option>6a+/6b</option>
                <option>6b</option>
                <option>6b/b+</option>
                <option>6b+</option>
                <option>6b+/6c</option>
                <option>6c</option>
                <option>6c/c+</option>
                <option>6c+</option>
                <option>6c+/7a</option>
                <option>7a</option>
                <option>7a/a+</option>
                <option>7a+</option>
                <option>7a+/7b</option>
                <option>7b</option>
                <option>7b/b+</option>
                <option>7b+</option>
                <option>7b+/7c</option>
                <option>7c</option>
                <option>7c/c+</option>
                <option>7c+</option>
                <option>7c+/8a</option>
                <option>8a</option>
                <option>8a/a+</option>
                <option>8a+</option>
                <option>8a+/8b</option>
                <option>8b</option>
                <option>8b/b+</option>
                <option>8b+</option>
                <option>8b+/8c</option>
                <option>8c</option>
                <option>8c/c+</option>
                <option>8c+</option>
                <option>8c+/9a</option>
                <option>9a</option>
                <option>9a/a+</option>
                <option>9a+</option>
                <option>9a+/9b</option>
                <option>9b</option>
                <option>9b/b+</option>
                <option>9b+</option>
                <option>9b+/9c</option>
                <option>9c</option>
            </select>
            <input type="text" name="komentar" id="komentar" class="clearField" value="Komentar" size="19" />
            <input type="date" name="datum" id="datum" value="" size="19" />
        </fieldset>
        <fieldset class="butts">
            <input type="button" class="del butt" value="Obriši " />
            <input type="button" class="update butt" id="update" value="Potvrdi " />
        </fieldset>
    </form>
</div>