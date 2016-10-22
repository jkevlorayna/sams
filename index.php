<?php $path = 'core/' ?> 
<?php 
session_start(); 
if(!isset($_SESSION['isAuthenticated'])){ $isAuthenticated = false; }else{ $isAuthenticated = true; }
?>

<?php include('core/header.php'); ?>
<body class="texture" ng-controller="AppMainController" ng-init="<?php echo $isAuthenticated; ?>">
	<div style="width:400px;" growl></div>
	
<div id="cl-wrapper">

  <div class="cl-sidebar" ng-show="session.isAuthenticated" ng-if="Sidebar">
    <div class="cl-toggle"><i class="fa fa-bars"></i></div>
    <div class="cl-navblock">
      <div class="menu-space">
        <div class="content">
		<div class="text-center">
			<img src="core/images/logo.png" class="img-responsive" style="max-height:140px;margin:0 auto;">
		</div>	
          <ul class="cl-vnavigation">
			        <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
					<li ng-repeat="mtrow in memberTypeList"><a href="#/member/list/{{mtrow.Id}}"><i class="fa fa-group"></i>  
					{{mtrow.type}}</a></li>
					<li><a href="#/user/list"><i class="fa fa-group"></i> User List</a></li>
					<li><a href="#/event/list"><i class="fa fa-file"></i> Event</a></li>
					<li><a href="#/barcode/generate"><i class="fa fa-barcode"></i> Genrate Barcode</a></li>
				<li>
					<a href="#"><i class="fa fa-folder"></i><span>Selection Menu</span></a> 
					<ul class="sub-menu">						
							<li><a href="#/course/list">Course</a></li>
							<li><a href="#/schoolyear">School Year</a></li>
							<li><a href="#/user/type">User Type</a></li>
							<li><a href="#/member/type">Member Type</a></li>
							<li><a href="#/status">Status</a></li>
							<li><a href="#/semester">Semester</a></li>
					</ul>		
				</li>

          </ul>
        </div>
      </div>
    </div>
  </div>


	
		<div class="container-fluid" id="pcont">
				
				  <div id="head-nav" class="navbar navbar-default" ng-show="session.isAuthenticated" ng-if="Navigation">
    <div class="container-fluid">
      <div class="navbar-collapse">
        <ul class="nav navbar-nav navbar-right user-nav">	
          <li class="dropdown profile_menu">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
				<span>Welcome: {{session.userData.name}}</span> <b class="caret"></b>
			</a>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" ng-click="passwordModal('md',session.userData.user_id,'Admin')"> Change Password</a></li>
			  <li class="divider"></li>
              <li><a href="javascript:void(0)" ng-click="logout()"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>
        </ul>	
			<h3><i class="fa fa-gears"></i>Student Attendance Management System Administrator</h3>
      </div>
    </div>
  </div>

				
				<div class="cl-mcont main_con">
						<div ui-view></div>
				</div>
	</div> 
	
</div>
<?php include('core/script.php') ?>
<div cg-busy="true"></div>
</body>
</html>
