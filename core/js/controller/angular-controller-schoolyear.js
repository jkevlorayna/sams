app.controller('AppSchoolYearController', function ($rootScope,$scope, $http, $q, $location, $filter, svcSchoolYear,growl,$uibModal) {
	
		$scope.pageNo = 1;
		$scope.pageSize = 10;
		
    $scope.load = function () {
		if($scope.searchText == undefined){
			$scope.searchText = '';
		} 
		svcSchoolYear.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.SaveAll = function () {
		svcSchoolYear.SaveAll($scope.list).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Saved!");
        });
    }
	
	
	$scope.pageChanged = function () {
		$scope.load();
    }
	
	$scope.ClearRadio = function(){
		$scope.list.map(function(r){
			r.Current = 0;
		})
	}

	$scope.formData = {}
	$scope.save = function () {
		svcSchoolYear.save($scope.formData).then(function (r) {
			 growl.success("Data Successfully Saved!");
			 $scope.formData = {}
			$scope.load();
        }, function (error) {

        });
    }
	
	$scope.SaveRow = function (row) {
		svcSchoolYear.save(row).then(function (r) {
			$scope.load();
			growl.success("Data Successfully Saved!");
        });
    }

	$scope.getById = function (id) {
		svcSchoolYear.getById(id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppSchoolYearModalController',
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
app.controller('AppSchoolYearModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcSchoolYear,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcSchoolYear.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	