<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
{XPage::addScript('template/js/menu.js')}
{XPage::addStylesheet('template/css/main.css', 1)}
{XInclude::header()}
</head>

<body>

<div class='box-header'>

	<a href='http://www.xirtcms.com' title='{$xLang->version}' class='logo' rel='external'>
	<img src='../images/cms/logo.png' alt='{$xLang->version}' />
	</a>

   <div class='box-menu'>

      <a href='javascript:;' class='menu-item'>{$xLang->menus['content']}</a>
      <a href='javascript:;' class='menu-item'>{$xLang->menus['components']}</a>
      <a href='javascript:;' class='menu-item'>{$xLang->menus['configuration']}</a>
      <a href='javascript:;' class='menu-item'>{$xLang->menus['management']}</a>

   </div>

   <!-- [Start] Content Subbox //-->
   <div class='box-submenu submenu' id='sM_content' style='display: none;'>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_content');">
         <img src='../images/cms/managers/content.png' alt="{$xLang->entries['Content']}" />

         <h4>{$xLang->entries['Content']}</h4>
         {$xLang->entries['ContentTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_categories');">
         <img src='../images/cms/managers/categories.png' alt="{$xLang->entries['Categories']}" />

         <h4>{$xLang->entries['Categories']}</h4>
         {$xLang->entries['CategoriesTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_modules');">
         <img src='../images/cms/managers/modules.png' alt="{$xLang->entries['Modules']}" />

         <h4>{$xLang->entries['Modules']}</h4>
         {$xLang->entries['ModulesTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_files');">
         <img src='../images/cms/managers/files.png' alt="{$xLang->entries['Files']}" />

         <h4>{$xLang->entries['Files']}</h4>
         {$xLang->entries['FilesTxt']}
      </div>

   </div>
   <!-- [End] Content Subbox //-->

   <!-- [Start] Componenten Subbox //-->
   <div class='box-submenu submenu' id='sM_components' style='display: none;'>

   {foreach from=$components item=item}
      <div class='submenu-item' onclick="document.location.assign('index.php?content={$item->type}');">
      <img src='components/{$item->type}/icon.png' alt="{$item->name}" />

      <h4>{$item->name}</h4>

      </div>
   {/foreach}

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_components');">
         <img src='../images/cms/managers/extensions.png' alt="{$xLang->entries['Components']}" />

         <h4>{$xLang->entries['Components']}</h4>
         {$xLang->entries['ComponentsTxt']}
      </div>

   </div>
   <!-- [End] Componenten Subbox //-->

   <!-- [Start] Config Subbox //-->
   <div class='box-submenu submenu' id='sM_config' style='display: none;'>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_config');">
         <img src='../images/cms/managers/settings.png' alt="{$xLang->entries['Website']}" />

         <h4>{$xLang->entries['Website']}</h4>
         {$xLang->entries['WebsiteTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_templates');">
         <img src='../images/cms/managers/templates.png' alt="{$xLang->entries['Templates']}" />

         <h4>{$xLang->entries['Templates']}</h4>
         {$xLang->entries['TemplatesTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_languages');">
         <img src='../images/cms/managers/languages.png' alt="{$xLang->entries['Languages']}" />

         <h4>{$xLang->entries['Languages']}</h4>
         {$xLang->entries['LanguagesTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_links');">
         <img src='../images/cms/managers/links.png' alt="{$xLang->entries['Links']}" />

         <h4>{$xLang->entries['Links']}</h4>
         {$xLang->entries['LinksTxt']}
      </div>

   </div>
   <!-- [End] Config Subbox //-->

   <!-- [Start] Manage Subbox //-->
   <div class='box-submenu submenu' id='sM_manage' style='display: none;'>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_users');">
         <img src='../images/cms/managers/users.png' alt="{$xLang->entries['Users']}" />

         <h4>{$xLang->entries['Users']}</h4>
         {$xLang->entries['UsersTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_usergroups');">
         <img src='../images/cms/managers/usergroups.png' alt="{$xLang->entries['Usergroups']}" />

         <h4>{$xLang->entries['Usergroups']}</h4>
         {$xLang->entries['UsergroupsTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_menus');">
         <img src='../images/cms/managers/menus.png' alt="{$xLang->entries['Menus']}" />

         <h4>{$xLang->entries['Menus']}</h4>
         {$xLang->entries['MenusTxt']}
      </div>

      <div class='submenu-item' onclick="document.location.assign('index.php?content=adm_extensions');" style='display: none;'>
         <img src='../images/cms/managers/extensions.png' alt="{$xLang->entries['Extensions']}" />

         <h4>{$xLang->entries['Extensions']}</h4>
         {$xLang->entries['ExtensionsTxt']}
      </div>

   </div>
   <!-- [End] Manage Subbox //-->

   <div class='box-options'>
      <a href='index.php' title="{$xLang->buttons['home']}" class='home'>{$xLang->buttons['home']}</a>
      <a href='http://www.xirtcms.com' title="{$xLang->buttons['support']}" class='support' rel='external'>{$xLang->buttons['support']}</a>
      <a href='index.php?content=adm_login&amp;task=logout' title="{$xLang->buttons['logout']}" class='logout'>{$xLang->buttons['logout']}</a>
   </div>

</div>

<div class='box-container'>
{XInclude::component()}
</div>

</body>

</html>