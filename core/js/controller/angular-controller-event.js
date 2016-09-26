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

app.controller('AppEventDetailsController', function ($scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams) {
$scope.Id = $stateParams.Id;

	
});
app.controller('AppEventFormController', function ($scope, $http, $q, $location, svcEvent,growl,$uibModal,$stateParams,svcEventDetails) {
$scope.Id = $stateParams.Id;

	$scope.formData = { EventId : $scope.Id  }
	$scope.save = function () {
		svcEventDetails.Save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
			$scope.formData = { EventId : $scope.Id  }
        });
    }
	
});