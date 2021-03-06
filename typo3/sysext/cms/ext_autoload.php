<?php
/*
 * Register necessary class names with autoloader
 *
 * $Id: ext_autoload.php 6536 2009-11-25 14:07:18Z stucki $
 */
return array(
	'tslib_adminpanel' => PATH_tslib . 'class.tslib_adminpanel.php',
	'tslib_cobj' => PATH_tslib . 'class.tslib_content.php',
	'tslib_frameset' => PATH_tslib . 'class.tslib_content.php',
	'tslib_tableoffset' => PATH_tslib . 'class.tslib_content.php',
	'tslib_controltable' => PATH_tslib . 'class.tslib_content.php',
	'tslib_eidtools' => PATH_tslib . 'class.tslib_eidtools.php',
	'tslib_fe' => PATH_tslib . 'class.tslib_fe.php',
	'tslib_fecompression' => PATH_tslib . 'class.tslib_fecompression.php',
	'tslib_fetce' => PATH_tslib . 'class.tslib_fetce.php',
	'tslib_feuserauth' => PATH_tslib . 'class.tslib_feuserauth.php',
	'tslib_gifbuilder' => PATH_tslib . 'class.tslib_gifbuilder.php',
	'tslib_menu' => PATH_tslib . 'class.tslib_menu.php',
	'tslib_tmenu' => PATH_tslib . 'class.tslib_menu.php',
	'tslib_gmenu' => PATH_tslib . 'class.tslib_menu.php',
	'tslib_imgmenu' => PATH_tslib . 'class.tslib_menu.php',
	'tslib_jsmenu' => PATH_tslib . 'class.tslib_menu.php',
	'tspagegen' => PATH_tslib . 'class.tslib_pagegen.php',
	'fe_loaddbgroup' => PATH_tslib . 'class.tslib_pagegen.php',
	'tslib_pibase' => PATH_tslib . 'class.tslib_pibase.php',
	'tslib_search' => PATH_tslib . 'class.tslib_search.php',
	'tslib_extdirecteid' => PATH_tslib . 'class.tslib_extdirecteid.php',
	'sc_tslib_showpic' => PATH_tslib . 'showpic.php',
	'tx_cms_mediaitems' => PATH_tslib . 'hooks/class.tx_cms_mediaitems.php',
	'tx_cms_treelistcacheupdate' => PATH_tslib . 'hooks/class.tx_cms_treelistcacheupdate.php',
	'tx_cms_backendlayout' => PATH_tslib . 'classes/class.tx_cms_backendlayout.php',
	'tslib_content_cobjgetsinglehook' => PATH_tslib . 'interfaces/interface.tslib_content_cobjgetsinglehook.php',
	'tslib_menu_filterMenuPagesHook' => PATH_tslib . 'interfaces/interface.tslib_menu_filterMenuPagesHook.php',
	'tslib_content_getdatahook' => PATH_tslib . 'interfaces/interface.tslib_content_getdatahook.php',
	'tslib_cobj_getimgresourcehook' => PATH_tslib . 'interfaces/interface.tslib_content_getimgresourcehook.php',
	'tslib_content_postinithook' => PATH_tslib . 'interfaces/interface.tslib_content_postinithook.php',
	'tslib_content_stdwraphook' => PATH_tslib . 'interfaces/interface.tslib_content_stdwraphook.php',
	'user_various' => PATH_tslib . 'media/scripts/example_callfunction.php',
	'tslib_gmenu_foldout' => PATH_tslib . 'media/scripts/gmenu_foldout.php',
	'tslib_gmenu_layers' => PATH_tslib . 'media/scripts/gmenu_layers.php',
	'tslib_tmenu_layers' => PATH_tslib . 'media/scripts/tmenu_layers.php',
	'tslib_mediawizardprovider' => PATH_tslib . 'interfaces/interface.tslib_mediawizardprovider.php',
	'tslib_mediawizardcoreprovider' => PATH_tslib . 'class.tslib_mediawizardcoreprovider.php',
	'tslib_mediawizardmanager' => PATH_tslib . 'class.tslib_mediawizardmanager.php',
		//content objects
	'tslib_content_abstract' => PATH_tslib . 'content/class.tslib_content_abstract.php',
	'tslib_content_case' => PATH_tslib . 'content/class.tslib_content_case.php',
	'tslib_content_cleargif' => PATH_tslib . 'content/class.tslib_content_cleargif.php',
	'tslib_content_contentobjectarrayinternal' => PATH_tslib . 'content/class.tslib_content_contentobjectarrayinternal.php',
	'tslib_content_contentobjectarray' => PATH_tslib . 'content/class.tslib_content_contentobjectarray.php',
	'tslib_content_columns' => PATH_tslib . 'content/class.tslib_content_columns.php',
	'tslib_content_content' => PATH_tslib . 'content/class.tslib_content_content.php',
	'tslib_content_contenttable' => PATH_tslib . 'content/class.tslib_content_contenttable.php',
	'tslib_content_file' => PATH_tslib . 'content/class.tslib_content_file.php',
	'tslib_content_fluidtemplate' => PATH_tslib . 'content/class.tslib_content_fluidtemplate.php',
	'tslib_content_form' => PATH_tslib . 'content/class.tslib_content_form.php',
	'tslib_content_hierarchicalmenu' => PATH_tslib . 'content/class.tslib_content_hierarchicalmenu.php',
	'tslib_content_horizontalruler' => PATH_tslib . 'content/class.tslib_content_horizontalruler.php',
	'tslib_content_html' => PATH_tslib . 'content/class.tslib_content_html.php',
	'tslib_content_image' => PATH_tslib . 'content/class.tslib_content_image.php',
	'tslib_content_imageresource' => PATH_tslib . 'content/class.tslib_content_imageresource.php',
	'tslib_content_imagetext' => PATH_tslib . 'content/class.tslib_content_imagetext.php',
	'tslib_content_loadregister' => PATH_tslib . 'content/class.tslib_content_loadregister.php',
	'tslib_content_media' => PATH_tslib . 'content/class.tslib_content_media.php',
	'tslib_content_multimedia' => PATH_tslib . 'content/class.tslib_content_multimedia.php',
	'tslib_content_offsettable' => PATH_tslib . 'content/class.tslib_content_offsettable.php',
	'tslib_content_phpscriptexternal' => PATH_tslib . 'content/class.tslib_content_phpscriptexternal.php',
	'tslib_content_phpscriptinternal' => PATH_tslib . 'content/class.tslib_content_phpscriptinternal.php',
	'tslib_content_phpscript' => PATH_tslib . 'content/class.tslib_content_phpscript.php',
	'tslib_content_quicktimeobject' => PATH_tslib . 'content/class.tslib_content_quicktimeobject.php',
	'tslib_content_records' => PATH_tslib . 'content/class.tslib_content_records.php',
	'tslib_content_restoreregister' => PATH_tslib . 'content/class.tslib_content_restoreregister.php',
	'tslib_content_scalablevectorgraphics' => PATH_tslib . 'content/class.tslib_content_scalablevectorgraphics.php',
	'tslib_content_searchresult' => PATH_tslib . 'content/class.tslib_content_searchresult.php',
	'tslib_content_shockwaveflashobject' => PATH_tslib . 'content/class.tslib_content_shockwaveflashobject.php',
	'tslib_content_template' => PATH_tslib . 'content/class.tslib_content_template.php',
	'tslib_content_text' => PATH_tslib . 'content/class.tslib_content_text.php',
	'tslib_content_userinternal' => PATH_tslib . 'content/class.tslib_content_userinternal.php',
	'tslib_content_user' => PATH_tslib . 'content/class.tslib_content_user.php',
	'tslib_content_editpanel' => PATH_tslib . 'content/class.tslib_content_editpanel.php',
);
?>
