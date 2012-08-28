<div id='dvSettings' style='display: none;'>

	<div class='xForm'>

		<h2>{$xLang->headers['advancedSettings']}</h2>

		<fieldset class='box-form'>

			<legend>{$xLang->headers['defaultComponents']}</legend>

			<label for='adm_scontent'>{$xLang->managers['staticContent']}</label>
			{html_options name=adm_scontent id=adm_scontent options=$rankList
			selected=$xConf->adm_staticcontent} <br /> <label
				for='adm_dcategories'>{$xLang->managers['dynamicContent']}</label>
			{html_options name=adm_dcategories id=adm_dcategories
			options=$rankList selected=$xConf->adm_dcontent} <br /> <label
				for='adm_modules'>{$xLang->managers['modules']}</label>
			{html_options name=adm_modules id=adm_modules options=$rankList
			selected=$xConf->adm_modules} <br /> <label for='adm_files'>{$xLang->managers['files']}</label>
			{html_options name=adm_files id=adm_files options=$rankList
			selected=$xConf->adm_files} <br /> <label for='adm_components'>{$xLang->managers['components']}</label>
			{html_options name=adm_components id=adm_components options=$rankList
			selected=$xConf->adm_components} <br /> <label for='adm_config'>{$xLang->managers['config']}</label>
			{html_options name=adm_config id=adm_config options=$rankList
			selected=$xConf->adm_config} <br /> <label for='adm_templates'>{$xLang->managers['templates']}</label>
			{html_options name=adm_templates id=adm_templates options=$rankList
			selected=$xConf->adm_templates} <br /> <label for='adm_languages'>{$xLang->managers['languages']}</label>
			{html_options name=adm_languages id=adm_languages options=$rankList
			selected=$xConf->adm_languages} <br /> <label for='adm_links'>{$xLang->managers['links']}</label>
			{html_options name=adm_links id=adm_links options=$rankList
			selected=$xConf->adm_links} <br /> <label for='adm_users'>{$xLang->managers['users']}</label>
			{html_options name=adm_users id=adm_users options=$rankList
			selected=$xConf->adm_users} <br /> <label for='adm_usergroups'>{$xLang->managers['usergroups']}</label>
			{html_options name=adm_usergroups id=adm_usergroups options=$rankList
			selected=$xConf->adm_usergroups} <br /> <label for='adm_menus'>{$xLang->managers['menus']}</label>
			{html_options name=adm_menus id=adm_menus options=$rankList
			selected=$xConf->adm_menus} <br /> <label for='adm_extensions'>{$xLang->managers['extensions']}</label>
			{html_options name=adm_extensions id=adm_extensions options=$rankList
			selected=$xConf->adm_extensions}

		</fieldset>

		<fieldset class='box-form'>

			<legend>{$xLang->headers['customComponents']}</legend>

			{foreach from=$componentList key=component item=details} <label
				for='{$component}'>{$details->name}</label> {if
			isset($xConf->$component)} {html_options name=$component
			id=$component options=$rankList selected=$xConf->$component} {else}
			{html_options name=$component id=$component options=$rankList
			selected=100} {/if} <br /> {/foreach}

		</fieldset>

		<div class='box-buttons'>

			<button type='button' class='close'>{$xLang->buttons['close']}</button>

		</div>

	</div>

</div>
