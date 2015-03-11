CKEDITOR.editorConfig = function(config) {

	config.plugins = 'dialogui,dialog,about,a11yhelp,basicstyles,blockquote,clipboard,panel,floatpanel,menu,contextmenu,resize,button,toolbar,elementspath,list,indent,enterkey,entities,popup,filebrowser,floatingspace,listblock,richcombo,format,htmlwriter,horizontalrule,wysiwygarea,image,fakeobjects,link,magicline,maximize,pastetext,pastefromword,removeformat,sourcearea,specialchar,menubutton,scayt,stylescombo,tab,table,tabletools,undo,wsc,codemirror,justify,pagebreak,stylesheetparser,syntaxhighlight';
	config.skin = 'bootstrapck';
	// config.skin = 'moono';
	// config.uiColor = '#ffffff';

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [ {
		name : 'clipboard',
		groups : [ 'clipboard', 'undo' ]
	}, {
		name : 'editing',
		groups : [ 'find', 'selection', 'spellchecker' ]
	}, {
		name : 'links'
	}, {
		name : 'insert'
	}, {
		name : 'tools'
	}, {
		name : 'document',
		groups : [ 'mode', 'document', 'doctools' ]
	}, {
		name : 'others'
	}, '/', {
		name : 'basicstyles',
		groups : [ 'basicstyles', 'cleanup' ]
	}, {
		name : 'paragraph',
		groups : [ 'align', 'list', 'indent', 'blocks' ]
	}, {
		name : 'styles'
	}, {
		name : 'colors'
	} ];

	config.removeButtons = 'Copy,Cut';
	config.removePlugins = 'uicolor';

	config.filebrowserBrowseUrl = '/vendor/ckeditor/plugins-ext/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/vendor/ckeditor/plugins-ext/kcfinder/browse.php?opener=ckeditor&type=images';

	// extra plugins
	config.extraPlugins = 'templates,tliyoutube';
};