
<!-- xCookies [Start] //-->
<script type="text/javascript">
<!--

{literal}cc.initialise({
	cookies: {
		necessary: {}{/literal}
		{if $xConf->cookie_analytics},analytics: {literal}{}{/literal}{/if}
		{if $xConf->cookie_ads},advertising: {literal}{}{/literal}{/if}
		{if $xConf->cookie_social},social: {literal}{}{/literal}{/if}

{literal}	},
	settings: {{/literal}
		consenttype: "{$xConf->consent}",
		style: "{$xConf->style}",
		useSSL: {$xConf->ssl},
		refreshOnConsent: {$xConf->refresh},
		bannerPosition: "{$xConf->position_bar}",
		tagPosition: "{$xConf->position_tab}",
		onlyshowbanneronce: {$xConf->showonce},
		hideallsitesbutton: true,
		disableallsites: true,
		hideprivacysettingstab: {$xConf->hidetab},
		overridewarnings: true
{literal}   	}
});{/literal}

//-->
</script>
<!-- xCookies [End] //-->