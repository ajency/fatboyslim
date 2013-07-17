
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8">
            <title>Hospice Care - Dashboard</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <!-- Loading Bootstrap -->
                <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
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
                                    <link href="css/main.css" rel="stylesheet" type="text/css" /> 
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
                                                <div id="faddbtn" class="fbutton">
                                                <div><span title='Click to Create New Event' class="addcal">

                                                New Event                
                                                </span></div>
                                                </div>
                                                <div class="btnseparator"></div>
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
                                                <input type="checkbox"  value="<%= email[i] %>" id="checkbox2" name="checkbox2">
                                                <%= email[i] %>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                <div class="span8">
                                                <ul class="breadcrumb bredcrumb-new">
                                                <li><a href="#">Calender</a> <span class="divider">/</span></li>
                                                <li class="active">Teams </li>
                                                </ul>
                                                </div>
                                                <div class="span4">

                                                </div>
                                                </div>
                                                <div class="row-fluid team-box">

                                                <div id="select-box" class="span3">
                                                <select id="drop-down" name="small" class="select-block select-team">
                                                <option value="Select"  selected>SELECT</option>
                                                </select>

                                                </div> <div id="loader" class="modal_ajax"><!-- Place at bottom of page --></div>
                                                <div class="span6"></div>
                                                <div class="span3">
                                                <a href="#teams"  id="add-team" class="btn btn-small btn-block btn-info add-team " data-toggle="modal">
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
                                                <h2>All users</h2>
                                                <div class="box-header">
                                                <form class="form-search" style=" margin-top: 10px; margin-left: 5px; ">
                                                <div class="input-prepend">
                                                <button type="submit" class="btn btn-small"><span class="fui-search"></span></button>
                                                <input type="text" class="span2 small search-query search-query-rounded" placeholder="Search" id="search-query-9">
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
                                                <div class="span6"><h3>Team</h3></div>
                                                <div class="span6"><h3>Write Access</h3></div>
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
                                                <input type="text" id="in-name" placeholder="" class="span3">
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
                                                <button id="save" class="btn btn-primary">Save changes</button>

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
                                                            <div class="span2">
                                                                <a href="#fakelink" class="btn btn-small btn-block btn-info btn-color"><i class="icon-credit-card"></i>  &nbsp;Manage Access</a>
                                                            </div>
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
                                                                            <a href="#fakelink">Sub Menu Element</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#fakelink">Sub Menu Element</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#fakelink">Sub Menu Element</a>
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
                                                                    <li>
                                                                        <a href="#calendar">Calender</a>
                                                                        <span class="divider">
                                                                            /
                                                                        </span>
                                                                    </li>
                                                                    <li class="active">
                                                                        Users
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="span4">
                                                                <form class="form-search">
                                                                    <div class="input-append">
                                                                        <input type="text" class="span2 small search-query search-query-rounded"
                                                                               placeholder="Search" id="search-query-8">
                                                                            <button type="submit" class="btn btn-small">
                                                                                <span class="fui-search">
                                                                                </span>
                                                                            </button>
                                                                    </div>
                                                                </form>
                                                            </div>
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
