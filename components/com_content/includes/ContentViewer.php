<?php

/**
 * Library to show content items
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ContentViewer {

   /**
    * Shows a content item in regular format (HTML)
    *
    * @param $item The ContentItem to display
    */
   public static function showContent($item) {
      global $xConf, $xCom, $xLang;

      // Set META information
      XContent::addMetaTag("keywords",    $item->meta_keywords);
      XContent::addMetaTag("description", $item->meta_description);
      XContent::addScriptTag('components/com_content/js/main.js');

      XContent::extendTitle($item->title);
      if (trim($item->meta_title)) {
         XContent::setTitle($item->meta_title);
      }

      // Show template
      $tpl = new Template();
      $tpl->assign('item', $item);
      $tpl->assign('xConf', $xConf);
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('version-html.tpl');

   }


   /**
    * Shows a content item in PDF format (using TCPDF)
    *
    * @param $item The ContentItem to display
    */
   public static function showPDFVersion($item) {
      global $xLang, $xCom, $xConf;

      require_once('classes/tcpdf/config/lang/eng.php');
      require_once('classes/tcpdf/tcpdf.php');

      // Create new PDF
      $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT);
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
      $pdf->setPrintHeader(false);
      $pdf->AddPage();

      // Set META information
      $pdf->SetTitle($item->title);
      $pdf->SetCreator($xLang->version);
      $pdf->SetSubject($item->meta_description);
      $pdf->SetKeywords($item->meta_keywords);

      // Draw title (optional)
      if ($item->config->show_title) {

         $title = sprintf('<h1>%s</h1>', $item->title);
         $pdf->writeHTML($title, false);

      }

      // Draw author (optional)
      if ($item->config->show_author) {

         $label  = $xCom->xLang->labels['author'];
         $content = $item->author_name;
         $content = sprintf('<i>%s</i> %s<br />', $label, $content);
         $pdf->writeHTML($content, false);

      }

      // Draw creation date (optional)
      if ($item->config->show_author) {

         $label   = $xCom->xLang->labels['created'];
         $content = $item->created;
         $content = sprintf('<i>%s</i> %s<br />', $label, $content);
         $pdf->writeHTML($content, false);

      }

      $pdf->writeHTML('<br />');
      $pdf->writeHTML($item->content, true, 0, true, 0);
      $pdf->writeHTML('<br />');

      // Draw modication date (optional)
      if ($item->config->show_modified && $item->modified) {

         $label   = $xCom->xLang->misc['modified'];
         $content = sprintf($label, $item->modified, $item->modifier_name);
         $content = sprintf('<i>%s</i>', $content);
         $pdf->writeHTML($content, false);

      }

      $pdf->Output('download.pdf', 'D');
      $xConf->hideTemplate();

   }


   /**
    * Shows a content item in printable format (HTML)
    *
    * @param $item The ContentItem to display
    */
   public static function showPrintVersion($item) {
      global $xConf, $xCom;

      $xConf->hideTemplate();

      // Show template
      $tpl = new Template();
      $tpl->assign('item', $item);
      $tpl->assign('xConf', $xConf);
      $tpl->assign('xLang', $xCom->xLang);
      $tpl->display('version-print.tpl');

   }

}
?>