<div id='dvItem' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<h2>{$xLang->headers['editItem']}</h2>

		<fieldset class='box-form'>

			<label for='x_path'>{$xLang->labels['location']}</label>
			<select name='x_path' id='x-path'></select>

			<br />

			<label for='x_name'>{$xLang->labels['name']}</label>
			<input type='text' name='x_name' id='x_name' value='' />

		</fieldset>

		<h3>{$xLang->headers['editRights']}</h3>

		<fieldset class='box-form' id='box-permissions'>

			<table cellspacing='1'>
			<tr>
				<th></th>
				<th>{$xLang->labels['read']}</th>
				<th>{$xLang->labels['write']}</th>
				<th>{$xLang->labels['execute']}</th>
			</tr>
			<tr>
				<th>{$xLang->labels['owner']}</th>
				<td><input type='checkbox' id='user_r' disabled='disabled' /></td>
				<td><input type='checkbox' id='user_w' disabled='disabled' /></td>
				<td><input type='checkbox' id='user_x' disabled='disabled' /></td>
			</tr>
			<tr>
				<th>{$xLang->labels['group']}</th>
				<td><input type='checkbox' id='grp_r' disabled='disabled' /></td>
				<td><input type='checkbox' id='grp_w' disabled='disabled' /></td>
				<td><input type='checkbox' id='grp_x' disabled='disabled' /></td>
			</tr>
			<tr>
				<th>{$xLang->labels['global']}</th>
				<td><input type='checkbox' id='glob_r' disabled='disabled' /></td>
				<td><input type='checkbox' id='glob_w' disabled='disabled' /></td>
				<td><input type='checkbox' id='glob_x' disabled='disabled' /></td>
			</tr>
			</table>

		</fieldset>

		<div class='box-buttons'>

			<input type='hidden' name='content' value='adm_files' />
			<input type='hidden' name='task' value='edit_item' />
			<input type='hidden'	name='path' value='' />

			<button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
			<button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

		</div>

	</form>

</div>
