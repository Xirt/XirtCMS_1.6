<?php
//============================================================+
// File name   : eng.php
// Begin       : 2004-03-03
// Last Update : 2010-10-26
//
// Description : Language module for TCPDF
//               (contains translated texts)
//               English
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//
// A.G. Gideonse (11/01/2012):
// This file was modified to work with XirtCMS. The language 
// variables are now filled using the current XirtCMS language 
// file (so this English language file is translated into many 
// languages.
//
//============================================================+

/**
 * TCPDF language file (contains translated texts).
 * @package com.tecnick.tcpdf
 * @brief TCPDF language file: English
 * @author Nicola Asuni
 * @since 2004-03-03
 */

// English

/**
 * Adds locales to $l variable for TCPDF (based on xLang from XirtCMS)
 */
function TCPDF_LANGUAGE() {
   global $l, $xConf, $xLang;

   $l = Array();

   // PAGE META DESCRIPTORS --------------------------------------
   $l['a_meta_charset'] = 'UTF-8';
   $l['a_meta_dir'] = 'ltr';
   $l['a_meta_language'] = substr($xConf->language, 0, 2);

   // TRANSLATIONS --------------------------------------
   $l['w_page'] = $xLang->misc['page'];

}

global $l;
TCPDF_LANGUAGE();

//============================================================+
// END OF FILE
//============================================================+
