
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8">
            <title>Hospice Care - Dashboard</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <!-- Loading Bootstrap -->
                <link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
                <link type="text/css" rel="stylesheet" href="css/font-awesome.css" />
                <link type="text/css" rel="stylesheet" href="css/scrollbarcss.css" />
                <link type="text/css" rel="stylesheet" href="css/ajaxload.css" />
                <!-- Loading Flat UI -->
                <link type="text/css" rel="stylesheet" href="css/flat-ui.css" />
                <link type="text/css" rel="stylesheet" href="css/style.css" />
                <link rel="shortcut icon" href="images/favicon.ico">
                    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
                    <!--[if lt IE 9]>
                      <script src="js/html5shiv.js"></script>
                    <![endif]-->
                    </head>
                    <body>

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
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
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
                                                    <a href="#">Calender</a>
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
                        <div class="container" id="main-container">

                        </div>

                        <!-- Load JS here for greater good =============================-->
                        <script data-main="js/app" src="js/require.js"></script>
                    </body>
                    </html>
