<!-- xSearch [Start] //-->
<div class='x-mod-search{$xConf->css_name}'>

	<form action='index.php' method='get'>

		<fieldset class='box-search'>

			<legend>{$xLang->titles['module']}</legend>

			<input type='hidden' name='content' value='com_search' /> <input
				type='hidden' name='task' value='search' /> <input type='hidden'
				name='cid' value='{$xConf->node_id}' /> <input type='text' name='q' />
			<button type='submit'>{$xLang->buttons['search']}</button>

		</fieldset>

	</form>

</div>
<!-- xSearch [End] //-->
