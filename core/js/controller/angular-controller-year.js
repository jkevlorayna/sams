app.controller('AppYearController', function ($rootScope,$scope, $http, $q, $location, $filter, svcYear,growl,$uibModal) {
	
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		svcYear.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	

	
	$scope.formData = {}
	$scope.save = function () {
		svcYear.save($scope.formData).then(function (r) {
			 growl.success("Data Successfully Saved!");
			 $scope.formData = {}
			$scope.load();
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcYear.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppYearModalController',
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
app.controller('AppYearModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcYear,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcYear.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	