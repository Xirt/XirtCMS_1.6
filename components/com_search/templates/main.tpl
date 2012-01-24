<!-- xSearch [Start] //-->
<div class='x-search'>
<form action='index.php' method='get'>

   <h1>{$xLang->titles['component']}</h1>

   <fieldset class='box-search'>

      <label>{$xLang->labels['term']}</label>
      <input type='text' name='q' value='' maxlength='64' />

      <label>{$xLang->labels['method']}</label>
      {if $xConf->search_type == 'fulltext'}{html_options name=method options=$xLang->options['fulltext']}
	   {else}{html_options name=method options=$xLang->options['normal']}{/if}

      <label>{$xLang->labels['limit']}</label>
      {html_options name=limit options=$limits}

      <div class='box-buttons'>

         <input type='hidden' name='content' value='com_search' />
         <input type='hidden' name='cid' value='{$xConf->node_id}' />

         <button type='submit'>{$xLang->buttons['search']}</button>

      </div>

   </fieldset>

   {if $data->terms}
      {include file='search-results.tpl'}
   {/if}

</form>
</div>
<!-- xSearch [End] //-->
