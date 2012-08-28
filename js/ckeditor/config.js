/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
   config.docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">';
   config.resize_enabled = false;
   config.uiColor = '#dbe5f1';
   config.toolbar = 'Full';
   config.toolbar_Full =
   [
      ['Source','-','NewPage','Preview','-','Templates'],
      ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
      ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
      '/',
      ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
      ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
      ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
      ['Link','Unlink','Anchor'],
      ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
      '/',
      ['Styles','Format','Font','FontSize'],
      ['TextColor','BGColor'],
      ['Maximize', 'ShowBlocks','-','About']
   ];
   
   config.toolbar_Simple = [
      ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
      ['NumberedList','BulletedList','-','Blockquote'],
      ['Smiley','SpecialChar'],
      ['Font','FontSize'],
      ['TextColor','BGColor']
   ];
};
