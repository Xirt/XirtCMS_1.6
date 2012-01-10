/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
   config.docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">';
   config.resize_enabled = false;
   config.toolbar = 'Simple';
   config.toolbar_Simple = [
      ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
      ['NumberedList','BulletedList','-','Blockquote'],
      ['Smiley','SpecialChar'],
      ['Font','FontSize'],
      ['TextColor','BGColor']
   ];

//    ['Link','Unlink','Anchor'],
//    ['Image','Smiley','SpecialChar'],
};