<div id='dvConfig' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['editConfig']}</h2>

   <fieldset class='box-form'>

      <label for='x_position'>{$xLang->labels['position']}</label>
      {html_options options=$positionList name=x_position}

      <br />

      <label for='x_ordering'>{$xLang->labels['ordering']}</label>
      {html_options options=$xLang->options['ordering'] name=x_ordering}

      <hr />

      <label>{$xLang->labels['pages']}</label>
      {html_options options=$pagesList name=pages id=pages multiple=multiple size=10}
      <input type='hidden' name='x_pages' value='' />

      <br />

      <div class='box-affect'>

         {$xLang->misc['affectAll']}

      </div>

   </fieldset>

   <div class='box-buttons'>

      <input type='hidden' name='content' value='adm_modules' />
      <input type='hidden' name='task' value='edit_config' />
      <input type='hidden' name='xid' value='' />

      <button type='submit' class='save green left'>{$xLang->buttons['save']}</button>
      <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

   </div>

   </form>

</div>
