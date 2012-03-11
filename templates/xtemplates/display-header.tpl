
<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
{foreach from=$metatags key=property item=value}

   {if $property == 'refresh'}<meta http-equiv='refresh' content='{$value}' />
   {else}<meta name='{$property}' content='{$value}' />{/if}

{/foreach}

<title>{$title}</title>

<base href='{$xConf->baseURL}' />
<link rel='shortcut icon' href='{$xConf->baseURL}images/favicon.ico' type='image/x-icon' />

<!-- CSS / JS Includes [Start]-->
{foreach from=$stylesheets item=src}
   <link type='text/css' href='{$src}' rel='stylesheet' />
{/foreach}

<!--[if lt IE 9]>
   <link type='text/css' href='templates/xcss/msie.css' rel='stylesheet' />
<![endif]-->

{foreach from=$scripts item=src}
   <script type='text/javascript' src='{$src}'></script>
{/foreach}
<!-- CSS / JS Includes [End] -->
