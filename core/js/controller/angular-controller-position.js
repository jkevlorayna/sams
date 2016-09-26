
app.controller('AppPositionController', function ($scope, $http, $q, $location, $filter, svcPosition,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		svcPosition.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
			console.log($scope.count);
        })
    }
    $scope.load();
	
	
	$scope.PositionSelect = function (search) {
		return svcPosition.getByName(search,$scope.pageNo,$scope.pageSize);
    }

	
	
	
	$scope.pageChanged = function () {
		console.log($scope.pageSize);
			$scope.load();
    }
	

	
	$scope.formData = { }
	$scope.save = function () {
		console.log($scope.formData);
		svcPosition.save($scope.formData).then(function (r) {
			$scope.load();
			$scope.formData = { }
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcPosition.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }


	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppPositionModalController',
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
app.controller('AppPositionModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPosition,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPosition.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
