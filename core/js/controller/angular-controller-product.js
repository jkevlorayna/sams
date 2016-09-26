app.controller('AppProductController', function ($scope, $http, $q, $location, $filter, svcProduct,$uibModal) {
	$scope.pageNo = 1;
	$scope.pageSize = 10;
		
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
    $scope.load = function () {
		svcProduct.list($scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }

	$scope.pageChanged = function () { $scope.load(); }
	
	$scope.openDeleteModal = function (size,id) {
			var modal = $uibModal.open({
			templateUrl: 'views/deletemodal/deleteModal.html',
			controller: 'AppProductModalController',
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
	
$scope.load();
	
});
app.controller('AppProductModalController', function ($rootScope,$scope, $http, $q, $location, $filter, svcProduct,growl,$uibModal,dataId,$uibModalInstance) {
	$scope.id = dataId;
	$scope.close = function(){
		$uibModalInstance.dismiss();
	}
	

	$scope.delete = function () {
		svcProduct.deleteData($scope.id).then(function (response) {
			growl.error("Data Successfully Deleted");
			$scope.close();
        }, function (error) {

        });
    }
});	
app.controller('AppAddEditProductController', function ($scope, $http, $q, $location, svcProduct,svcCategory,svcUnits,$stateParams,growl) {
	$scope.id = $stateParams.id
	
    $scope.loadAll = function () {
			$q.all([svcUnits.list('',0,0),svcCategory.list('',0,0)]).then(function(r){
				$scope.unitsList = r[0].Results;
				$scope.categoryList = r[1].Results;
			});
    }
	$scope.loadAll();
  
	$scope.getById = function () {
		svcProduct.getById($scope.id).then(function (r) {
				$scope.formData =  r
        }, function (error) {

        });
    }
	
	
		if($scope.id == 0){ 
			$scope.formData = { }
		}else{ 
			$scope.getById(); 
		}
	
	$scope.save = function () {
		svcProduct.save($scope.formData).then(function (r) {
			$location.path('/product/list');
			growl.success("Data Successfully Save");
        }, function (error) {

        });
    }
	
	
});




app.controller('AppUserProductController', function ($rootScope,$scope, $http, $q, $location, svcProduct,svcCart,svcCategory,svcUnits,$stateParams,growl,$cookieStore) {
	$scope.category_id = $stateParams.category_id;
	$scope.pageNo = 0;
	$scope.pageSize = 0;
	if($scope.searchText == undefined){ $scope.searchText = ''; } 
		
	$scope.load = function () {
		$scope.message = $scope.searchText != '' ? false : true ;
		svcProduct.listByCategory($scope.category_id,$scope.searchText,$scope.pageNo,$scope.pageSize).then(function (r) {
            $scope.list = r.Results;
            $scope.count = r.Count;
        })
    }
    $scope.load();
	
	$scope.loadCategory = function () {
		svcCategory.list('',1,10).then(function (r) {
            $scope.categoryList = r.Results;
            $scope.categoryCount = r.Count;
        })
    }
    $scope.loadCategory();


	$scope.AddToCart = function(row,formData){
		
		row.MemberId = $scope.session.userData.Id;
		row.ProductId = row.Id;
		row.UserQty = formData.UserQty;
		row.Id = 0;
		
		$rootScope.CartCount = $rootScope.CartCount  + 1;

		svcCart.AddToCart(row).then(function (r) {
			growl.success("Product Added to Cart");
			formData.UserQty = '';
        })
	}
	
});
