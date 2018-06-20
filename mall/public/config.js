require.config({
	paths: {
        'jquery' : '/vendors/jquery/dist/jquery.min',
        'jquery.ui' : '/js/jquery-ui-1.10.3.min',
        'bootstrap' : '/vendors/bootstrap/dist/js/bootstrap.min',
        'util' : '/upload/util',
        'fileUploader' : '/upload/fileUploader',
        'vaildate' : '/js/jquery.validate'
	},
	shim:{
		'jquery.ui': {
			exports: "$",
			deps: ['jquery']
		},

		'bootstrap': {
			exports: "$",
			deps: ['jquery']
		},

		'validator': {
			exports: "$",
			deps: ['bootstrap']
		},
        'util' : ['jquery'],
        'fileUploader' : ['jquery'],


	}
});