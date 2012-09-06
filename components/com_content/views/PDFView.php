<?php

/**
 * View for the PDF version of the model
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class PDFView extends XView {

   /**
    * @var The defaul template file to load
    * @access protected
    */
   protected $_file = 'version-print.tpl';


   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {
      global $xConf;

      $xConf->hideTemplate();
      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    *
    * @access protected
    */
   protected function _init() {
      global $xLang, $xCom, $xConf;

      // Include files here (cause they're large ;-))
      require_once('classes/tcpdf/config/lang/eng.php');
      require_once('classes/tcpdf/tcpdf.php');

      // Create new PDF
      $this->_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT);
      $this->_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $this->_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $this->_pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
      $this->_pdf->setPrintHeader(false);
      $this->_pdf->AddPage();

      // Set META information
      $this->_pdf->SetTitle($this->_model->title);
      $this->_pdf->SetCreator($xLang->version);
      $this->_pdf->SetSubject($this->_model->meta_description);
      $this->_pdf->SetKeywords($this->_model->meta_keywords);

      // Draw title (optional)
      if ($this->_model->config->show_title) {

         $title = sprintf('<h1>%s</h1>', $this->_model->title);
         $this->_pdf->writeHTML($title, false);

      }

      // Draw author (optional)
      if ($this->_model->config->show_author) {

         $label  = $xCom->xLang->labels['author'];
         $content = $this->_model->author_name;
         $content = sprintf('<i>%s</i> %s<br />', $label, $content);
         $this->_pdf->writeHTML($content, false);

      }

      // Draw creation date (optional)
      if ($this->_model->config->show_created) {

         $label   = $xCom->xLang->labels['created'];
         $content = $this->_model->created;
         $content = sprintf('<i>%s</i> %s<br />', $label, $content);
         $this->_pdf->writeHTML($content, false);

      }

      // Draw actual content
      $this->_pdf->writeHTML('<br />');
      $this->_pdf->writeHTML($this->_model->content, true, 0, true, 0);
      $this->_pdf->writeHTML('<br />');

      // Draw modication date (optional)
      if ($this->_model->config->show_modified && $this->_model->modified) {

         $label   = $xCom->xLang->misc['modified'];
         $content = sprintf($label, $this->_model->modified, $this->_model->modifier_name);
         $content = sprintf('<i>%s</i>', $content);
         $this->_pdf->writeHTML($content, false);

      }

      parent::_init();

   }


   /**
    * Shows the model on destruction
    */
   function __destruct() {
      $this->_pdf->Output('download.pdf', 'D');
   }

}
?>