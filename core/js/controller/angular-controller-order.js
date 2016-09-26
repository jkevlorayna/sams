app.controller('AppUserOrderHistoryController', function ($scope, $http, $q, $location, svcOrder,growl,$uibModal) {
		
	$scope.load = function () {
		svcOrder.Search($scope.session.userData.Id).then(function (r) {
			$scope.list = r;
		});
    }
    $scope.load();
});
app.controller('AppUserOrderDetailsController', function ($scope, $http, $q, $location, svcOrder,growl,$uibModal,$stateParams) {
	$scope.id = $stateParams.id;	
	$scope.getById = function () {
		svcOrder.getById($scope.id).then(function (r) {
			$scope.list = r;
		
		});
    }
    $scope.getById();

	
});
app.controller('AppOrderController', function ($scope, $http, $q, $location, svcOrder,svcOrderStatus,growl,$uibModal) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
	if($scope.OrderStatus == undefined){ $scope.OrderStatus = 'all'; }  
		
	$scope.load = function () {
		svcOrder.OrderList($scope.searchText,$scope.pageNo,$scope.pageSize,$scope.OrderStatus).then(function (r) {
			$scope.list = r.Results;
			$scope.count = r.Count;
		});
    }
    $scope.load();
	
	$scope.loadStatus = function () {
		svcOrderStatus.list('',0,0).then(function (r) {
			$scope.StatusList = r.Results;

		});
    }
    $scope.loadStatus();
	
	$scope.editModal = function (id) {
			var modal = $uibModal.open({
			templateUrl: 'views/order/formModal.html',
			controller: 'AppOrderModalController',
			resolve: {
				dataId: function () {
					return id;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				$scope.load();
			});
	};
	
	

   

  
	
});


app.controller('AppOrderModalController', function ($scope, $http, $q, $location, svcOrder,svcOrderStatus,growl,$uibModalInstance,dataId) {
	$scope.id = dataId;
	$scope.formData = {};
	$scope.close = function(){ $uibModalInstance.dismiss() }
	$scope.getById = function(){
		svcOrder.getById($scope.id).then(function(r){
			$scope.formData = r.Order;
		});
	}
	$scope.getById();
	$scope.load = function(){
		svcOrderStatus.list('',0,0).then(function(r){
			$scope.list = r.Results;
			$scope.count = r.Count
		});
	}
	$scope.load();
	
	$scope.save = function(){
		svcOrder.Save($scope.formData).then(function(r){
			growl.success("Data Successfully Saved");
		});
	}
});
app.controller('AppOrderDetailsController', function ($scope, $http, $q, $location, svcOrder,growl,$uibModal,$stateParams) {
	$scope.id = $stateParams.id;
	$scope.getById = function () {
		svcOrder.getById($scope.id).then(function (r) {
			$scope.list = r;
		});
    }
    $scope.getById();
});

// reports controller 


app.controller('AppOrderReportDailyController', function ($scope, $q, svcOrder,svcOrderStatus) {
	$scope.datefrom = new Date();
	
 	$scope.load = function () {
		$scope.Newdatefrom = moment($scope.datefrom).format("YYYY-MM-DD");
		svcOrder.orderReport($scope.Newdatefrom,$scope.Newdatefrom).then(function (r) {
			$scope.list = r.Results;
			$scope.GrandTotal = r.GrandTotal;
		});
    }
    $scope.load();
});

app.controller('AppOrderReportSpecificController', function ($scope, $q, svcOrder,svcOrderStatus) {
	$scope.report = 'date';
	$scope.datefrom = new Date();
	$scope.dateto = new Date();
	
 	$scope.load = function () {
		$scope.Newdatefrom = moment($scope.datefrom).format("YYYY-MM-DD");
		$scope.Newdateto = moment($scope.dateto).format("YYYY-MM-DD");
		
		svcOrder.orderReport($scope.Newdatefrom,$scope.Newdateto).then(function (r) {
			$scope.list = r.Results;
			$scope.GrandTotal = r.GrandTotal;
		});
    }
    $scope.load();
});


app.controller('AppOrderReportYearController', function ($scope, $q, svcOrder,svcOrderStatus,svcYear) {
	$scope.report = 'yearly';
	$scope.year = moment(new Date()).year().toString();


	$scope.loadYear = function () {
		svcYear.list('',0,0).then(function (r) {
			$scope.yearList = r.Results;
		});
    }
    $scope.loadYear();
	
 	$scope.load = function () {
		$scope.datefrom = moment([$scope.year]).format("YYYY-MM-DD");
		$scope.dateto = moment($scope.datefrom).endOf('year').format("YYYY-MM-DD");
			
		svcOrder.orderReport($scope.datefrom,$scope.dateto).then(function (r) {
			$scope.list = r.Results;
			$scope.GrandTotal = r.GrandTotal;
		});
    }
    $scope.load();
});


app.controller('AppOrderReportMonthController', function ($http,$scope, $q, svcOrder,svcOrderStatus,svcYear) {
	$scope.report = 'date';
	$scope.year = moment(new Date()).year().toString();
	$scope.month = (moment(new Date()).month() + 1).toString();
	



	
	$scope.loadMonth = function () {
         $http({
             method: 'GET',
             url: BasePath+'/js/controller/json/month.json',
         }).success(function (r) {
			$scope.monthList = r;
		 });
    }
    $scope.loadMonth();
	$scope.loadYear = function () {
		svcYear.list('',0,0).then(function (r) {
			$scope.yearList = r.Results;
		});
    }
    $scope.loadYear();
	
	
 	$scope.load = function () {

			$scope.datefrom = moment([$scope.year, $scope.month - 1]).format("YYYY-MM-DD");
			$scope.dateto = moment($scope.datefrom).endOf('month').format("YYYY-MM-DD");

		svcOrder.orderReport($scope.datefrom,$scope.dateto).then(function (r) {
			$scope.list = r.Results;
			$scope.GrandTotal = r.GrandTotal;
		});
    }
    $scope.load();

});