
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
    <div class="dialog s-menu" style="padding:5px;">
        <div class="container">
            <div class="row-fluid">
                <div class="span9">
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
                <div class="span3">
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
<div class="container ">
    <ul class="nav nav-tabs nav-append-content">
        <li class="active">
            <a href="#tab1">User</a>
        </li>
        <li>
            <a href="#tab2">Terms</a>
        </li>
    </ul>
    <div class="tab-content main-content">
        <div class="tab-pane active" id="tab1">
            <div class="row-fluid">
                <div class="span9">
                    <div class="dialog dialog-tab" style="padding:5px;">
                        <div class="row-fluid">
                            <div class="span8">
                                <!--<ul class="breadcrumb bredcrumb-new">
                                <li><a href="#">Calender</a> <span class="divider">/</span></li>
                                <li class="active">Users</li>
                                </ul>-->
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
                    <!-- Table View -->
                    <div class="demo-content-wide">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Team
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Rambo Schewll
                                    </td>
                                    <td>
                                        Ramboschewll@hotmail.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Rambo Schewll Team1
                                        </span>
                                        <span class="label label-inverse">
                                            Team 2
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sam Marchel
                                    </td>
                                    <td>
                                        sam878@gmail.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Sam Marchel Team2
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Rayamond
                                    </td>
                                    <td>
                                        rayamand74714@yahoo.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Rayamond Team1
                                        </span>
                                        <span class="label label-inverse">
                                            Team 2
                                        </span>
                                        <span class="label label-inverse">
                                            Team 3
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Rihnaa Talyor
                                    </td>
                                    <td>
                                        sesa_talayou@gmail.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Rihnaa Talyor Team2
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Simon
                                    </td>
                                    <td>
                                        simon555@yahoo.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Simon Team2
                                        </span>
                                        <span class="label label-inverse">
                                            Team 2
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Rihnaa Talyor
                                    </td>
                                    <td>
                                        sesa_talayou@gmail.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Rihnaa Talyor Team2
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Simon
                                    </td>
                                    <td>
                                        simon555@yahoo.com
                                    </td>
                                    <td>
                                        <span class="label label-inverse">
                                            Simon Team2
                                        </span>
                                        <span class="label label-inverse">
                                            Team 2
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--End Table View -->
                    <!--Pagination View -->
                    <div class="mbl">
                        <div class="pagination pagination-layout">
                            <ul>
                                <li class="previous">
                                    <a href="#fakelink" class="fui-arrow-left"></a>
                                </li>
                                <li class="active">
                                    <a href="#fakelink">1</a>
                                </li>
                                <li>
                                    <a href="#fakelink">2</a>
                                </li>
                                <li>
                                    <a href="#fakelink">3</a>
                                </li>
                                <li>
                                    <a href="#fakelink">4</a>
                                </li>
                                <li>
                                    <a href="#fakelink">5</a>
                                </li>
                                <li>
                                    <a href="#fakelink">6</a>
                                </li>
                                <li>
                                    <a href="#fakelink">7</a>
                                </li>
                                <li>
                                    <a href="#fakelink">8</a>
                                </li>
                                <li>
                                    <a href="#fakelink">9</a>
                                </li>
                                <li>
                                    <a href="#fakelink">10</a>
                                </li>
                                <li class="pagination-dropdown dropup">
                                    <i class="dropdown-arrow">
                                    </i>
                                    <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fui-triangle-up"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#fakelink">10-20</a>
                                        </li>
                                        <li>
                                            <a href="#fakelink">20-30</a>
                                        </li>
                                        <li>
                                            <a href="#fakelink">40-50</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="next">
                                    <a href="#fakelink" class="fui-arrow-right"></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /pagination -->
                    </div>
                    <!--End Pagination View -->
                </div>
                <div class="span3">
                    <div class="alert alert-info">
                        <h3>
                            Manage Access Screen
                        </h3>
                        <p>
                            Display a list of all users with emails they belong to.
                        </p>
                        <hr>
                        <h6>
                            <i class="icon-external-link">
                            </i>
                            Action
                        </h6>
                        Click on a username to manage access
                    </div>
                </div>
            </div>
        </div>
        <!-- /tabs -->
        <div class="tab-pane" id="tab2">
            <p>
                Howdy, I'm in Section 2.
            </p>
        </div>
    </div>
</div>
<!-- Load JS here for greater good =============================-->
<script data-main="js/app" src="js/require.js"></script>
</body>
</html>
