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
require(['jquery','underscore','backbone'],
		function($, _, Backbone){
			$(document).ready(function () {
				// Uncheck each checkbox on body load
				$('#all_users .selectit').each(function() {this.checked = false;});
				$('#selected_users .selectit').each(function() {this.checked = false;});
				
		    	$('#all_users .selectit').click(function() {
					var userid = $(this).val();
					$('#user' + userid).toggleClass('innertxt_bg');
				});
				
				$('#selected_users .selectit').click(function() {
					var userid = $(this).val();
					$('#user' + userid).toggleClass('innertxt_bg');
				});
				
				$("#move_right").click(function() {
					var users = $('#selected_users .innertxt2').size();
					var selected_users = $('#all_users .innertxt_bg').size();
					
					if (users + selected_users > 5) {
						alert('You can only chose maximum 5 users.');
						return;
					}
					
					$('#all_users .innertxt_bg').each(function() {
						var user_id = $(this).attr('userid');
						$('#select' + user_id).each(function() {this.checked = false;});
						
						var user_clone = $(this).clone(true);
						$(user_clone).removeClass('innertxt');
						$(user_clone).removeClass('innertxt_bg');
						$(user_clone).addClass('innertxt2');
						
						$('#selected_users').append(user_clone);
						$(this).remove();
					});
				});
				
				$("#move_left").click(function() {
					$('#selected_users .innertxt_bg').each(function() {
						var user_id = $(this).attr('userid');
						$('#select' + user_id).each(function() {this.checked = false;});
						
						var user_clone = $(this).clone(true);
						$(user_clone).removeClass('innertxt2');
						$(user_clone).removeClass('innertxt_bg');
						$(user_clone).addClass('innertxt');
						
						$('#all_users').append(user_clone);
						$(this).remove();
					});
				});
				
				$('#view').click(function() {
					var users = '';
					$('#selected_users .innertxt2').each(function() {
						var user_id = $(this).attr('userid');
						if (users == '') 
							users += user_id;
						else
							users += ',' + user_id;
					});
					alert(users);
				});
			});
		});