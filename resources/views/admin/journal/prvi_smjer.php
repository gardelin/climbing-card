<a id="dodaj_smjer_form" href="#">DODAJ SMJER</a>
<div class="forme dodaj_form">
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
				<option>6a+</option>
				<option>6a+/6b</option>
				<option>6b+</option>
				<option>6b+/6c</option>
				<option>6c</option>
				<option>6c/6c+</option>
				<option>6c+</option>
				<option>6c+/7a</option>
				<option>7a</option>
				<option>7a+</option>
				<option>7a+/7b</option>
				<option>7b</option>
				<option>7b+</option>
				<option>7b+/7c</option>
				<option>7c+</option>
				<option>7c+/8a</option>
				<option>8a</option>
				<option>8a+</option>
				<option>8a+/8b</option>
				<option>8b</option>
				<option>8b+</option>
				<option>8b+/8c</option>
				<option>8c+</option>
				<option>8c+/9a</option>
				<option>9a</option>
				<option>9a+</option>
				<option>9b</option>
				<option>9c</option>
			</select>
			<input type="text" name="dodaj_komentar" id="dodaj_komentar" class="clearField" value="Komentar" size="19" />
			<input type="text" name="dodaj_datum" id="dodaj_datum" value="" size="19" />
		</fieldset>
		<fieldset class="butts">
			<input type="button" class="update butt" id="dodaj" value="Potvrdi " />
		</fieldset>
	</form>
</div>