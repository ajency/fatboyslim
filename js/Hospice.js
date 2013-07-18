define(['underscore', 'jquery', 'backbone', 'backbone.modaldialog','oauthpopup'],
        function(_, $, Backbone, ModalView) {

            var Hospice = {};
            Hospice.site_url = 'http://localhost/fatboyslim/index.php';
            /** All Templates goes here */
            Hospice.templates = {
                team_select: '<option id="team_type" value="<%= id %>"><%= team_name %></option>',
                team_member: '\<% for(var i=0; i < data.length; i++) { %>\
                                <div id="user1<%= data[i].user_id %>" teamsid="12" class="innertxt"><ul>\
                    	<li >\
                              <input type="checkbox" name="remove_users" id="users_team_<%= i %>" value="<%= data[i].user_id %>" class="selectit2" /><label for="select12"> <%= data[i].email %></label>\
								  </li>  </ul>\  </div>\
								    	 <% } %>',
                user_row: '<tr>\
							        <td><a href="#" class="" user_name="<%= id %>"><%= full_name %></td></a>\
								    <td><%= email %></td>\
								    <td><% for(var i=0; i < teams.length; i++) { %>\
								        <span class="label label-inverse">\
								           	<%= teams[i] %>\
								        </span>\
								        <% } %>\
								    </td>\
								</tr>',
                pagination: '<div class="mbl" id="listpagination">\
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
                main_container: '<ul class="nav nav-tabs nav-append-content">\
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
                users_list: ' <div class="span9">\
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
                                                                            <div id="loader3"   class="modal_ajax_large"><!-- Place at bottom of page --></div>\
						                            <tbody>\
						                               </tbody>\
						                        </table>\
						                    </div>\
						                    <div class="mbl" id="pagination">\
						                    </div>\
						                 </div>\
						            </div>',
                usersTeamPage: '\
<div id="user1<%= id %>" teamsid="user_<%= id %>" class="innertxt">\
                <ul>\ <li >\
                <input type="checkbox" name="allusers" id="user_<%= id %>" value=<%= id %> class="selectit2" /><label for="select12"><%= email %></label>\
                            </li>\
                            </ul>\
                            </div>\n\
',
                teampage_allusers_pagination: '<div class="mbl" id="teampage_listpagination">\
										<div class="pagination">\
											<ul>\
												<li class="previous">\
													<a href="#fakelink" class="fui-arrow-left" paginate-no="<%= (active - 1 > 0) ? active - 1 : 1  %>"></a>\
												</li>\
												<% for(var i = 1; i <= length; i++){\
													var c = active == i ? "active" : "";\
													%>\
													<li class="<%= c  %>">\
														<a href="#teams/page/" paginate-no="<%= i %>"><%= i %></a>\
													</li>\
												<% }; %>\
												<li class="previous">\
													<a href="#fakelink" class="fui-arrow-right" paginate-no="<%= (active + 1 > length) ? length : active + 1 %>"></a>\
												</li>\
											</ul>\
										</div>\
									</div>',
            };
            Hospice.MainContianerView = Backbone.View.extend({
                el: '#main-container',
                initialize: function() {

                    _.bindAll(this, 'render');
                },
                render: function() {
                    $(this.el).append(Hospice.templates.main_container);
                }

            });
            Hospice.LoginContianerView = Backbone.View.extend({
                el: '#main_container',
                events: {
                    'click .login':'login_auth',
                }, initialize: function() {

                    _.bindAll(this, 'render', 'login_auth');

                },
                render: function() {

                    $(this.el).append($("#login-forms").html());
                },
                login_auth: function() {
                    oauthpopup({
                        path: "<?php if(isset($authUrl)){echo $authUrl;}else{ echo '';}?>",
                        width: 650,
                        height: 350,
                    });
                }

            });
            Hospice.User = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: [],
                    exclude_user: 0
                },
                url: function() {
                    return Hospice.site_url + '/users/' + this.get('id');
                }
            });
            Hospice.AllUser = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: []
                },
                url: function() {
                    return Hospice.site_url + '/users';
                }
            });
            Hospice.AllNotInTeam = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: [],
                    teamid: 0
                },
                url: function() {
                    return Hospice.site_url + '/notinteam/' + this.get('teamid');
                }
            });
            Hospice.AddToTeam = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: []
                },
                url: function() {
                    return Hospice.site_url + '/addToTeam/' + this.get('id') + '/' + this.get('team_id');
                }
            });
            Hospice.AddNewTeam = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: []
                },
                url: function() {
                    return Hospice.site_url + '/addNewTeam/' + this.get('name');
                }
            });
            Hospice.RemoveFromTeam = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: '',
                    teams: []
                },
                url: function() {
                    return Hospice.site_url + '/removefromTeam/' + this.get('id') + '/' + this.get('team_id');
                }
            });
            Hospice.AllInTeam = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    full_name: '',
                    email: [],
                    teams: '',
                    teamid: 0,
                    total: 0
                },
                url: function() {
                    return Hospice.site_url + '/allinteam/';
                }
            });
            Hospice.UserAccessList = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    withaccessId: ""
                },
                url: function() {
                    return Hospice.site_url + '/useraccesslist/' + this.get('id') + '/' + this.get('withaccessId') + '/' + this.get('action');
                }
            });

            Hospice.TeamAccessList = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    withaccessId: ""
                },
                url: function() {
                    return Hospice.site_url + '/teamaccesslist/' + this.get('id') + '/' + this.get('withaccessId') + '/' + this.get('action');
                }
            });

            /**
             * User Collection
             */
            Hospice.UserCollection = Backbone.Collection.extend({
                model: Hospice.User,
                url: function() {
                    return Hospice.site_url + '/users';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });
            Hospice.AddNewTeamCollection = Backbone.Model.extend({
                model: Hospice.AddNewTeam,
                url: function() {
                    return Hospice.site_url + '/allinteam/';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }
            });
            Hospice.AllUsersInTeamCollection = Backbone.Model.extend({
                model: Hospice.AllInTeam,
                url: function() {
                    return Hospice.site_url + '/allinteam/';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }
            });

            Hospice.UserAccessListCollection = Backbone.Model.extend({
                model: Hospice.UserAccessList,
                url: function() {
                    return Hospice.site_url + '/useracesslist/';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }
            });



            /**
             * User List View
             */
            Hospice.UserListView = Backbone.View.extend({
                el: '#left-content',
                events: {
                    'click #listpagination li a': 'get_paginated_data',
                    'click .table tbody tr td a': 'user_access',
                    'click #move_users_right': 'add_to_access_list',
                    'click #move_users_left': 'remove_from_access_list',
                    'click #move_right_team': 'add_team_access_list',
                    'click #move_left_team': 'remove_team_access_list',
                    'click .access_class': 'access_rights_user',
                    'click #useracess_listpagination': 'get_user_paginated',
                    'click #teamacess_listpagination': 'get_team_paginated'
                },
                initialize: function() {

                    _.bindAll(this, 'render', 'reset_user_list', 'create_pagination', 'get_paginated_data', 'fetch_users', 'user_access', 'show_user_access', 'fetch_all_users_list', 'fetch_all_team_list', 'add_to_access_list', 'add_to_access_list', 'remove_from_access_list', 'add_team_access_list', 'remove_team_access_list', 'create_pagination_useraccess', 'fetch_assigned_users', 'fetch_assigned_teams', 'get_user_paginated', 'get_team_paginated');
                    this.collection = new Hospice.UserCollection();
                    this.collection.bind('reset', this.reset_user_list);
                    this.offset = 0;

                    this.teamcollection = new Hospice.TeamCollection();

                    this.useraccesscollection = new Hospice.UserCollection();

                    this.accesslistollection = new Hospice.UserAccessListCollection();
                },
                render: function() {

                    var self = this;
                    $(this.el).prepend(Hospice.templates.users_list);
                    //try and fetch data
                    this.fetch_users();
                },
                fetch_users: function() {
                    var self = this;
                    this.collection.fetch({
                        data: {
                            'offset': self.offset
                        },
                        reset: true,
                        success: function() {
                            //console.log('success');
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                },
                reset_user_list: function(collection) {

                    var self = this;
                    var template = _.template(Hospice.templates.user_row);
                    $(self.el).find('table tbody').empty();
                    _.each(collection.models, function(user, index) {

                        var html = template(user.toJSON());
                        $(self.el).find('table tbody').append(html);
                    });
                    $(".table").show();
                    $("#loader3").hide();
                    //create pagination
                    this.create_pagination(this.collection.total, this.offset);
                },
                get_paginated_data: function(ele) {
                    var pagination = $(ele.target).attr('paginate-no');
                    this.offset = (parseInt(pagination) - 1) * this.collection.models.length;
                    this.fetch_users();
                },
                create_pagination: function(total, offset) {

                    var max = 5;
                    var self = this;
                    if (Math.ceil(total / max) == 1)
                        return;
                    var template = _.template(Hospice.templates.pagination);
                    var active = offset === 0 ? 1 : Math.ceil(offset / max) + 1;
                    var html = template({'length': Math.ceil(total / max), 'active': active});
                    if ($(this.el).find('#listpagination').length > 0)
                        $(this.el).find('#listpagination').remove();
                    setTimeout(function() {
                        $(self.el).find('table').after(html);
                    }, 100);
                }, user_access: function(ele)
                {
                    var user_id = $(ele.target).attr('user_name');

                    this.show_user_access(ele, user_id);
                }, show_user_access: function(ele, user_id)
                {
                    $(".span9").remove();


                    $("#left-content").prepend($("#user-manage-access").html());
                    $("#left-content").append($("#team-manage-access").html());
                    this.fetch_all_users_list(user_id);
                    this.fetch_all_team_list(user_id);
                    this.fetch_assigned_users(user_id);
                    this.fetch_assigned_teams(user_id);


                },
                get_paginated_data: function(ele) {
                    var pagination = $(ele.target).attr('paginate-no');
                    this.offset = (parseInt(pagination) - 1) * this.collection.models.length;
                    this.fetch_users();
                }, get_user_paginated: function(ele) {
                    var pagination = $(ele.target).attr('paginate-no');
                    this.offset = (parseInt(pagination) - 1) * this.collection.models.length;
                    $("#all_users").html('');
                    this.fetch_all_users_list($("#current_user").val());
                }, get_team_paginated: function(ele) {
                    var pagination = $(ele.target).attr('paginate-no');
                    this.offset = (parseInt(pagination) - 1) * this.collection.models.length;
                    $("#all_users1").html('');
                    this.fetch_all_team_list($("#current_user").val());
                },
                fetch_assigned_users: function(user_id)
                {
                    var self = this;
                    this.collection.fetch({
                        data: {
                            'offset': self.offset,
                            'access': user_id
                        },
                        reset: true,
                        success: function(model, response) {
                            var template = _.template($("#user_access_row").html());
                            _.each(response.data, function(user, index) {

                                var html = template(user);
                                $("#selected_users").append(html);
                                $("#select" + this.value).attr("name", "remove_users_list");

                            });
                            //self.create_pagination_useraccess(self.collection.total,self.offset);
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });

                }, fetch_assigned_teams: function(user_id) {
                    var self = this;
                    this.teamcollection.fetch({
                        data: {
                            'offset': self.offset,
                            'access': user_id
                        },
                        reset: true,
                        success: function(model, response) {
                            var template = _.template($("#team_access_row").html());
                            _.each(response.data, function(user, index) {

                                var html = template(user);
                                $("#selected_users1").append(html);


                            });
                            //self.create_pagination_useraccess(self.collection.total,self.offset);
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });


                }, fetch_all_users_list: function(user_id)
                {
                    var self = this;
                    this.useraccesscollection.fetch({
                        data: {
                            'offset': self.offset,
                            'exclude_user': user_id
                        },
                        reset: true,
                        success: function(model, response) {
                            var template = _.template($("#user_access_row").html());
                            _.each(response.data, function(user, index) {

                                var html = template(user);
                                $("#all_users").append(html);

                                $("#current_user").val(user_id);
                            });
                            self.create_pagination_useraccess(response.total, self.offset);
                        },
                        error: function(err) {
                            //console.log(err);
                        }

                    });

                }, fetch_all_team_list: function(user_id)
                {
                    var self = this;
                    this.teamcollection.fetch({
                        data: {
                            'offset': self.offset,
                            'limit': 'yes',
                            'user': user_id
                        },
                        reset: true,
                        success: function(model, response) {
                            var template = _.template($("#team_access_row").html());
                            _.each(response.data, function(user, index) {

                                var html = template(user);
                                $("#all_users1").append(html);
                                $("#select" + this.value).attr("name", "remove_team_list");

                            });
                            self.create_pagination_teamaccess(response.total, self.offset);
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                }, add_to_access_list: function()
                {

                    var withaccessId = "";
                    $('input[name="user_access"]:checked').each(function() {


                        $("#select" + this.value).attr("name", "remove_users_list");
                        $("#user" + this.value).remove().prependTo("#selected_users");
                        $("#user" + this.value).append("<input class='access_class' id='access" + this.value + "' name='access_rights' type='checkbox' value='" + this.value + "' checked data-toggle='switch' />");

                        withaccessId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });

                    this.model = new Hospice.UserAccessList();
                    this.model.set({id: $("#current_user").val(), withaccessId: withaccessId, action: 'add'}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {



                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                }, remove_from_access_list: function()
                {

                    var removeaccessId = "";
                    $('input[name="remove_users_list"]:checked').each(function() {

                        $('#access' + this.value).remove();
                        $("#select" + this.value).attr("name", "user_access");
                        $("#user" + this.value).remove().prependTo("#all_users");
                        removeaccessId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });
                    this.model = new Hospice.UserAccessList();
                    this.model.set({id: $("#current_user").val(), withaccessId: removeaccessId, action: 'remove'}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {



                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                }, add_team_access_list: function()
                {
                    var withaccessId = "";
                    $('input[name="team_access"]:checked').each(function() {


                        $("#select" + this.value).attr("name", "remove_team_list");
                        $("#team" + this.value).remove().prependTo("#selected_users1");
                        withaccessId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });

                    this.model = new Hospice.TeamAccessList();
                    this.model.set({id: $("#current_user").val(), withaccessId: withaccessId, action: 'add'}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {



                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });

                }, remove_team_access_list: function() {
                    var removeaccessId = "";
                    $('input[name="remove_team_list"]:checked').each(function() {


                        $("#select" + this.value).attr("name", "team_access");

                        $("#access" + this.value).remove();
                        $("#team" + this.value).remove().prependTo("#all_users1");
                        removeaccessId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });
                    this.model = new Hospice.TeamAccessList();
                    this.model.set({id: $("#current_user").val(), withaccessId: removeaccessId, action: 'remove'}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {



                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                }, create_pagination_useraccess: function(total, offset) {

                    var max = 5;
                    var self = this;
                    if (Math.ceil(total / max) == 1)
                        return;
                    var template = _.template($("#user_access_pagination").html());
                    var active = offset === 0 ? 1 : Math.ceil(offset / max) + 1;
                    var html = template({'length': Math.ceil(total / max), 'active': active});
                    if ($('#useracess_listpagination').length > 0)
                        $('#useracess_listpagination').remove();
                    setTimeout(function() {

                        $('#users_main_div').append(html);
                    }, 100);
                }, create_pagination_teamaccess: function(total, offset)
                {

                    var max = 5;
                    var self = this;
                    if (Math.ceil(total / max) == 1)
                        return;
                    var template = _.template($("#team_access_pagination").html());
                    var active = offset === 0 ? 1 : Math.ceil(offset / max) + 1;
                    var html = template({'length': Math.ceil(total / max), 'active': active});
                    if ($('#teamacess_listpagination').length > 0)
                        $('#teamacess_listpagination').remove();

                    setTimeout(function() {

                        $('#team_main_div').append(html);
                    }, 100);
                }





            });
            /*
             *   Loads teams tab view
             * 
             * 
             */

            Hospice.Team = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    team_name: '',
                    team_members: [],
                },
                url: function() {
                    return Hospice.site_url + '/team/' + this.get('id');
                }
            });
            Hospice.TeamCollection = Backbone.Collection.extend({
                model: Hospice.Team,
                url: function() {
                    return Hospice.site_url + '/teams';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });
            Hospice.UserNotInTeamCollection = Backbone.Collection.extend({
                model: Hospice.Team,
                url: function() {
                    return Hospice.site_url + '/notinteam';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });
            Hospice.AllInTeamCollection = Backbone.Collection.extend({
                model: Hospice.AllInTeam,
                url: function() {
                    return Hospice.site_url + '/allinteam';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });
            /**
             * Team List View
             */
            Hospice.TeamListView = Backbone.View.extend({
                el: '#left-content',
                events: {
                    'change #drop-down': function(e) {
                        this.get_team_members(e);
                        //this.fetch_users(e);
                    },
                    'click #move_right2': 'add_to_team', //adding user to team 
                    'click #move_left2': 'remove_from_team',
                    'click #teampage_listpagination li a ': 'get_paginated_data'
                },
                initialize: function() {

                    _.bindAll(this, 'render', 'fetch_teams', 'reset_team_list', 'get_team_members', 'fetch_team_members', 'reset_user_list', 'create_pagination_users', 'get_paginated_data', 'fetch_users');
                    $(".stack-bg").hide();
                    this.collection = new Hospice.TeamCollection();
                    this.collection.bind('reset', this.reset_team_list);
                    //this.collection = new Hospice.UserNotInTeamCollection();

                    this.offset = 0;
                    this.usercollection = new Hospice.UserCollection();
                    this.usercollection.bind('reset', this.reset_user_list);
                    this.offset = 0;
                },
                render: function() {

                    var self = this;
                    $(this.el).prepend($("#team_list").html());
                    $(".stack-bg").hide();
                    this.fetch_teams();
                },
                fetch_teams: function() {
                    var self = this;
                    this.collection.fetch({
                        data: {
                            'offset': 0
                        },
                        reset: true,
                        success: function() {
                            $("#loader").hide();
                        },
                        error: function(err) {
                            //console.log(err);
                        }

                    });
                },
                reset_team_list: function(collection) {

                    var self = this;
                    var template = _.template(Hospice.templates.team_select);
                    $(self.el).find("#select-box").find('select').empty();
                    _.each(collection.models, function(team, index) {

                        var html = template(team.toJSON());
                        $(self.el).find("#select-box").find('select').append(html);
                    });
                    $(self.el).find("#select-box").find('select').append('<option value="0" selected="selected">SELECT</opiton>');
                    //create pagination


                },
                get_team_members: function(ele) {


                    if ($("#drop-down").val() == 0)/* hides if option is default in selectbox */
                    {
                        $(".stack-bg").hide();
                    } else
                    {
                        $(".stack-bg").hide(); //temp
                        $("#loader2").show();
                        this.fetch_team_members(ele);
                    }

                },
                fetch_team_members: function(ele) {
                    this.usercollection.fetch({
                        data: {
                            'offset': 0,
                            'teamid': $("#drop-down").val()
                        },
                        reset: true,
                        success: function() {
                            $("#loader").hide();

                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                    var self = this;
                    var id = $(ele.target).val();
                    this.model = new Hospice.Team();
                    this.model.set({id: id}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {

                            var template = _.template(Hospice.templates.team_member);
                            $(self.el).find('#selected_users2').empty();
                            var html = template(response.toJSON());
                            $(self.el).find('#selected_users2').append(html);
                            $("#loader2").hide();
                            $(".stack-bg").show();
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });


                },
                add_to_team: function(ele) {

                    var self = this;
                    var userId = "";
                    $('input[name="allusers"]:checked').each(function() {


                        $("#user_" + this.value).attr("name", "remove_users");
                        $("#user1" + this.value).remove().prependTo("#selected_users2");
                        userId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });
                    $("#loader1").show();

                    var id = userId;
                    var team_id = $("#drop-down").val();
                    this.model = new Hospice.AddToTeam();
                    this.model.set({id: id, team_id: team_id}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {
                            $("#loader1").hide();


                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                },
                remove_from_team: function(ele) {
                    console.log(ele);
                    var self = this;
                    var userId = "";

                    $('input[name="remove_users"]:checked').each(function() {


                        $("#user_" + this.value).attr("name", "allusers");
                        $("#user1" + this.value).remove().prependTo("#all_users2");
                        userId += this.value + ',';
                        $('input:checkbox').removeAttr('checked');
                    });

                    $("#loader1").show();
                    var id = userId;
                    var team_id = $("#team_type").val();
                    this.model = new Hospice.RemoveFromTeam();
                    this.model.set({id: id, team_id: team_id}); /*selected id in the url*/
                    this.model.fetch({
                        reset: true,
                        success: function(response, model) {
                            $("#loader1").hide();


                        }
                    }); //RemoveFromTeam model
                },
                fetch_users: function() {

                    var self = this;
                    this.usercollection.fetch({
                        data: {
                            'offset': self.offset,
                        },
                        reset: true,
                        success: function() {
                            //console.log('success');
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                },
                reset_user_list: function(usercollection) {

                    var self = this;
                    var template = _.template(Hospice.templates.usersTeamPage);
                    $(self.el).find('#all_users2').empty();
                    _.each(usercollection.models, function(user, index) {

                        var html = template(user.toJSON());
                        $(self.el).find('#all_users2').append(html);
                    });
                    //create pagination
                    this.create_pagination_users(usercollection.total, this.offset);
                },
                get_paginated_data: function(ele) {
                    var pagination = $(ele.target).attr('paginate-no');
                    this.offset = (parseInt(pagination) - 1) * this.usercollection.models.length;
                    this.fetch_users();
                },
                create_pagination_users: function(total, offset) {

                    var max = 5;
                    var self = this;
                    if (Math.ceil(total / max) == 1)
                        return;
                    var template = _.template(Hospice.templates.teampage_allusers_pagination);
                    var active = offset === 0 ? 1 : Math.ceil(offset / max) + 1;
                    var html = template({'length': Math.ceil(total / max), 'active': active});
                    if ($('#teampage_listpagination').length > 0)
                        $('#teampage_listpagination').remove();
                    setTimeout(function() {

                        $('#all_users').append(html);
                    }, 100);
                }
            });





            Hospice.AddTeamView = ModalView.extend(
                    {
                        name: "AddTeamView",
                        model: "",
                        templateHtml:
                                "",
                        initialize: function()
                        {
                            _.bindAll(this, "render", "add_new_team", "close_popup", "fetch_teams");
                            this.template = _.template($("#team-dialog").html());


                        },
                        events:
                                {
                                    "click #save": "add_new_team",
                                    "click #close": "close_popup",
                                }, add_new_team:
                                function()
                                {
                                    $("#error_text_two").hide();
                                    if ($("#in-name").val().length == 0) {
                                        $("#error_text").show();

                                    } else {
                                        $("#loader_team").show();
                                        $("#error_text").hide();
                                        this.collection = new Hospice.AddNewTeamCollection();

                                        this.offset = 0;
                                        var self = this;
                                        this.collection.fetch({
                                            data: {
                                                'team': $("#in-name").val()
                                            },
                                            reset: true,
                                            success: function(response, models) {
                                                $("#loader_team").hide();
                                                if (models.status == "401")
                                                {
                                                    $("#error_text_two").show();

                                                } else
                                                {
                                                    $("#loader").show();
                                                    $("#modal-blanket").hide();
                                                    $(".modal").hide();
                                                    var editView = new Hospice.TeamListView({model: this.model});
                                                    editView.fetch_teams();
                                                    $("#loader").hide();
                                                }
                                            },
                                            error: function(err) {
                                                //console.log(err);
                                            }
                                        });
                                    }
                                }, fetch_teams: function() {
                            this.collection = new Hospice.TeamCollection();
                            var self = this;
                            $(this.el).prepend($("#team_list").html());
                            $(".stack-bg").hide();
                            this.collection.fetch({
                                data: {
                                    'offset': 0
                                },
                                reset: true,
                                success: function() {
                                    $("#loader").hide();
                                },
                                error: function(err) {
                                    //console.log(err);
                                }

                            });

                        },
                        render:
                                function()
                                {
                                    $(this.el).html(this.template());
                                    return this;
                                }, close_popup: function()
                        {
                            $("#modal-blanket").hide();
                            $(".modal").hide();
                        }
                    });


            Hospice.TeamCalendarView = Backbone.View.extend({
                el: '#main-container',
                events: {
                    'click #checkbox2': 'user_checked',
                },
                initialize: function() {


                    _.bindAll(this, 'render', 'add_color_code', 'fetch_all_in_teams', 'reset_calendar_team_list', 'user_checked');

                    $(".stack-bg").hide();
                    this.collection = new Hospice.AllInTeamCollection();
                    this.collection.bind('reset', this.reset_calendar_team_list);

                    this.useremails = [];

                    this.offset = 0;

                },
                render: function() {

                    var self = this;
                    $("#main-container").html($("#main-calendar-container").html());

                    this.fetch_all_in_teams();

                },
                fetch_all_in_teams: function() {
                    var self = this;
                    this.collection.fetch({
                        data: {
                            'offset': self.offset
                        },
                        reset: true,
                        success: function() {


                            //loadCalendar();

                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });
                },
                reset_calendar_team_list: function(collection) {

                    $("#loader1").show();
                    var self = this;
                    var emails = [];
                    var template = _.template($("#see_team_calendar_users").html());

                    _.each(collection.models, function(team, index) {

                        if (team.toJSON().email.length == 0)
                            return;

                        var html = template(team.toJSON());

                        $("#accordion2").append(html);

                        emails = _.union(emails, team.toJSON().email);

                    });

                    self.add_color_code(emails, 0);
                    $("#loader1").hide();

                },
                add_color_code: function(emails, index) {
                    var self = this;

                    $.get(Hospice.site_url + '/user/calendarcolor/' + emails[index], {},
                            function(response) {
                                self.useremails.push(response);
                                $('input[value="' + response[0] + '"]').next('span').css({'background-color': response[1], 'padding': 10});
                                index++;
                                if (index < emails.length)
                                    self.add_color_code(emails, index);

                            }, 'json');

                },
                user_checked: function(ele)
                {
                    $(ele.target).closest('#accordion2').find('input[type="checkbox"]').removeAttr('checked');
                    $(ele.target).closest('#accordion2').find('li').css('background-color', '');
                    $(ele.target).attr('checked', 'checked').parent().css('background-color', '#ccc');
                    var _email = $(ele.target).val();
                    loadCalendar(_email, $(ele.target));

                    /***
                     this.events = new Hospice.EventCollection();
                     this.events.bind('reset', this.reset_calendar_events);
                     
                     this.events.fetch({
                     reset   : true,
                     data    : {
                     email : _email
                     },
                     success : function(model,collection)
                     {}   
                     });*/
                },
                reset_calendar_events: function(collection) {
                    var events = [];
                    _.each(collection.models, function(event, index) {
                        events.push(event.toJSON());

                    });

                    console.log(events);


                }
            });


            /**
             * Event Model
             */
            Hospice.Event = Backbone.Model.extend({
                defaults: {
                    id: 0,
                    summary: '',
                    start: '',
                    end: '',
                    assigned: ''
                }
            });

            /**
             * Event Collection
             */
            Hospice.EventCollection = Backbone.Collection.extend({
                model: Hospice.Event,
                url: function() {
                    return Hospice.site_url + '/datafeed?method=list';
                },
                parse: function(response)
                {
                    return response;
                }

            });


            return Hospice;

        });
