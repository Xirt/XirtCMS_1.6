<form action='index.php' method='post' class='xForm' id='xForm'>

<h1>{$xLang->titles['component']}</h1>

<fieldset class='box-form'>

   <legend>{$xLang->headers['editSettings']}</legend>

   <hr />

   <label for='item_css_name'>{$xLang->labels['CSSName']}</label>
   <input type='text' name=item_css_name value='{$xConf->css_name}' maxlength='64' class='validate-simple' />

   <br />

   <label for='item_show_title'>{$xLang->labels['showTitle']}</label>
   {html_options name=item_show_title id=item_show_title options=$options selected=$xConf->show_title}

   <br />

   <label for='item_show_author'>{$xLang->labels['showAuthor']}</label>
   {html_options name=item_show_author id=item_show_author options=$options selected=$xConf->show_author}

   <br />

   <label for='item_show_created'>{$xLang->labels['showCreated']}</label>
   {html_options name=item_show_created id=item_show_created options=$options selected=$xConf->show_created}

   <br />

   <label for='item_show_modified'>{$xLang->labels['showModified']}</label>
   {html_options name=item_show_modified id=item_show_modified options=$options selected=$xConf->show_modified}

   <br />

   <label for='item_back_icon'>{$xLang->labels['backIcon']}</label>
   {html_options name=item_back_icon id=item_back_icon options=$options selected=$xConf->back_icon}

   <br />

   <label for='item_download_icon'>{$xLang->labels['downloadIcon']}</label>
   {html_options name=item_download_icon id=item_download_icon options=$options selected=$xConf->download_icon}

   <br />

   <label for='item_print_icon'>{$xLang->labels['printIcon']}</label>
   {html_options name=item_print_icon id=item_print_icon options=$options selected=$xConf->print_icon}

   <br />

   <label for='item_mail_icon'>{$xLang->labels['mailIcon']}</label>
   {html_options name=item_mail_icon id=item_mail_icon options=$options selected=$xConf->mail_icon}

   <hr />

   <div class='box-buttons'>

      <input type='hidden' name='content' value='com_content' />
      <input type='hidden' name='task' value='save' />

      <button type='submit' class='save left green'>{$xLang->buttons['save']}</button>
      <button type='button' class='reset right red' id='xReset'>{$xLang->buttons['reset']}</button>

   </div>

</fieldset>

<fieldset class='box-form preview'>

   <legend>{$xLang->headers['preview']}</legend>

   <div class='box-preview'>

      <h5 id='show_title'>XXXXX XXX XX XX</h5>
      <span id='show_author'><b>XXXXXXX:</b> XXX XXXXXX<br /></span>
      <span id='show_created'><b>XXXXXXX:</b> XX/XX/XXXX<br /></span>

      x xx x xx xx xx x x x x xx xx xxxxx xxx x xxxx xx xxx xxx xxxx x xx
      xxxxxxxx xxxx xxxx xxxx x x xxxx xxxxxxxxxx x x xx x x xxx x xxxxxx
      xx xxxxx xxx xx xxxxxxx xxxx xx xxxxxxxx x x xxx xxxx xxxx x xxx x
      xx xxxxx xxxxx x xxx xxxxxxxx x xxxx x xxx xxxxxx xxxx x xxx xxxxxx
      xx x x xx xx x x x xxxxxxxxxx xxxxxxx xx xxxxx x x xxxx xxxx xxxxxx
      x x xx x xx xxxxxxxxxxxxxxx x xxxxxxx x xxxxxxx xx x xxxx xx xx x x
      xxxxx xxxxxx xxxxxx xxxxxxx xxxxxxxxx x xxx xxxx xxxxxx x xxxxx x
      xxx xx xxxxx xx xx xxxxxxxx x x xx xx xxxx xxxx xxxxx xx xxxxxxxxx
      x x xx xx xxxxx x x xxxx xx x x xxxxxxxx x xx x xxxx xx x xxxx xxx
      xxxx xxx xxxxxxxxxxxx xxxxx x xxxxxxx xxxx x x xx xxx x xxxxxxxxxxx
      x xxxxxxxx xxxx xxxxxx xxxxx x xxxxxxx xx x xxx x x x xxxx x xxxx x
      xxxxxxxxx x xx xxxxx xxx xxxxxx x xx xxxxxxxxxxxx xxxxx x x x xx xx
      xxxxxx xx x xxx x xxx xxx xx xx xxxxxxx xxx xxxx xx xx x x xxxx x
      xx xxxxxxx xxxx x x xxxx xx xxxxx xxxx xx x x x xx xxx xxx xxxxxx
      xxxx xxx xx x xxx x x x x xxx x xxxxxxxx xxxx xx xx x xx xxxxxxx
      xxxxxxxxx x xx xx x xxxxxxx x xxxxx xxx xx x xxxxx xxxx xxxx x xxxx
      xxxxxx x x x xx x xxxx x xxxx xxxxxx x x xx x xxx xxx xxxx xxxxxx
      xxxxxxxxxxx xx x x x xxxx x xxx x x x x xx x xxx xxx x x x x xx xx

      <div id='show_modified'><i>XXXX XXXXX XX XXXX XXXXXXXX XXX XX</i></div>

      <div class='box-icons'>

          <div class='icon' id='back_icon'></div>

          <div class='icon' id='download_icon'></div>

          <div class='icon' id='print_icon'></div>

          <div class='icon' id='mail_icon'></div>

      </div>

   </div>

</fieldset>

</form>
