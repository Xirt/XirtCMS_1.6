<h1>{$xLang->titles['component']}</h1>

<div class='box-xlist'>

   <div class='box-tools'>
      <a href='javascript:;' onclick='' title='' class='new'></a>
      <a href='javascript:;' onclick='' title='' class='adduser'></a>
   </div>

   {XListBuilder::showTable(array('id', 'error_no', 'error_msg', 'time', 'options'))}

</div>

{include file="form-entry.tpl"}

<fieldset class='box-form'>
	<legend>Admin log</legend>

	<div class='box-notice'>Currently {$errors->count} entries in logfile</div>

	{if $errors->attention}
	<div class='box-warning'>
		<img src='../images/cms/icons/warning.png' alt=''> Administrator has been notified!
		[<a href='javascript:;' onclick="XManager.clearNotification();">X</a>]
	</div>
	{/if}

	<ul>
		<li>[<a href='javascript:;' onclick="XManager.showLogPanel();">View</a>]</li>
		<li>[<a href='javascript:;' onclick="XManager.clearLog();">Empty</a>]</li>
	</ul>

</fieldset>
