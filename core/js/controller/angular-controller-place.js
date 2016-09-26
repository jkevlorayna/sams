app.controller('AppPlaceController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPlace,growl,$uibModal) {
	
	$scope.pageNo = 1;
	$scope.pageSize = 10;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
    $scope.load = function () {
		svcPlace.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.pageChanged = function () { $scope.load(); }
	

	
	$scope.formData = {}
	$scope.save = function () {
		svcPlace.save($scope.formData).then(function (r) {
			 growl.success("Data Successfully Saved!");
			 $scope.formData = {}
			$scope.load();
        }, function (error) {

        });
    }
	
	$scope.getById = function (id) {
		svcPlace.getById(id).then(function (r) {
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
app.controller('AppPlaceModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcPlace,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	$scope.delete = function () {
		svcPlace.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        });
    }
});	
app.controller('AppPlaceFormController', function ($scope, $http, $q, $location, svcPlace,svcCategory,svcYear,svcSubject,svcStatus,$stateParams,growl) {
$scope.Id = $stateParams.Id

	
    $scope.loadAll = function () {
			$q.all([svcSubject.list('',0,0),svcCategory.list('',0,0),svcYear.list('',0,0),svcStatus.list('',0,0)]).then(function(r){
				$scope.subjectList = r[0].Results;
				$scope.categoryList = r[1].Results;
				$scope.yearList = r[2].Results;
				$scope.statusList = r[3].Results;
			});
    }
	$scope.loadAll();
  
	$scope.getById = function () {
		svcPlace.getById($scope.Id).then(function (r) {
				$scope.formData =  r
        });
    }
	
	
	$scope.formData = $scope.Id == 0 ? {} : $scope.getById();
	$scope.save = function () {
		svcPlace.save($scope.formData).then(function (r) {
			growl.success("Data Successfully Save");
        });
    }
	

	
	
});