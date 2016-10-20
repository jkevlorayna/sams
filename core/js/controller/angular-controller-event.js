app.controller('AppEventController', function ($scope, $http, $q, $location, svcEvent,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		
    $scope.load = function () {

		svcEvent.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load();}
	

	$scope.formData = {  }
	$scope.save = function () {
		console.log($scope.formData);
		svcEvent.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {  }
        });
    }
	
	$scope.getById = function (id) {
		svcEvent.getById(id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppEventModalController',
			size: size,
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
app.controller('AppEventModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcEvent,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcEvent.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	

app.controller('AppEventDetailsController', function ($rootScope,$scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams,svcEventDetails,svcEvent) {
	$scope.Id = $stateParams.Id;
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){
			$scope.searchText = '';
	} 
	$scope.getById = function(){
		svcEvent.getById($scope.Id).then(function(r){
			$scope.formData = r;
		})
	}	
	$scope.getById();
	$scope.load = function(){
		svcEventDetails.List('',0,0,$scope.Id).then(function(r){
			$scope.list = r.Results;
			$scope.count = r.Count;
		})
	}
	$scope.load();
});
app.controller('AppEventFormController', function ($rootScope,$scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams,svcEventDetails,$timeout) {
$scope.Id = $stateParams.Id;

$rootScope.Sidebar = false;
$rootScope.Navigation = false;
$scope.Message = null;
	$scope.getById = function(){
		svcEvent.getById($scope.Id).then(function(r){
			$scope.formData = r;
			$scope.formData.Id = 0;
		})
	}
	$scope.getById();


	$scope.save = function () {
		$scope.formData.EventId = $scope.Id;
		svcEventDetails.Save($scope.formData).then(function (r) {
			// console.log(r);
			if(r == 0){
				growl.error("Member Does Not Exist");
			}else{
				growl.success("Data Successfully Save");
				$scope.Message = "Welcome " + r.firstname + " " + r.lastname;
				
				    $timeout(function() { $scope.Message = null; }, 5000);
			}
				
				$scope.formData = { EventId : $scope.Id  }
				$scope.getById();
        });
    }
	
});