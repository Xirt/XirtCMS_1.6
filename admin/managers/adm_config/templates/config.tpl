<?php

class DefaultConfiguration {

   function __construct() {

      // SEO
      $this->title               = "{$config->title}";
      $this->description         = "{$config->description}";
      $this->keywords            = "{$config->keywords}";
      $this->sefUrls             = {if $config->sefUrls}true{else}false{/if};

      // Time/Date
      $this->timeFormat          = "{$xConf->timeFormat}";
      $this->timezone            = "{$xConf->timezone}";

      // Database
      $this->dbDSN               = "{$config->dbDSN}";
      $this->dbUser              = "{$config->dbUser}";
      $this->dbPass              = "{$config->dbPass}";
      $this->dbPrefix            = "{$config->dbPrefix}";

      // Misc
      $this->supportXirt         = {if $config->supportXirt}true{else}false{/if};
      $this->admLanguage         = "{$config->admLanguage}";
      $this->maxFileSize         = "{$config->maxFileSize}";
      $this->lockDelay           = {$config->lockDelay};
      $this->debugMode           = {if $config->debug}true{else}false{/if};

      // Contact
      $this->adminMail           = "{$config->adminMail}";
      $this->fromMail            = "{$config->fromMail}";
      $this->fromName            = "{$config->fromName}";
      $this->replyTo             = "{$config->replyTo}";

      // Security
      $this->adminLevel          = {$config->adminLevel};
      $this->secretKey           = "{$xConf->secretKey}";
      $this->hashAlgorithm       = "{$xConf->hashAlgorithm}";
      $this->maxLoginAttempts    = {$config->maxLoginAttempts};
      $this->dbSessions          = {if $config->dbSessions}true{else}false{/if};
      $this->loginType           = {$config->loginType};
      $this->chmod               = 0{$config->chmod};
      $this->yUse                = {if $config->yUse}true{else}false{/if};
      $this->yApi                = {$config->yApi};
      $this->yKey                = "{$config->yKey}";

      // Security (managers / components)
      {foreach from=$security key=setting item=value}
      $this->{$setting} = {$value};
      {/foreach}

   }

}
?>