<?php

class DefaultConfiguration {

   function __construct() {

      // SEO
      $this->title               = "XirtCMS 1.6: Simple Content Management for Online Applications";
      $this->description         = "XirtCMS: Simple Content Management for Online Applications";
      $this->keywords            = "Xirt, XirtCMS, CMS, content, management, online, easy, modular, php";
      $this->sefUrls             = false;

      // Time/Date
      $this->timeFormat          = "d/m/Y H:i";
      $this->timezone            = "Europe/Amsterdam";

      // Database
      $this->dbDSN               = "mysql:host=localhost;dbname=xirt";
      $this->dbUser              = "root";
      $this->dbPass              = "";
      $this->dbPrefix            = "xirt";

      // Misc
      $this->supportXirt         = true;
      $this->admLanguage         = "en-GB";
      $this->maxFileSize         = "2M";
      $this->lockDelay           = 15;
      $this->debugMode           = true;
      $this->combineScripts      = true;

      // Contact
      $this->adminMail           = "admin@domain.com";
      $this->fromMail            = "no-reply@domain.com";
      $this->fromName            = "XirtCMS Mailer";
      $this->replyTo             = "no-reply@domain.com";

      // Security
      $this->adminLevel          = 75;
      $this->secretKey           = '';
      $this->hashAlgorithm       = 'sha512';
      $this->maxLoginAttempts    = 3;
      $this->dbSessions          = true;
      $this->loginType           = 0;
      $this->chmod               = 0774;
      $this->yUse                = true;
      $this->yApi                = 3985;
      $this->yKey                = '';

      // Security (managers / components)
      $this->adm_staticcontent   = 75;
      $this->adm_dcontent        = 75;
      $this->adm_modules         = 75;
      $this->adm_files           = 100;
      $this->adm_components      = 75;
      $this->adm_config          = 100;
      $this->adm_templates       = 75;
      $this->adm_languages       = 75;
      $this->adm_links           = 75;
      $this->adm_users           = 75;
      $this->adm_usergroups      = 100;
      $this->adm_menus           = 75;
      $this->adm_extensions      = 100;
      $this->com_content         = 75;
      $this->com_search          = 75;

   }

}
?>
