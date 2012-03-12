var XLang = {

   // System messages
   messages : {
      system  : 'Systeembericht',
      process : 'Uw opdracht is in behandeling.',
      loading : 'De data wordt geladen...',
      saved   : 'De data is succesvol opgeslagen.',
      success : 'De handeling is succesvol uitgevoerd.',
      removed : 'Het item is succesvol verwijderd.',
      failed  : 'De handeling kon niet worden uitgevoerd.',
      empty   : 'Er geen items gevonden voor weergave'
   },

   // Confirmations
   confirmations: {
      remove : 'Weet u zeker dat u dit item wilt verwijderen?',
      trash  : 'Weet u zeker dat u dit item naar de prullenbak wilt verplaatsen?',
      reset  : 'Weet u zeker dat u het wachtwoord van deze gebruiker wilt resetten?'
   },

   // XValidator values
   validation: {
      'required'                 : 'Dit veld dient ingevuld te worden.',
      'validate-integer'         : 'Alleen hele cijfers zijn toegestaan.',
      'validate-digits'          : 'Alleen cijfers zijn toegestaan.',
      'validate-alpha'           : 'Alleen letters (a-Z) zijn toegestaan.',
      'validate-alphanum'        : 'Alleen alfanummerieke karakters zijn toegestaan.',
      'validate-simple'          : 'Alleen simpele karakters (a-Z, 0-9, - _) zijn toegestaan.',
      'validate-email'           : 'Vul een valide emailadres in.',
      'validate-url'             : 'Vul een valide webadres (link) in.',
      'validate-currency-dollar' : 'Vul een valide bedrag in',
      'validate-phone'           : 'Vul een valide telefoonnummer in.',
      'validate-match'           : 'De waarden van deze velden moeten overeenkomen.',
      'minLength'                : 'De ingevoerde waarde is te kort.',
      'maxLength'                : 'De ingevoerde waarde is te lang.',
      'validate-password'        : 'Password is niet sterk (complex) genoeg.',
      'validate-required-check'  : 'Deze checkbox is verplicht.',
      'validate-custom-required' : 'Dit veld is verplicht.',
      'validate-one-required'    : 'Selecteer minimaal één van bovenstaande opties.',
      'validate-cc-num'          : 'Voer een geldig creditcard nummer in.'
   },

   // Errors & notifications
   errors: {
      communication: 'Er heeft zich een AJAX foutmelding voorgedaan. Neem contact op met de beheerder als dit probleem zich voor blijft doen.'
   },

   // Time / Date related
   months: ['januari', 'februari', 'maart','april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
   days  : ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag'],

   // Miscellaneous
   misc : {
      'xOfY' : 'Afbeelding {x} van {y}',
      'close': 'Sluiten'
   }

};
