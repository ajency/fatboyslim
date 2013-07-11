require.config({
    urlArgs: "v=" + (new Date()).getTime(),
    baseUrl: '/fatboyslim/js/',
    shim: {
        'jquery': {
            exports: "$"
        },
        'underscore': {
            exports: "_"
        },
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
       'jquery.ui.min': {
            deps: ['jquery']
        },
        'jquery.ui.touch.punch.min': {
            deps: ['jquery']
        },
        'bootstrap.min': {
            deps: ['jquery']
        },
        'bootstrap.select': {
            deps: ['jquery', 'bootstrap.min']
        },
        'bootstrap.switch': {
            deps: ['jquery', 'bootstrap.min', 'bootstrap.select']
        },
        'flatui.checkbox': {
            deps: ['jquery']
        },
        'flatui.radio': {
            deps: ['jquery']
        },
        'jquery.tagsinput': {
            deps: ['jquery']
        },
        'jquery.placeholder': {
            deps: ['jquery']
        },
        'jquery.stacktable': {
            deps: ['jquery']
        },
        'mCustomScrollbar.min': {
            deps: ['jquery']
        }
    }
});

/** Bootstrap the application */

require(['jquery', 'underscore', 'backbone','Hospice'],
        function($, _, Backbone, Hospice) {

            //define the router
            var HospiceApp = Backbone.Router.extend({
                routes: {
                    "": "index", // #users
                    "teams": "team", //#teams
                    "users": "index"

                },
                index: function(route) {
                    $(".span9").html('');
                    $('ul.nav-append-content li').removeClass('active').first().addClass('active');
                    var main_view = new Hospice.MainContianerView();
                    main_view.render();

                    var user_list_view = new Hospice.UserListView();
                    user_list_view.render();
                    $(".table").hide();
                    $("#loader3").show();
                },
                team: function(route) {
                    $(".stack-bg").hide();
                    $(".span9").remove();
                    $('ul.nav-append-content li').removeClass('active').last().addClass('active');

                    var team_list_view = new Hospice.TeamListView();
                    team_list_view.render();

                    $("#loader2").hide();
                    $('#add-team').click(function(e) {
                        var view = new Hospice.AddPersonView();
                        view.render().showModal(
                                {
                                   
                                });
                    });
                    //  $(".stack-bg").show();
                }

            });

            $(document).ready(function() {

                new HospiceApp();

                Backbone.history.start();
            });



        });

