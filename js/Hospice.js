define(['underscore','jquery','backbone'],
		function( _ , $ , Backbone){
	
			var Hospice = {};
			
			Hospice.site_url = 'http://localhost/fatboyslim/index.php';
			
			/** All Templates goes here */
			Hospice.templates = {
							
					user_row :  '<tr>\
							        <td><%= full_name %></td>\
								    <td><%= email %></td>\
								    <td><% for(var i=0; i < teams.length; i++) { %>\
								        <span class="label label-inverse">\
								           	<%= teams[i] %>\
								        </span>\
								        <% } %>\
								    </td>\
								</tr>',
					
					pagination : '<div class="mbl" id="listpagination">\
										<div class="pagination">\
											<ul>\
												<li class="previous">\
													<a href="#fakelink" class="fui-arrow-left" paginate-no="<%= (active - 1 > 0) ? active - 1 : 1  %>"></a>\
												</li>\
												<% for(var i = 1; i <= length; i++){\
													var c = active == i ? "active" : "";\
													%>\
													<li class="<%= c  %>">\
														<a href="#users/page/" paginate-no="<%= i %>"><%= i %></a>\
													</li>\
												<% }; %>\
												<li class="previous">\
													<a href="#fakelink" class="fui-arrow-right" paginate-no="<%= (active + 1 > length) ? length : active + 1 %>"></a>\
												</li>\
											</ul>\
										</div>\
									</div>',

					main_container : '<ul class="nav nav-tabs nav-append-content">\
									        <li class="active">\
									            <a href="#users">User</a>\
									        </li>\
									        <li>\
									            <a href="#teams">Teams</a>\
									        </li>\
									    </ul>\
									    <div class="tab-content main-content">\
											<div class="tab-pane active" id="tab1">\
												<div class="row-fluid" id="left-content">\
													<div class="span3">\
									                    <div class="alert alert-info">\
									                        <h3>\
									                            Manage Access Screen\
									                        </h3>\
									                        <p>\
									                            Display a list of all users with emails they belong to.\
									                        </p>\
									                        <hr>\
									                        <h6>\
									                            <i class="icon-external-link">\
									                            </i>\
									                            Action\
									                        </h6>\
									                        Click on a username to manage access\
									                    </div>\
								                	</div>\
												</div>\
											</div>\
										</div>',
									    
					users_list	: ' <div class="span9">\
											<div class="dialog dialog-tab" style="padding:5px;">\
						                      <div class="row-fluid">\
						                            <div class="span8" >\
						                            </div>\
						                            <div class="span4">\
						                                <form class="form-search">\
						                                    <div class="input-append">\
						                                        <input type="text" class="span2 small search-query search-query-rounded"\
						                                        placeholder="Search" id="search-query-8">\
						                                        <button type="submit" class="btn btn-small">\
						                                            <span class="fui-search">\
						                                            </span>\
						                                        </button>\
						                                    </div>\
						                                </form>\
						                            </div>\
						                        </div>\
						                    </div>\
						                    <div class="demo-content-wide">\
						                        <table class="table table-striped table-hover">\
						                            <thead>\
						                                <tr>\
						                                    <th>\
						                                        Name\
						                                    </th>\
						                                    <th>\
						                                        Email\
						                                    </th>\
						                                    <th>\
						                                        Team\
						                                    </th>\
						                                </tr>\
						                            </thead>\
						                            <tbody>\
						                                \
						                            </tbody>\
						                        </table>\
						                    </div>\
						                    <div class="mbl" id="pagination">\
						                    </div>\
						                 </div>\
						            </div>'
			};
			
			
			Hospice.MainContianerView = Backbone.View.extend({
				
				el : '#main-container',
				
				initialize : function(){
					
					_.bindAll(this,'render');
				},
				
				render : function(){
					$(this.el).append(Hospice.templates.main_container);
				}
				
			});
			
			Hospice.User = Backbone.Model.extend({
				
				defaults : {
					id 			: 0,
					full_name 	: '',
					email		: '',
					teams		: []
				},
				
				url : function(){
					return '/users/' + this.get('id');
				}	
			});

			/**
			 * User Collection
			 */
			Hospice.UserCollection = Backbone.Collection.extend({

				model : Hospice.User,
				
				url : function(){
					return Hospice.site_url + '/users';
				},
				
				parse : function(response){

					this.total = response.total;	

					return response.data;
				}
				
			});

			/**
			 * User List View
			 */
			Hospice.UserListView = Backbone.View.extend({
				
				el : '#left-content',

				events : {
					'click #listpagination' : 'get_paginated_data'
				},
				
				initialize : function(){
					
					_.bindAll(this, 'render', 'reset_user_list', 'create_pagination', 'get_paginated_data', 'fetch_users');
					
					this.collection = new Hospice.UserCollection();
					this.collection.bind('reset',this.reset_user_list);
					
					this.offset = 0;
					
				},

				
				render : function(){
					
					var self = this;
					$(this.el).prepend(Hospice.templates.users_list);
					
					//try and fetch data
					this.fetch_users();
					
				},

				fetch_users : function(){
					var self = this;
					this.collection.fetch({
						data : {
							'offset' : self.offset
						},
						reset 	: true,
						success : function(){	
		   		   			//console.log('success');
		   		   		},
		   		   		error   : function(err){
		   		   			//console.log(err);
		   		   		}
					});

				},
				
				reset_user_list : function(collection){
					
					var self = this;
					var template = _.template(Hospice.templates.user_row);
					$(self.el).find('table tbody').empty();
					_.each(collection.models,function(user, index){
						var html 	= template(user.toJSON()); 
						$(self.el).find('table tbody').append(html);
					});

					//create pagination
					this.create_pagination(this.collection.total,this.offset);
				},

				get_paginated_data : function(ele){
					var pagination = $(ele.target).attr('paginate-no');
					this.offset  = (parseInt(pagination) - 1) * this.collection.models.length;
					this.fetch_users();
				},

				create_pagination : function(total, offset){
					
					var max = 5;
					var self = this;
					if(Math.ceil(total/max) == 1)
		    			return;
		    	
			    	var template = _.template(Hospice.templates.pagination);
			    	var active = offset === 0 ? 1 : Math.ceil(offset / max) + 1 ;
			    	
			    	var html = template({'length' : Math.ceil(total/max), 'active' : active});
			    	
			    	if($(this.el).find('#listpagination').length > 0)		
				    	$(this.el).find('#listpagination').remove();
			    	
			    	setTimeout(function(){
				    	$(self.el).find('table').after(html);	
					},100);
				}
				
			});
			
                        
                        
			return Hospice;
                        
                        
                       
});




