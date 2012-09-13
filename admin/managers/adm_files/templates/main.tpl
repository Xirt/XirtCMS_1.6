<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

	<div class='box-tools'>

		<a href='javascript:;' onclick='new CreateDirectoryPanel();' title='{$xLang->headers['createDirectory']}' class='new'>{$xLang->headers['createDirectory']}</a>
		<a href='javascript:;' onclick='new UploadFilePanel();' title='{$xLang->headers['addItem']}' class='new'>{$xLang->headers['addItem']}</a>

	</div>

	<div class='box-manager'>

		<div id='box-tree'></div>
		<div id='box-files'></div>

	</div>

</div>

{include file="upload-file.tpl"}

{include file="create-directory.tpl"}

{include file="edit-item.tpl"}