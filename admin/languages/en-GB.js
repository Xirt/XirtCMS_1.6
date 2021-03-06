var XLang = {

   // System messages
   messages : {
      system  : 'System notice',
      process : 'Your request is being processed.',
      loading : 'The data is being loaded...',
      saved   : 'The data was saved succesfully.',
      success : 'Your request has been processed successfully.',
      removed : 'The item was removed succesfully',
      failed  : 'Failed to complete request.',
      empty   : 'There are no items to display'
   },

   // Confirmations
   confirmations: {
      remove : 'Are you sure that you want to remove this item?',
      trash  : 'Are you sure that you want to move this item to the bin?',
      reset  : 'Are you sure that you want to reset this users password?'
   },

   // XValidator values
   validation: {
      'required'                 : 'This field is required.',
      'validate-integer'         : 'Only whole numerical characters allowed.',
      'validate-digits'          : 'Only numerical characters allowed.',
      'validate-alpha'           : 'Only alphabetical characters allowed.',
      'validate-alphanum'        : 'Only alphanumeric characters allowed.',
      'validate-simple'          : 'Only simple characters (a-Z, 0-9, - _) allowed.',
      'validate-email'           : 'Please use a valid e-mailaddress.',
      'validate-url'             : 'Please use a valid webaddress.',
      'validate-currency-dollar' : 'Please fill in a valid amount.',
      'validate-phone'           : 'Please fill in a valid phone number.',
      'validate-match'           : 'This value should match the previous field.',
      'minLength'                : 'The inserted value is too short.',
      'maxLength'                : 'The inserted value is too long.',
      'validate-password'        : 'Password is not a valid format.',
      'validate-required-check'  : 'This checkbox is required.',
      'validate-custom-required' : 'This field is required.',
      'validate-one-required'    : 'Please select one of the above options.',
      'validate-cc-num'          : 'Please enter a valid creditcard number.'
   },

   // Errors & notifications
   errors: {
      communication: 'A communication error has occured. Please contact an administrator if this problem persists.'
   },

   // Time / Date related
   months: ['January', 'February', 'March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
   days  : ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],

   // Miscellaneous
   misc: {
      'xOfY' : 'Image {x} of {y}',
      'close': 'Close'
   }

};
