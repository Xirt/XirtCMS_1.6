<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 TRANSITIONAL//EN">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>

<body bgcolor="#8A8A8A" leftmargin="0">

<div align="center">

<table bgcolor="#ffffff" cellpadding="15" cellspacing="0" width="600" border="0" bordercolor="#000">
<tr>
   <td>
   <font size='2'>

   <hr />

   <p>{$xLang->misc['header']|sprintf:$data->rec_name}</p>
   <p>{$xLang->misc['intro']|sprintf:$data->name:$xConf->siteURL:$xConf->siteURL}</p>

	<p><a href="{$data->url}">{$data->url}</a></p>

   <p>{$xLang->misc['outro']}</p>

   <hr />

   </font>
   </td>
</tr>
</table>

</div>

</body>

</html>