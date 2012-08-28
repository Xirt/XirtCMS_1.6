<form action='index.php' method='post' class='xForm' id='xForm'>

	<div class="box-container">

		<h1>{$xLang->titles['component']}</h1>

		<div class='box-warning'>{$xLang->misc['saveWarning']}</div>

		<ul class='box-togglers'>
			<li>{$xLang->panels['site']}</li>
			<li>{$xLang->panels['time']}</li>
			<li>{$xLang->panels['database']}</li>
			<li>{$xLang->panels['contact']}</li>
			<li>{$xLang->panels['security']}</li>
			<li>{$xLang->panels['misc']}</li>
		</ul>

		<div class='box-buttons'>
			<button type='submit' class='left green save'>{$xLang->buttons['save']}</button>
			<button type='reset' class='right red reset'>{$xLang->buttons['cancel']}</button>
		</div>

		<ul class='box-content' style='display: none;'>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['site']}</h2>

					<label for='x_title'>{$xLang->labels['title']}</label> <input
						type='text' name='x_title' value='{$xConf->title}' /> <br /> <label
						for='x_description'>{$xLang->labels['METADesc']}</label>
					<textarea name='x_description' rows='1' cols='1'>{$xConf->description}</textarea>

					<br /> <label for='x_keywords'>{$xLang->labels['METAKeys']}</label>
					<textarea name='x_keywords' rows='1' cols='1'>{$xConf->keywords}</textarea>

					<br /> <label for='x_sef_links'>{$xLang->labels['SEFLinks']}</label>
					<input type='radio' name='x_sef_links' value='1' {if $xConf->sefUrls}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['positive']}</span> <input
						type='radio' name='x_sef_links' value='0' {if !$xConf->sefUrls}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['negative']}</span>

				</div></li>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['time']}</h2>

					<label for='x_time_zone'>{$xLang->labels['timeZone']}</label>
					{html_options name='x_time_zone' options=$timezoneList
					selected=$xConf->timezone} <br /> <label for='x_time_format'>{$xLang->labels['timeFormat']}</label>
					<input type='text' name='x_time_format'
						value='{$xConf->timeFormat}' class='required' />

				</div></li>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['database']}</h2>

					<label for='x_db_dsn'>{$xLang->labels['dbDSN']}</label> <input
						type='text' name='x_db_dsn' value='{$xConf->dbDSN}'
						class='required' /> <br /> <label for='x_db_user'>{$xLang->labels['dbUsername']}</label>
					<input type='text' name='x_db_user' value='{$xConf->dbUser}'
						class='required' /> <br /> <label for='x_db_pass'>{$xLang->labels['dbPassword']}</label>
					<input type='password' name='x_db_pass' value='' /> <br /> <label
						for='x_db_prefix'>{$xLang->labels['dbPrefix']}</label> <input
						type='text' name='x_db_prefix' value='{$xConf->dbPrefix}'
						class='required' />

				</div></li>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['contact']}</h2>

					<label for='x_admin_mail'>{$xLang->labels['adminMail']}</label> <input
						type='text' name='x_admin_mail' value='{$xConf->adminMail}'
						class='required validate-mail' /> <br /> <label for='x_from_mail'>{$xLang->labels['senderMail']}</label>
					<input type='text' name='x_from_mail' value='{$xConf->fromMail}'
						class='required validate-mail' /> <br /> <label for='x_from_name'>{$xLang->labels['senderName']}</label>
					<input type='text' name='x_from_name' value='{$xConf->fromName}'
						class='required' /> <br /> <label for='x_replyto'>{$xLang->labels['replyTo']}</label>
					<input type='text' name='x_replyto' value='{$xConf->replyTo}'
						class='required validate-mail' />

				</div></li>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['security']}</h2>

					<label for='x_admin_level'>{$xLang->labels['adminLevel']}</label>
					{html_options name='x_admin_level' options=$rankList
					selected=$xConf->adminLevel} <br /> <label for='x_login_type'>{$xLang->labels['loginType']}</label>
					{html_options name='x_login_type' options=$tList
					selected=$xConf->loginType} <br /> <label for='x_login_max'>{$xLang->labels['maxLogin']}</label>
					<input type='text' name='x_login_max'
						value='{$xConf->maxLoginAttempts}' /> <br /> <label
						for='x_dbsessions'>{$xLang->labels['dbSessions']}</label> <input
						type='radio' name='x_dbsessions' value='1' {if $xConf->dbSessions}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['positive']}</span> <input
						type='radio' name='x_dbsessions' value='0' {if !$xConf->dbSessions}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['negative']}</span> <br />

					<label for='x_chmod'>{$xLang->labels['mode']}</label> <input
						type='text' name='x_chmod' value='{$xConf->chmod|decoct}'
						maxlength='3' /> <br />
					<hr />

					<label for='x_y_support'>{$xLang->labels['YSupport']}</label> <input
						type='radio' name='x_y_use' value='1' {if $xConf->yUse}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['positive']}</span> <input
						type='radio' name='x_y_use' value='0' {if !$xConf->yUse}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['negative']}</span> <br />

					<label for='x_y_api'>{$xLang->labels['YAPI']}</label> <input
						type='text' name='x_y_api' value='{$xConf->yApi}' maxlength='32' />

					<br /> <label for='x_y_hash'>{$xLang->labels['YHash']}</label> <input
						type='text' name='x_y_hash' value='{$xConf->yKey}' maxlength='32' />

					<div class='box-advanced'>

						<button type='button' id='xAdvanced' class='settings'>{$xLang->buttons['advanced']}</button>
						{$xLang->misc['advancedWarning']}

					</div>

				</div></li>

			<li>
				<div class='box-fieldset'>

					<h2>{$xLang->panels['misc']}</h2>

					<label for='x_dbsessions'>{$xLang->labels['debugMode']}</label> <input
						type='radio' name='x_debug' value='1' {if $xConf->debugMode}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['positive']}</span> <input
						type='radio' name='x_debug' value='0' {if !$xConf->debugMode}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['negative']}</span> <br />

					<label for='x_support'>{$xLang->labels['promotion']}</label> <input
						type='radio' name='x_support' value='1' {if $xConf->supportXirt}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['positive']}</span> <input
						type='radio' name='x_support' value='0' {if !$xConf->supportXirt}checked='checked'{/if}
					/><span class='label-radio'>{$xLang->options['negative']}</span> <br />

					<label for='x_language'>{$xLang->labels['language']}</label>
					{html_options name='x_language' options=$lList
					selected=$xConf->admLanguage} <br /> <label for='x_uploadsize'>{$xLang->labels['uploadSize']}</label>
					<input type='text' name='x_uploadsize'
						value='{$xConf->maxFileSize}' maxlength='32' /> <br /> <label
						for='x_relock'>{$xLang->labels['lockDelay']}</label> <input
						type='text' name='x_relock' value='{$xConf->lockDelay}'
						maxlength='32' />

				</div></li>

			</lu>

			<input type='hidden' name='content' value='adm_config' />
			<input type='hidden' name='task' value='save' />
	
	</div>

</form>

{include file="form-edit.tpl"}
