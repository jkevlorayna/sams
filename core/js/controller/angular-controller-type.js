
app.controller('AppTypeController', function ($scope, $http, $q, $location, $filter, svcType,growl,$uibModal) {
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		svcType.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	
	
	$scope.pageChanged = function () { $scope.load();}
	

	
	$scope.formData = {};
	$scope.save = function () {

	
		 // var postData = new FormData();
		 // postData.append('type', $scope.type);    
         // postData.append('file', $scope.photo);
 

		
		svcType.save($scope.formData).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Save");
			$scope.formData = {};
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcType.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppTypeModalController',
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
app.controller('AppTypeModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcType,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcType.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	