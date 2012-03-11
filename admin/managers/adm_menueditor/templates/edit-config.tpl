<div id='dvConfig' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

      <h2>{$xLang->headers['editConfig']}</h2>

      <fieldset class='box-form'>

         <label for='x_css_name'>{$xLang->labels['CSSName']}</label>
         <input type='text' name='x_css_name' id='x_css_name' maxlength='16' class='validate-simple' />

         <br />

         <label for='x_image'>{$xLang->labels['image']}</label>
         <input type='text' name='x_image' id='x_image' maxlength='128' /> <br />

         <label for='x_link_type'>{$xLang->labels['linkType']}</label>
         {html_options options=$xLang->options['linktypes'] name=x_link_type id=x_link_type}

         <div class='box-affect'>

            <input type='checkbox' name='affect_all' value='1' class='checkbox' />
            {$xLang->misc['affectAll']}

         </div>

      </fieldset>

      <h3>{$xLang->labels['currentLink']}</h3>
      <fieldset class='box-form' id='linkBox'>

         <select name='x_links_0' id='x_links_0' size='15'>
         {foreach from=$contents key=key item=category}

            <optgroup label='{$category->name}'>
               {foreach from=$category->toArray() key=url item=title}
               <option value='{$url}'>{$title}</option>
               {/foreach}
            </optgroup>

			{/foreach}
         </select>

			{html_options options=$categories name=x_links_1 id=x_links_1 size=15}
         {html_options options=$components name=x_links_2 id=x_links_2 size=15}

         <input type='text' name='x_link' id='x_link' />

      </fieldset>

      <div class='box-buttons'>

         <input type='hidden' name='content' value='adm_menueditor' />
         <input type='hidden' name='task' value='edit_config' />
         <input type='hidden' name='xid' value='' />
         <input type='hidden' name='id' value='' />

         <button type='submit' class='submit green left'>{$xLang->buttons['save']}</button>
         <button type='button' class='close red right'>{$xLang->buttons['cancel']}</button>

      </div>

   </form>

</div>
