<div id='dvConfig' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editConfig']}</h2>

   <fieldset class='box-form'>

      <label for='x_css_name'>{$xLang->labels['CSSName']}</label>
      <input type='text' name='x_css_name' maxlength='16' class='validate-simple' />

      <br />

      <label for='x_amount_full'>{$xLang->labels['showContent']}</label>
      <input type='text' name='x_amount_full' value='0' maxlength='3' class='small validate-integer' />

      <!--
      <br />

      <label for='x_amount_summary'>{$xLang->labels['showSummaryOnly']}</label>
      <input type='text' name='x_amount_summary' value='0' maxlength='3' class='small validate-integer' />
      //-->

      <br />

      <label for='x_amount_title'>{$xLang->labels['showTitleOnly']}</label>
      <input type='text' name='x_amount_title' value='0' maxlength='3' class='small validate-integer' />

      <br />

      <label for='x_show_archive'>{$xLang->labels['archive']}</label>
      {html_options name=x_show_archive options=$archiveList}

      <br />

      <label for='x_order_col'>{$xLang->labels['column']}</label>
      {html_options name=x_order_col options=$columnList}

      <br />

      <label for='x_order'>{$xLang->labels['ordering']}</label>
      {html_options name=x_order options=$orderList}

   </fieldset>

   <fieldset class='box-form'>

      <label for='x_show_title'>{$xLang->labels['showTitle']}</label>
      {html_options name=x_show_title options=$visibilityList}

      <br />

      <label for='x_show_author'>{$xLang->labels['showAuthor']}</label>
      {html_options name=x_show_author options=$visibilityList}

      <br />

      <label for='x_show_created'>{$xLang->labels['showCreated']}</label>
      {html_options name=x_show_created options=$visibilityList}

      <br />

      <label for='x_show_modified'>{$xLang->labels['showModified']}</label>
      {html_options name=x_show_modified options=$visibilityList}

      <br />

      <label for='x_back_icon'>{$xLang->labels['backIcon']}</label>
      {html_options name=x_back_icon options=$visibilityList}

      <br />

      <label for='x_download_icon'>{$xLang->labels['downloadIcon']}</label>
      {html_options name=x_download_icon options=$visibilityList}

      <br />

      <label for='x_print_icon'>{$xLang->labels['printIcon']}</label>
      {html_options name=x_print_icon options=$visibilityList}

      <br />

      <label for='x_mail_icon'>{$xLang->labels['mailIcon']}</label>
      {html_options name=x_mail_icon options=$visibilityList}

   </fieldset>

   <fieldset class='box-form'>

      <div class='box-affect'>

         <input type='checkbox' name='affect_all' value='1' />
         {$xLang->misc['affectAll']}

      </div>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_categories' />
      <input type='hidden' name='task' value='edit_config' />
      <input type='hidden' name='xid' value='' />
      <input type='hidden' name='id' value='' />

      <button type='submit' class='submit green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
