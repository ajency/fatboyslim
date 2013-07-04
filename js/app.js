require.config({
		urlArgs: "v=" +  (new Date()).getTime(),
		baseUrl: '/fatboyslim/js/',
		shim: {
			'jquery': {
				exports	: "$"
		    },  
		    'underscore': {
		      exports	: "_"
		    },
		    'backbone': {
		      deps		: ['underscore', 'jquery'],
		      exports	: 'Backbone'
		    },
		    'jquery.ui.min' : {
		    	deps 	: ['jquery']
		    },
		    'jquery.ui.touch.punch.min'	 : {
		    	deps 	: ['jquery']
		    },
		    'bootstrap.min' : {
		    	deps 	: ['jquery']
		    },
		    'bootstrap.select' : {
		    	deps 	: ['jquery','bootstrap.min']
		    },
		    'bootstrap.switch' : {
		    	deps 	: ['jquery','bootstrap.min','bootstrap.select']
		    },
		    'flatui.checkbox' : {
		    	deps 	: ['jquery']
		    },
		    'flatui.radio' : {
		    	deps 	: ['jquery']
		    },
		    'jquery.tagsinput' : {
		    	deps 	: ['jquery']
		    },
		    'jquery.placeholder' : {
		    	deps 	: ['jquery']
		    },
		    'jquery.stacktable' : {
		    	deps 	: ['jquery']
		    },
		    'mCustomScrollbar.min' : {
		    	deps 	: ['jquery']
		    }
		  }
});

/** Bootstrap the application */
require(['jquery','underscore','backbone', 'Hospice'],
		function($, _, Backbone, Hospice){
			Hospice = Hospice;
			var main_view = new Hospice.MainContianerView();
			main_view.render();
			
			var user_list_view = new Hospice.UserListView();
			user_list_view.render();
	
		});