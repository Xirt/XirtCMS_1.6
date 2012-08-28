<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <h2>{$xLang->headers['viewEntry']}</h2>

   <fieldset class='box-form'>

      <label>{$xLang->labels['id']}</label>
      <input type='text' name='x_id' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['error_no']}</label>
      <input type='text' name='x_error_no' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['error_msg']}</label>
      <input type='text' name='x_error_msg' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['error_src']}</label>
      <input type='text' name='x_error_src' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['error_line']}</label>
      <input type='text' name='x_error_line' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['request_ip']}</label>
      <input type='text' name='x_request_ip' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['request_agent']}</label>
      <input type='text' name='x_request_agent' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['request_uri']}</label>
      <input type='text' name='x_request_uri' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['request_method']}</label>
      <input type='text' name='x_request_method' value='' disabled='disabled' />

		<br />

      <label>{$xLang->labels['time']}</label>
      <input type='text' name='x_time' value='' disabled='disabled' />

   </fieldset>

   <div class='box-buttons'>

      <button type='button' class='close'>{$xLang->buttons['close']}</button>

   </div>

   </form>

</div>
