<!-- xContent [Start] //-->
<div class='x-content{$item->config->css_name}'>

   {if $item->config->show_title}
   <h1>{$item->title}</h1>
   {/if}

   {if $item->config->show_author}
   <div class='box-author'>
      <i>{$xLang->labels['author']}</i> {$item->author_name}
   </div>
   {/if}

   {if $item->config->show_created}
   <div class='box-created'>
      <i>{$xLang->labels['created']}</i> {$item->created}
   </div>
   {/if}

   {if $item->translation}
   <div class='box-translation}'>
      {$xLang->misc['translation']}
	</div>
	{/if}

   {$item->content}

   {if $item->config->show_modified && $item->modified}
   <div class='box-modifier'>
      <i>{$xLang->misc['modified']|sprintf:$item->modified:$item->modifier_name}</i>
   </div>
   {/if}

   <div class='box-options'>

      {if $item->config->back_icon}
      <a href='{$xConf->baseURL}' title="{$xLang->buttons['back']}" class='back' id='xBack'>
         <img src='components/com_content/templates/images/back.png' alt="{$xLang->buttons['back']}" />
         <span>{$xLang->buttons['back']}</span>
      </a>
      {/if}

      {if $item->config->download_icon}
      <a href='index.php?content=com_content&amp;task=show_pdf&amp;id={$item->xid}' title="{$xLang->buttons['download']}" class='download' rel='nofollow'>
         <img src='components/com_content/templates/images/pdf.png' alt="{$xLang->buttons['download']}" />
         <span>{$xLang->buttons['download']}</span>
      </a>
      {/if}

      {if $item->config->print_icon}
      <a href='index.php?content=com_content&amp;task=show_print&amp;id={$item->xid}' title="{$xLang->buttons['print']}" class='print' rel='nofollow'>
         <img src='components/com_content/templates/images/print.png' alt="{$xLang->buttons['print']}" />
         <span>{$xLang->buttons['print']}</span>
      </a>
      {/if}

      {if $item->config->mail_icon}
      <a href='index.php?content=com_helper&amp;task=no_javascript' title="{$xLang->buttons['mail']}" class='mail' rel='nofollow' id='xMail'>
         <img src='components/com_content/templates/images/mail.png' alt="{$xLang->buttons['mail']}" />
         <span>{$xLang->buttons['mail']}</span>
      </a>
      {/if}

   </div>

   {if $item->config->mail_icon}
   <div id='xTellAFriend' style='display: none;'>

      <form action='index.php' method='post' class='xForm'>

      <h2>{$xLang->headers['mail']}</h2>

      <fieldset class='box-form'>

         <label for='x_name'>{$xLang->labels['yourName']}</label>
         <input type='text' name='x_name' value='' class='required' maxlength='50' />

         <br />

         <label for='x_rec_name'>{$xLang->labels['recipientName']}</label>
         <input type='text' name='x_rec_name' value='' class='required' maxlength='50' />

         <br />

         <label for='x_rec_mail'>{$xLang->labels['recipientMail']}</label>
         <input type='text' name='x_rec_mail' value='' class='required validate-email' maxlength='50' />

      </fieldset>

      <div class='box-buttons'>

         <input type='hidden' name='content' value='com_content' />
         <input type='hidden' name='task' value='send_mail' />
         <input type='hidden' name='id' value='{$item->xid}' />

         <button type='submit'>{$xLang->buttons['submit']}</button>
         <button type='button' class='close'>{$xLang->buttons['close']}</button>

      </div>

      </form>

   </div>
   {/if}

</div>
<!-- xContent [End] //-->
