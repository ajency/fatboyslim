define(['underscore','jquery','backbone'],
		function(_, $, Backbone){
	
			/** Global Hospice Object */
			var Hospice = {};
			
			/** All Templates goes here */
			Hospice.templates = {
							
					user_row : '<tr>\
							        <td><%= full_name %></td>\
								    <td><%= email %></td>\
								    <td><% for(var i=0; i < teams.length; i++) { %>\
								        <span class="label label-inverse">\
								           	<%= user_teams[i] %>\
								        </span>\
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
														<a href="#fakelink" paginate-no="<%= i %>"><%= i %></a>\
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
									            <a href="#tab1">User</a>\
									        </li>\
									        <li>\
									            <a href="#tab2">Teams</a>\
									        </li>\
									    </ul>\
									    <div class="tab-content main-content">\
											<div class="tab-pane active" id="tab1">\
												<div class="row-fluid">\
													<div class="span9" id="user-list">\
													</div>\
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
									    
					users_list	: '   	<div class="dialog dialog-tab" style="padding:5px;">\
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
						                    <!-- Table View -->\
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
				
				el : $('#main-container'),
				
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

			Hospice.UserCollection = Backbone.Collection.extend({

				model : Hospice.User,
				
				url : '/users/',
				
				initiazlize : function(){
					
				}
				
			});
			
			Hospice.UserListView = Backbone.View.extend({
				
				el : $('#user-list'),
				
				initialize : function(){
					
					this.collection = new Hospice.UserCollection();
					
					this.fetch({
						reset: true,
						success : function(){	
		   		   			console.log('success');
		   		   		},
		   		   		error   : function(err){
		   		   			console.log('error');
		   		   		}
					});
					
					_.bindAll(this,'render');
				},
				
				render : function(){
					$(this.el).append(Hospice.templates.main_container);
				}
				
			});
			
			
			
			
	
			return Hospice;
});
