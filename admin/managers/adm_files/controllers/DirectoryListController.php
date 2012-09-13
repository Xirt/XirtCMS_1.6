<?php

/**
 * Controller for directory contents
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryListController extends XController {

   /**
    * Initializes the Controller
    *
    * @param $model The Model to use (optional, default null)
    * @param $view The View to use (optional, default null)
    * @param $action The action to execute (optional, default 'show')
    */
   function __construct($model = null, $view = null, $action = 'show') {
      global $xConf;

      parent::__construct($model, $view, $action);
      chdir($xConf->baseDir);

   }


   /**
    * Show the model (default action)
    *
    * @access protected
    */
   protected function show() {

      if ($this->_model) {
         $this->_model->load(XTools::getParam('dir', './', _STRING));
      }

   }

}
?>