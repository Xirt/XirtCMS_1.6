<div class='box-language'>

   <span class='label'>{$xLang->misc['selectLanguage']}</span>

   {foreach from=$languageList key=iso item=name}
   <div class='list-iso' alt='{$iso}'>
      <img src='../images/cms/flags/{$iso}.png' alt='{$iso}' /> {$name}
   </div>
   {/foreach}

</div>