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

   <center><img src="{$xConf->siteURL}/images/cms/logo.png" alt="" /></center>

   <hr />

   <p>{$xLang->misc['intro']|sprintf:$xConf->siteURL:$xConf->siteURL}</p>

   <table>
   <tr>
      <td width='150'><font size='2'><b>{$xLang->labels['name']}</b></font></td>
      <td><font size='2'>{$data->name}</font></td>
   </tr>
   <tr>
      <td width='150'><font size='2'><b>{$xLang->labels['company']}</b><font></td>
      <td><font size='2'>{$data->company}</font></td>
   </tr>
   <tr>
      <td width='150'><font size='2'><b>{$xLang->labels['phone']}</b><font></td>
      <td><font size='2'>{$data->phone}</font></td>
   </tr>
   </table>

   <p>{$xLang->misc['outro']}</p>

   <hr />

   </font>
   </td>
</tr>
</table>

</div>

</body>

</html>