<?php
require_once 'config.php';
require_once 'lib/Google_Client.php';
require_once 'lib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName("Google UserInfo PHP Starter Application");

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setApprovalPrompt(APPROVAL_PROMPT);
$client->setAccessType(ACCESS_TYPE);

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    echo '<script type="text/javascript">window.close();</script>';
    exit;
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['error'])) {
    echo '<script type="text/javascript">window.close();</script>';
    exit;
}

if ($client->getAccessToken()) {




//    $client->authenticate();
//    $NewAccessToken = json_decode($client->getAccessToken());
//    $client->refreshToken($NewAccessToken->refresh_token);
   // $user = $oauth2->userinfo->get();

    // These fields are currently filtered through the PHP sanitize filters.
    // See http://www.php.net/manual/en/filter.filters.sanitize.php
    $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['email'] = $email;
    $_SESSION['is_admin'] = 1;


    $_SESSION['email'] = $email;
    //$_SESSION['is_admin'] = 1;
    // The access token may have been updated lazily.
    $_SESSION['token'] = $client->getAccessToken();
} else {
    //redirect to login
    header('Location: login.php');
}

require 'functions.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>Hospice Care - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet" type="text/css" /> 
        <link href="css/flat-ui.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" />
        <link href="css/dailog.css" rel="stylesheet" type="text/css" />
        <!--                                    <link href="css/calendar.css" rel="stylesheet" type="text/css" /> -->
        <link href="css/dp.css" rel="stylesheet" type="text/css" />   
        <link href="css/alert.css" rel="stylesheet" type="text/css" /> 
        <link href="css/ajaxload.css" rel="stylesheet" type="text/css" /> 

        <link href="css/calendar.css" rel="stylesheet" type="text/css" /> 

        <link rel="shortcut icon" href="images/favicon.ico">
        <style type="text/css">
            ul { margin:0px; padding:0px; margin-left:20px; }
            #list1, #list2 { list-style-type:none; margin:0px; }
            #list1 li, #list2 li { float:left; padding:5px; width:28%; height:144px;}
            #list1 div, #list2 div {  background-color:#E0E0E0; text-align:center; position: relative;}
            #list2 { float:right; }
            .placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
        </style>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body>
        <input type="hidden" value="amit@ajency.in" id="loggedinemail"/>
<!--                                             <input type="hidden" value="<?php echo $_SESSION['email'] ?>" id="loggedinemail"/>-->
        <script type="text/javascript">
            var SITE_URL = "<?php echo $_SERVER['HTTP_HOST'] == 'localhost' ? 'http://' . $_SERVER['HTTP_HOST'] . '/fatboyslim/index.php' : 'http://' . $_SERVER['HTTP_HOST'] . '/hospice/index.php'; ?>";
        </script>
        <script type="text/template" id="user_access_pagination">

            <div class="mbl" id="useracess_listpagination">
            <div class="pagination">
            <ul>
            <li class="previous">
            <a href="#fakelink" class="fui-arrow-left" paginate-no="<%= (active - 1 > 0) ? active - 1 : 1  %>"></a>
            </li>
            <% for(var i = 1; i <= length; i++){
            var c = active == i ? "active" : "";
            %>
            <li class="<%= c  %>">
            <a href="#users/page/" paginate-no="<%= i %>"><%= i %></a>
            </li>
            <% }; %>
            <li class="previous">
            <a href="#fakelink" class="fui-arrow-right" paginate-no="<%= (active + 1 > length) ? length : active + 1 %>"></a>
            </li>
            </ul>
            </div>
            </div>

        </script>
        <script type="text/template" id="team_access_pagination">

            <div class="mbl" id="teamacess_listpagination">
            <div class="pagination">
            <ul>
            <li class="previous">
            <a href="#fakelink" class="fui-arrow-left" paginate-no="<%= (active - 1 > 0) ? active - 1 : 1  %>"></a>
            </li>
            <% for(var i = 1; i <= length; i++){
            var c = active == i ? "active" : "";
            %>
            <li class="<%= c  %>">
            <a href="#users/page/" paginate-no="<%= i %>"><%= i %></a>
            </li>
            <% }; %>
            <li class="previous">
            <a href="#fakelink" class="fui-arrow-right" paginate-no="<%= (active + 1 > length) ? length : active + 1 %>"></a>
            </li>
            </ul>
            </div>
            </div>

        </script>
        <script type="text/templates" id="team_access_row">
            <div id="team<%= id %>" teamid="11" class="innertxt">
            <ul>
            <li id=li_team<%= id %>>
            <input type="checkbox" id="select_team<%= id %>" name="team_access" value="<%= id %>" class="selectit1" /><label for="select11">&nbsp;&nbsp;<%= team_name %></label>
            </li>
            </ul>
            </div>
        </script>
        <script type="text/templates" id="team_all_access_row">
            <div id="team<%= id %>" teamid="11" class="innertxt">
            <ul>
            <li id=li_team<%= id %>>
            <input type="checkbox" id="select_team<%= id %>" name="remove_team_list" value="<%= id %>" class="selectit1" /><label for="select11">&nbsp;&nbsp;<%= team_name %></label>
            <input class='team_access_class' id='team_access<%= id %>' name='team_access_rights' type='checkbox' value='<%= write_access %>' '<% if(write_access == "yes"){%>' checked '<% } %>' data-toggle='<%= id %>' />

            </li>
            </ul>
            </div>
        </script>
        <script type="text/templates" id="user_all_access_row">

            <div id="user<%= id %>" userid="1" class="innertxt">

            <ul>
            <li>
            <input type="checkbox" name="remove_users_list" id="select<%= id %>" value="<%= id %>" class="selectit" /><label for="select1">&nbsp;&nbsp;<%= email %></label>
            <input class='access_class' id='access<%= id %>' name='access_rights' type='checkbox' value='<%= access %>' '<% if(access == "yes"){%>' checked '<% } %>' data-toggle='<%= id %>' />
            </li>
            </ul>
            </div>

        </script>
        <script type="text/templates" id="user_access_row">

            <div id="user<%= id %>" userid="1" class="innertxt">

            <ul >
            <li id=li_<%= id %>>
            <input type="checkbox" name="user_access" id="select<%= id %>" value="<%= id %>" class="selectit" /><label for="select1">&nbsp;&nbsp;<%= email %></label>
            </li>
            </ul>
            </div>

        </script>
        <script type="text/templates" id="team-manage-access">
            <br><br/>
            <div class="span9" style="margin-left:0px;">
            <div id="team_access" class="stack stack-bg">
            <div class="row-fluid">
            <div class="form">
            <div class="formbox">        
            <div class="span5">
            <h2>Available Team Calendars</h2>
            <div class="box-header">
            <form class="form-search" style=" margin-top: 10px; margin-left: 5px; ">
            <div class="input-prepend">
            <button type="submit" class="btn btn-small"><span class="fui-search"></span></button>
            <input type="text" class="span2 small search-query search-query-rounded" placeholder="Search" id="search_team_calendars">
            </div>
            </form>
            </div>
            <div id="team_main_div">
            <div id="all_users1" class="alert box-side1" >


            <div class="float_break"></div> 
            </div>
            </div>

            </div>
            <div class="span2">
            <div style="width:100px; text-align:center; margin-left:20px; padding-top: 180px; width:75px; float:left;">
            <div id="loader9" style="display:none" class="modal_ajax_gif"><!-- Place at bottom of page --></div>
            <a  href="javascript:void(0);" id="move_right_team" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-right"></i>
            </a>
            <br /><br />
            <a  href="javascript:void(0);" id="move_left_team" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-left"></i>
            </a>
            <div class="float_break"></div>   
            </div>
            </div>
            <div class="span5">
            <h2>Calendars With Access</h2>
            <div class="box-header">
            <div class="row-fluid">
            <div class="span6"><h3>Team</h3></div>
            <div class="span6"><h3>Write Access</h3></div>
            </div>
            </div>
            <div id="selected_users1" class="alert box-side1"></div>
            <div class="float_break"></div> 
            </div> 
            </div>
            <div class="float_break"></div>

            </div>
            <div class="form_bot"></div>
            </div>
            </div>
            </div>

        </script>
        <script type="text/templates" id="user-manage-access">
            <div  class="span9">
            <div id="loader7"  style="display:block" class="modal_ajax_large"><!-- Place at bottom of page --></div>	
            <div id="user_access" class="stack stack-bg">
            <div class="row-fluid">
            <!--            <a href="#users" onClick="window.history.back('users')" class="btn btn-info" style="margin: 8px;"> <i class="icon-chevron-sign-left"></i> View all</a>
            <h3 style=" margin-left: 7px; ">Manage Access - <%= name %> </h3>
            <hr style="margin: 13px 0;border-top: 1px solid #DDDCDC;">-->
            <div class="form">
            <div class="formbox">        
            <div class="span5">
            <h2>Available User Calendars</h2>
            <div class="box-header">
            <form class="form-search" style=" margin-top: 10px; margin-left: 5px; ">
            <div class="input-prepend">
            <button type="submit" class="btn btn-small"><span class="fui-search"></span></button>
            <input type="text" class="span2 small search-query search-query-rounded" placeholder="Search" id="search_user_calendars">
            </div>
            </form>
            </div>
            <input type="hidden" id="current_user" value="1" ></input>
            <div id="users_main_div">
            <div id="all_users" class="alert box-side1" >



            <div class="float_break"></div> 
            </div>
            </div>
            </div>
            <div class="span2">
            <div style="width:100px; text-align:center; margin-left:20px; padding-top: 180px; width:75px; float:left;">
            <div id="loader8" style="display:none" class="modal_ajax_gif"><!-- Place at bottom of page --></div>
            <a  href="javascript:void(0);" id="move_users_right" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-right"></i>
            </a>
            <br /><br />
            <a  href="javascript:void(0);" id="move_users_left" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-left"></i>
            </a>
            <div class="float_break"></div>   
            </div>
            </div>
            <div class="span5">
            <h2>Calendars With Access</h2>
            <div class="box-header">
            <div class="row-fluid">
            <div class="span6"><h3>User</h3></div>
            <div class="span6"><h3>Write Access</h3></div>
            </div>
            </div>
            <div id="selected_users" class="alert box-side1"></div>
            <div class="float_break"></div> 
            </div> 
            </div>
            <div class="float_break"></div>

            </div>
            <div class="form_bot"></div>
            </div>
            </div>
            </div>
        </script>
        <script type="text/template" id="main-calendar">
            <div class="span9">
            <div style=" width: 97%; ">

            <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">My Calendar</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
            <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          

            <div id="caltoolbar" class="ctoolbar">
            <!--
            <div id="faddbtn" class="fbutton">
            <div><span title='Click to Create New Event' class="addcal">

            New Event                
            </span></div>
            </div>
            <div class="btnseparator"></div>-->
            <div id="showtodaybtn" class="fbutton">
            <div><span title='Click to back to today ' class="showtoday">
            Today</span></div>
            </div>
            <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton ">
            <div><span title='Day' class="showdayview">Day</span></div>
            </div>
            <div  id="showweekbtn" class="fbutton ">
            <div><span title='Week' class="showweekview">Week</span></div>
            </div>
            <div  id="showmonthbtn" class="fbutton fcurrent ">
            <div><span title='Month' class="showmonthview">Month</span></div>

            </div>
            <div class="btnseparator"></div>
            <div  id="showreflashbtn" class="fbutton">
            <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
            </div>
            <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Prev"  class="fbutton">
            <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Next" class="fbutton">
            <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
            <div>
            <input type="hidden" name="txtshow" id="hdtxtshow" />
            <span id="txtdatetimeshow">Loading</span>

            </div>
            </div>

            <div class="clear"></div>
            </div>
            </div>
            <div >

            <div class="t1 chromeColor">
            &nbsp;</div>
            <div class="t2 chromeColor">
            &nbsp;</div>
            <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
            </div>
            <div class="t2 chromeColor">

            &nbsp;</div>
            <div class="t1 chromeColor">
            &nbsp;
            </div>   
            </div>

            </div>


            </div>
        </script>
        <script type="text/template" id="main-calendar-container">
            <div class="row-fluid" style="padding:12px;">                                   
            <div class="span3">
            <h5>See Calendar For</h5>

            <div class="accordion" id="accordion2">
            <ul class="calendar-list">
            <li class="user_box">
			<i class="icon-user" style=" color: #ADB1B4; margin-right: 3px; "></i>
            Me &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="label label-small label-inverse user_icon" >&nbsp;</span>
            </li>
            </ul>
            </div>
            <div id="loader1" class="modal_ajax" ></div>
            </div>
            </div>
            </div>
        </script>
        <script type="text/template" id="see_team_calendar_users">
            <div class="accordion-group">
            <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= team %>">
            Team -  <%= team %>
            </a>
            </div>
            <div id="collapse<%= team %>" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="calendar-list">

            <% for(var i=0; i < email.length; i++) { %><li>
            <input type="checkbox"  value="<%= email[i] %>" id="checkbox2" name="checkbox2" class="check_hide">
           &nbsp; <%= email[i] %>
            <span class="label label-small label-inverse">
            <% } %> </li>


            </ul>
            </div>
            </div>
            </div>
        </script>
        <script type="text/template" id="team_list">
            <div class="span9">
            <div class="dialog dialog-tab" style="padding:5px;">
            <div class="row-fluid">

            <div class="span4">

            </div>
            </div>
            <div class="row-fluid team-box">

            <div id="select-box" class="span3">
            <select id="drop-down" name="small" class="select-block select-team" style="margin: 8px;">
            <option value="Select"  selected>SELECT</option>
            </select>

            </div> <div id="loader" class="modal_ajax"><!-- Place at bottom of page --></div>
            <div class="span6"></div>
            <div class="span3">
            <a href="#teams"  id="add-team" style="margin: 8px" class="btn btn-small btn-block btn-info add-team " data-toggle="modal">
            <i class="fui-plus-inverted"></i>  &nbsp;Add Team</a>
            </div>
            </div>
            </div>
            <div id="loader2"  style="display:none" class="modal_ajax_large"><!-- Place at bottom of page --></div>
            <div class="stack stack-bg">
            <div class="row-fluid">

            <div class="form">

            <div class="formbox">        
            <div class="span5" id="all_users">
            <h2>All Users</h2>
            <div class="box-header">
            <form class="form-search" style=" margin-top: 10px; margin-left: 5px; ">
            <div class="input-prepend">
            <button type="submit" class="btn btn-small"><span class="fui-search"></span></button>
            <input type="text" class="span2 small search-query search-query-rounded" placeholder="Search" id="search-team-users">
            </div>
            </form>
            </div>

            <div id="all_users2" class="alert box-side1" >


            </div>

            <div class="float_break"></div> 


            </div>

            <div class="span2">

            <div style="width:100px; text-align:center; margin-left:20px; padding-top: 180px; width:75px; float:left;">
            <div id="loader1" style="display:none" class="modal_ajax_gif"><!-- Place at bottom of page --></div>
            <a  href="javascript:void(0);" id="move_right2" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-right"></i>
            </a>
            <br /><br />
            <a  href="javascript:void(0);" id="move_left2" class="btn btn-large btn-info mlm">
            <i class="fui-arrow-left"></i>
            </a>
            <div class="float_break"></div>   
            </div>
            </div>
            <div class="span5">
            <h2>Team Members </h2>
            <div class="box-header">
            <div class="row-fluid">
            <div class="span12"><h3>Team</h3></div>
            </div>
            </div>
            <div  class="alert box-side2">
            <div id="selected_users2" teamsid="12" class="innertxt box-side1">

            </div></div>
            <div class="float_break"></div> 
            </div> 
            </div>
            <div class="float_break"></div>

            </div>
            <div class="form_bot"></div>
            </div>
            </div>

            </div>
        </script>


        <script type="text/template" id="team-dialog">

            <div id="Adduser"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4><i class="fui-document platform"></i> Add a Team</h4>
            </div>

            <div class="modal-body " style="height:auto;">
            <div class="content" id="content_1" >
            <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label" for="in-name">Team Name</label>
            <div class="controls">
            <input type="text" id="in-name" style="height:30px" class="span3">
            </div>
            </div>
            </form>
            <div id="loader_team" style="display:none" class="modal_ajax_gif_team"><!-- Place at bottom of page --></div>
            </div>
            <div id="error_text" style="display:none;font-family:arial;font-size:10px;color:red;">*Please enter a team name</div>
            <div id="error_text_two" style="display:none;font-family:arial;font-size:10px;color:red;">*Team Exists</div>
            </div>
            <div class="modal-footer">
            <button id="close" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button id="save_poup" class="btn btn-primary" aria-hidden="true">Save changes</button>

            </div>
            </div>

        </script>
        <div class="mtl pbl mtn">
            <div class="bottom-menu top-menu">
                <div class="container">
                    <div class="row">
                        <div class="span2 brand">
                            <a href="#"><img src="images/hospice.png"/> </a>
                        </div>
                        <div class="span6">
                        </div>
<?php if (is_admin()): ?>
                            <div class="span2">
                                <a href="#users" class="btn btn-small btn-block btn-info btn-color"><i class="icon-credit-card"></i>  &nbsp;Manage Access</a>
                            </div>
<?php endif; ?>
                        <div class="span2">
                            <div class="btn-group mtn mtn-drop">
                                <i class="dropdown-arrow dropdown-arrow-inverse">
                                </i>
                                <button class="btn btn-inverse btn-huge">
                                    <i class="icon-user">
                                    </i>
                                    &nbsp;My Profile
                                </button>
                                <button class="btn btn-inverse btn-huge dropdown-toggle btn-caret" data-toggle="dropdown">
                                    <span class="caret">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-inverse">
                                    <li>
                                        <a href="#fakelink" class="logout">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /bottom-menu-inverse -->
            <div class="dialog s-menu" style="padding:5px;" id="breadcrum">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span8">
                            <ul class="breadcrumb bredcrumb-new">
                                <li id="dashboard"><a href="">Dashboard</a></li>
                                <li id="breadcrumbs">

                                </li>
                            </ul>

                        </div>
                        <!--
                        <div class="span4">
                            <form class="form-search">
                                <div class="input-append">
                                    <input type="text" class="span2 small search-query search-query-rounded"
                                           placeholder="" id="search-query-8" >
                                        <button type="submit" class="btn btn-small">
                                            <span class="fui-search">
                                            </span>
                                        </button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="main-container" >

        </div>

        <!-- Load JS here for greater good =============================-->
        <script data-main="js/app" src="js/require.js"></script>

    </body>
</html>
