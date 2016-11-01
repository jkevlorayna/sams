
app.controller('AppMainController', function ($rootScope,$scope, $http, $q, $location, $filter, $window,$cookieStore,$uibModal,svcLogin,svcMemberType,svcUserRole) {
   
	$rootScope.Sidebar = true;
	$rootScope.Navigation = true;
	
	$rootScope.loadCredentions = function(){
			$scope.cookieCheck = $cookieStore.get('credentials');
			if($scope.cookieCheck == undefined){
				$scope.session = { userData:{} , isAuthenticated: false,  loading: false };
				$scope.checkRole = function(role,action){
				return false;
			}	
		}else{
			$scope.session = { userData:$scope.cookieCheck , isAuthenticated: true,  loading: false };	
			$scope.checkRole = function(role,action){
				if($scope.session.userData.UserType == 'Administrator' || $scope.session.userData.UserType == 'Administrators'){
						return true;
				}else{
					$scope.role = $filter('filter')($scope.session.userData.Roles,{role:role})[0];
					if(action == 'AllowView'){
						return $scope.role.AllowView == 1 ? true : false;
					}else if(action == 'AllowAdd'){
						return $scope.role.AllowAdd == 1 ? true : false;
					}else if(action == 'AllowEdit'){
						return $scope.role.AllowEdit == 1 ? true : false;
					}else if(action == 'AllowDelete'){
						return $scope.role.AllowDelete == 1 ? true : false;
					}else{
						return  false;
					}
				}
			}
		}
	}
	$rootScope.loadCredentions();

					
	
	
	$scope.loadMemberType = function () {
		svcMemberType.list('',0,0).then(function (r) {
            $scope.memberTypeList = r.Results;
        })
    }
    $scope.loadMemberType();
	
   $scope.init = function (isAuthenticated) {
         $scope.session.isAuthenticated = isAuthenticated;
		 if (!$scope.session.isAuthenticated) { 
			 $location.path("/");
		 } 
    }



	
	$scope.logout = function(){
		svcLogin.logout($scope.formData).then(function (r) {
				$scope.session = { userData:{} , isAuthenticated: false,  loading: false };
				$cookieStore.remove('credentials');
				$rootScope.loadCredentions();
				$location.path("/login"); 
		});
	}

	
	$scope.passwordModal = function (size,id,user) {
			var modal = $uibModal.open({
			templateUrl: 'views/changePassword/modal.html',
			controller: 'AppChangePasswordModalController',
			size: size,
			resolve: {
				Id: function () {
					return id;
				},user:function(){
					return user;
				}
			}
			});
			modal.result.then(function () { }, function () { 
				
			});
	};
});


app.controller('AppChangePasswordModalController', function ( $scope, $http, $q, $location, $uibModalInstance , Id , user , svcLogin,growl ) {
	$scope.close = function(){ $uibModalInstance.dismiss(); }
	$scope.Id = Id;
	$scope.user = user;
});

app.controller('AppLoginController', function ($rootScope,$scope, $http, $q, $location, svcLogin,$cookieStore,$window ,growl ) {
	
		$scope.formData = {};
		$scope.login = function(){
				svcLogin.loginUser($scope.formData).then(function (r) {
					
					if(r.granted == 'true'){
						$cookieStore.put('credentials', r.Results);
						$scope.cookieCheck = $cookieStore.get('credentials');
				     	$scope.session.userData.name = $scope.cookieCheck.name;
				     	$scope.session.isAuthenticated = true;
						$rootScope.loadCredentions();
						if($scope.session.userData.name != null){
							growl.success("Access Granted");
							$location.path('/');
						}
					}else{
						growl.error("Login Failed. Please Check your username and Password");
						$scope.session.isAuthenticated = false;
					}

				}) 
		}
});
