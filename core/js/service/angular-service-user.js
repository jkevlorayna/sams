app.factory('svcUser', function ($rootScope, $http, $q) {
    $this = {

        list: function (searchText,pageNo,pageSize) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/user?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        },
		  getById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/user/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        },
		deleteData: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/user/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/user',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data.Results;
                $this.count = data.Count;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});


app.factory('svcUserRole', function ($rootScope, $http, $q) {
    $this = {
		 UserRoles: function (UserId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/userRole/UserRoles/'+UserId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
        roles: function (UserId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/roles/'+UserId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
        list: function (UserId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/userRole?UserId='+UserId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		  getById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/userRole/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		deleteData: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/userRole/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/userRole',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});


app.factory('svcUserType', function ($rootScope, $http, $q) {
    $this = {

        list: function (searchText,pageNo,pageSize) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/userType?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        },
		getById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/userType/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        },
		deleteData: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/userType/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/userType',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data.Results;
                $this.count = data.Count;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});