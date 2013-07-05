
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
     <script type="text/template" id="tab2-data">
		<div class="tab-pane" id="tab2">
              <p>Howdy, I'm in Section 2.</p>
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
<div class="container" id="main-container">
   
</div>
<!-- Load JS here for greater good =============================-->
<script data-main="js/app" src="js/require.js"></script>
</body>
</html>
