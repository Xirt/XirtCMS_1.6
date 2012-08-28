var XLang = {

	// Update notification (older browsers)
	update : {
		'header'			: 'Wist u dat uw browser verouderd is?',
		'introduction'	: 'Om onze site zo goed mogelijk te kunnen gebruiken, raden wij u daarom aan om een up te graden naar uw favorite browser. Onderstaand vindt u een lijst met de meest populaire browsers.',
		'download'		: 'Klik op een icoon om naar de downloadpagina te gaan:',
		'continue'		: 'Doorgaan zonder update &raquo;',
		'goFirefox'		: 'Firefox 9+',
		'goChrome'		: 'Chrome 16+',
		'goExplorer'	: 'IE 8+',
		'goOpera'		: 'Opera 11+',
		'goSafari'		: 'Safari 5+'
	},

	// PDF Reader
	reader : {
		'header'			: "Downloaden van PDF bestand",
		'introduction'	: "Het bestand dat u wilt downloaden is in Portable Document Format (PDF). Er is een (gratis) PDF reader nodig om dit bestand te openen. Als u nog geen PDF reader heeft kunt u gratis Adobe Reader via onderstaande knop downloaden.",
		'download'		: "Download Adobe Reader",
		'alternative'	: "Indien u al beschikt over dergelijke software kunt u direct het opgevraagde bestand downloaden door op 'Verder gaan' te klikken.",
		'continue'		: "Verder gaan",
		'cancel'			: "Annuleren"
	},

	// System messages
	messages : {
		'system'			: 'Systeembericht',
		'process'		: 'Uw opdracht is in behandeling.',
		'loading'		: 'De data wordt geladen...',
		'saved'			: 'De data is succesvol opgeslagen.',
		'success'		: 'De handeling is succesvol uitgevoerd.',
		'removed'		: 'Het item is succesvol verwijderd.',
		'failed'			: 'De handeling kon niet worden uitgevoerd.',
		'empty'			: 'Er geen items gevonden voor weergave'
	},

	// XValidator values
	validation: {
		'required'						: 'Dit veld dient ingevuld te worden.',
		'validate-integer'			: 'Alleen hele cijfers zijn toegestaan.',
		'validate-digits'				: 'Alleen cijfers zijn toegestaan.',
		'validate-alpha'				: 'Alleen letters (a-Z) zijn toegestaan.',
		'validate-alphanum'			: 'Alleen alfanummerieke karakters zijn toegestaan.',
		'validate-simple'				: 'Alleen simpele karakters (a-Z, 0-9, - _) zijn toegestaan.',
		'validate-email'				: 'Vul een valide emailadres in.',
		'validate-url'					: 'Vul een valide webadres (link) in.',
		'validate-currency-dollar' : 'Vul een valide bedrag in',
		'validate-phone'				: 'Vul een valide telefoonnummer in.',
		'validate-match'				: 'De waarden van deze velden moeten overeenkomen.',
		'minLength'						: 'De ingevoerde waarde is te kort.',
		'maxLength'						: 'De ingevoerde waarde is te lang.',
		'validate-password'			: 'Password is niet sterk (complex) genoeg.',
		'validate-required-check'	: 'Deze checkbox is verplicht.',
		'validate-custom-required'	: 'Dit veld is verplicht.',
		'validate-one-required'		: 'Selecteer minimaal één van bovenstaande opties.',
		'validate-cc-num'				: 'Voer een geldig creditcard nummer in.'
	},
	
	// CookieConsent values
	cookies: {
		jqueryWarning							: "Developer: Caution! In order to use Cookie Consent, you need to use jQuery 1.4.4 or higher.",
		noJsBlocksWarning						: "Developer: Warning! It doesn't look like you have set up Cookie Consent correctly.  You must follow all steps of the setup guide at http://silktide.com/cookieconsent/code.  If you believe you are seeing this message in error, you can use the overridewarnings setting (see docs for more information).",
		noKeyWarning							: "Developer: Warning! You have set the plugin to only show within the EU, but you have not provided an API key for the IP Info DB.  Check the documentation at http://silktide.com/cookieconsent for more information",
		invalidKeyWarning						: "Developer: Warning! You must provide a valid API key for IP Info DB.  Check the documentation at http://silktide.com/cookieconsent for more information",
		necessaryDefaultTitle				: "Noodzakelijk",
		socialDefaultTitle					: "Sociale media",
		analyticsDefaultTitle				: "Statistieken",
		advertisingDefaultTitle				: "Advertenties",
		defaultTitle							: "Default cookie title",
		necessaryDefaultDescription 		: "Sommige cookies zijn noodzakelijk en kunnen niet uitgeschakeld worden.",
		socialDefaultDescription 			: "Facebook, Twitter en andere sociale media moeten weten wie u bent om goed te kunnen werken.",
		analyticsDefaultDescription		: "Wij meten het gebruik van deze website anoniem om onze website te verbeteren.",
		advertisingDefaultDescription		: "Advertenties worden gebaseerd op uw browsegeschiedenis en interesses.",
		defaultDescription					: "Default cookie description.",
		notificationTitle						: "Your experience on this site will be improved by allowing cookies",
		notificationTitleImplicit			: "Deze website gebruikt cookies om het gebruikersgemak te verbeteren",
		poweredBy								: "Cookie Consent plugin for the EU cookie law",
		privacyPolicy							: "Privacy policy",
		learnMore								: "Lees meer",
		seeDetails								: "details bekijken",
		seeDetailsImplicit					: "wijzig instellingen",
		hideDetails								: "details verbergen",
		savePreference							: "Voorkeuren opslaan",
		saveForAllSites						: "Opslaan voor alle websites",
		allowCookies							: "Cookies toestaan",
		allowCookiesImplicit					: "Sluiten",
		allowForAllSites	 					: "Toestaan voor alle websites",
		customCookie 							: "This website uses a custom type of cookie which needs specific approval",
		privacySettings						: "Privacy instellingen",
		privacySettingsDialogTitleA 		: "Privacy instellingen",
		privacySettingsDialogTitleB 		: "voor deze website",
		privacySettingsDialogSubtitle		: "Some features of this website need your consent to remember who you are.",
		closeWindow 							: "Sluit venster",
		changeForAllSitesLink 				: "Change settings for all websites",
		preferenceUseGlobal 					: "Use global setting",
		preferenceConsent 					: "I consent",
		preferenceDecline 					: "I decline",
		preferenceAsk							: "Ask me each time",
		preferenceAlways						: "Always allow",
		preferenceNever 						: "Never allow",
		notUsingCookies 						: "This website does not use any cookies.",
		clearedCookies 						: "Your cookies have been cleared, you will need to reload this page for the settings to have effect.",
		allSitesSettingsDialogTitleA	 	: "Privacy settings",
		allSitesSettingsDialogTitleB 		: "for all websites",
		allSitesSettingsDialogSubtitle	: "You may consent to these cookies for all websites that use this plugin.",
		backToSiteSettings					: "Back to website settings"
	},

	// Errors & notifications
	errors: {
		communication: 'Er heeft zich een AJAX foutmelding voorgedaan. Neem contact op met de beheerder als dit probleem zich voor blijft doen.'
	},

	// Time / Date related
	months: ['januari', 'februari', 'maart','april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
	days	: ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag'],

	// Miscellaneous
	misc: {		
	   'desc'   : 'Beschrijving',
		'xOfY'	: 'Afbeelding {x} van {y}',
		'close'	: 'Close'
	}

};
