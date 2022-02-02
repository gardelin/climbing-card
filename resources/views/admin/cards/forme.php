<?php echo 'Korisnik: ' . $current_user->user_firstname . ' ' . $current_user->user_lastname . "<br/>"; ?>

<div class="forme">
	<span class="close">×</span>
	<form id="uredi">
		<h2>Uredi smjer</h2>
		<fieldset>
			<input type="hidden" name="user" id="user" value="<?php echo $korisnik; ?>" />
			<input type="text" name="smjer" id="smjer" value="" size="19" />
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
			<input type="text" name="komentar" id="komentar" value="" size="19" />
			<input type="date" name="datum" id="datum" value="" size="19" />
		</fieldset>
		<fieldset class="butts">
			<input type="button" class="butt" id="update" value="Potvrdi " />
		</fieldset>
	</form>
</div>