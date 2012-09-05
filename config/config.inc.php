<?php

class DefaultConfiguration {

   function __construct() {

      // Website properties
      $this->title               = "XirtCMS 1.6: Simple Content Management for Online Applications";
      $this->description         = "XirtCMS: Simple Content Management for Online Applications";
      $this->keywords            = "Xirt, XirtCMS, CMS, content, management, online, easy, modular, php";
      $this->alternativeLinks    = true;

      // Time/Date settings
      $this->timeFormat          = "d/m/Y H:i";                                 // Format used by XirtCMS time functions
      $this->timezone            = "Europe/Amsterdam";                          // The default timezone for this website

      // Database connection
      $this->dbDSN               = "mysql:host=localhost;dbname=xirt";          // Data source name of the database
      $this->dbUser              = "root";                                      // The user to connect to the database
      $this->dbPass              = "";                                          // The password to connect to the database
      $this->dbPrefix            = "xirt";                                      // The prefix for the database tables

      // Misc
      $this->supportXirt         = true;                                        // Placeholder; updated soon
      $this->admLanguage         = "en-GB";                                     // The language settings for the administration panel
      $this->maxFileSize         = "2M";                                        // The maximum file size allowed for uploads
      $this->lockDelay           = 15;                                          // Placeholder; updated soon
      $this->debugMode           = true;                                        // Toggles between debug (test) modus and live modus
      $this->combineScripts      = true;                                        // Toggles combining of JavaScript (speeds up loading)

      // Contact
      $this->adminMail           = "admin@domain.com";                          // 
      $this->fromMail            = "no-reply@domain.com";                       // The e-mail address from which XirtCMS e-mails are sent
      $this->fromName            = "XirtCMS Mailer";                            // The name from which XirtCMS e-mails are sent
      $this->replyTo             = "no-reply@domain.com";                       // The reply-to address attached to e-mails sent by XirtCMS

      // Security options
      $this->adminLevel          = 75;                                          // The rank users need to access the administration panel
      $this->secretKey           = '';                                          // A random string used for decoding / encoding
      $this->hashAlgorithm       = 'sha512';                                    // The hash algorithm used by the XirtCMS authentication process
      $this->maxLoginAttempts    = 3;                                           // The maximum login attempts before the login process slows down
      $this->dbSessions          = true;                                        // Toggles between the usage of the database for session information
      $this->loginType           = 0;                                           // Placeholder; updated soon
      $this->chmod               = 0774;                                        // The default chmod value for folders / files created by XirtCMS
      $this->yUse                = true;                                        // Toggles Yubikey usage on/off
      $this->yApi                = 0;                                           // The Yubikey API key given to the administrator
      $this->yKey                = '';                                          // The Yubikey secret key given to the administrator

      // Security (managers / components)
      $this->adm_staticcontent   = 75;                                          // The rank users need to access this administration panel
      $this->adm_dcontent        = 75;                                          // The rank users need to access this administration panel
      $this->adm_modules         = 75;                                          // The rank users need to access this administration panel
      $this->adm_files           = 100;                                         // The rank users need to access this administration panel
      $this->adm_components      = 75;                                          // The rank users need to access this administration panel
      $this->adm_config          = 100;                                         // The rank users need to access this administration panel
      $this->adm_templates       = 75;                                          // The rank users need to access this administration panel
      $this->adm_languages       = 75;                                          // The rank users need to access this administration panel
      $this->adm_links           = 75;                                          // The rank users need to access this administration panel
      $this->adm_users           = 75;                                          // The rank users need to access this administration panel
      $this->adm_usergroups      = 100;                                         // The rank users need to access this administration panel
      $this->adm_menus           = 75;                                          // The rank users need to access this administration panel
      $this->adm_extensions      = 100;                                         // The rank users need to access this administration panel
      $this->com_content         = 75;                                          // The rank users need to access this administration panel
      $this->com_search          = 75;                                          // The rank users need to access this administration panel

   }

}
?>
