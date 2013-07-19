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
        'bootstrap.collapse': {
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
        },
        'Common': {
            deps:  ['jquery']
        },
        'wdCalendar_lang_US': {
            deps:  ['jquery']
        },
        'jquery.ifrmdailog':{
            deps:  ['jquery']
        },
        'jquery.calendar' : {
            deps:  ['jquery']
         },
        'jquery.datepicker' :{
            deps:  ['jquery']
        },         
        'datepicker_lang_US':{
            deps:  ['jquery','jquery.datepicker']
         },
        'calendar': {
             deps: ['jquery']
        },
        'oauthpopup':{
            deps : ['jquery']
        }
    }
});

/** Bootstrap the application */
var HospiceApp = {};
require([   
            'jquery', 
            'underscore', 
            'backbone', 
            'Hospice',
            'bootstrap.collapse',
            'Common',
            'jquery.datepicker',
            'datepicker_lang_US',
            'jquery.ifrmdailog',
            'wdCalendar_lang_US',
            'jquery.calendar',
            'calendar',
            'oauthpopup'
        ],
        function($, _, Backbone, Hospice) {

            $(".collapse").collapse();
            //define the router
            HospiceApp = Backbone.Router.extend({
                routes: {
                    "": "calendar", // #users
                    "teams": "team", //#teams
                    "users": "index",
                    "calendar": "calendar"
                },
                login:function(route)
                {
                    var login_view = new Hospice.LoginContianerView();
                    login_view.render();  
                },
                index: function(route) {

                    $(".span9").remove('');

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
                        var view = new Hospice.AddTeamView();
                        view.render().showModal({});
                    });
                }, 
                calendar: function(route)
                {
                    $("#main-container").empty();

                    $("#loader4").show();
                    var team_calendar_view = new Hospice.TeamCalendarView();
                    team_calendar_view.render();
                    $(".span3").after($("#main-calendar").html());
                    $('body').css('background-color','#fff');
                }

            });

            $(document).ready(function() {

                new HospiceApp();
                Backbone.history.start();


                $('a.logout').googlelogout({
                    redirect_url:'http://localhost/fatboyslim/logout.php'
                });

            });



        });


function ucfirst (str) {
  // http://kevin.vanzonneveld.net
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Onno Marsman
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: ucfirst('kevin van zonneveld');
  // *     returns 1: 'Kevin van zonneveld'
  str += '';
  var f = str.charAt(0).toUpperCase();
  return f + str.substr(1);
}

