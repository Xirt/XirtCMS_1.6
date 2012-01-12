<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
<meta name='Content-Type' content='text/html;charset=UTF-8' />
<title>{if $item->meta_title}{$item->meta_title}{else}{$item->title}{/if}</title>

<script type='text/javascript'>
<!--

   window.onload = window.print;

//-->
</script>

<link rel='stylesheet' type='text/css' href='templates/xcss/xirt_front.css' />
<link rel='stylesheet' type='text/css' href='components/com_content/css/print.css' />

</head>

<body>

   <!-- xContent [Start] //-->
   <div class='x-content{$item->config->css_name}'>

      {if $item->config->show_title}
      <h1>{$item->title}</h1>
      {/if}

      {if $item->config->show_author}
      <div class='box-author'>
         <i>{$xLang->labels['author']}</i> {$item->author_name}
      </div>
      {/if}

      {if $item->config->show_created}
      <div class='box-created'>
         <i>{$xLang->labels['created']}</i> {$item->created}
      </div>
      {/if}

      {if $item->translation}
      <div class='box-translation}'>
         {$xLang->misc['translation']}
   	</div>
   	{/if}

      {$item->content}

      {if $item->config->show_modified && $item->modified}
      <div class='box-modifier'>
         <i>{$xLang->misc['modified']|sprintf:$item->modified:$item->modifier_name}</i>
      </div>
      {/if}

   </div>
   <!-- xContent [End] //-->

</body>

</html>