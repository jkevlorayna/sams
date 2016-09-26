app.factory('svcOrder', function ($rootScope, $http, $q) {
    $this = {
		getByCode: function (order_code) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/orderData/'+ order_code,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		getById: function (Id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/getOrder/'+Id,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		Search: function (MemberId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/orderlist?MemberId=' + MemberId ,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		MemberOrderList: function (MemberId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/MemberOrderList?MemberId=' + MemberId ,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },OrderList: function (searchText,pageNo,pageSize,OrderList) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/orderlistAdmin?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize + '&OrderList=' + OrderList,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		orderReport: function (date_from,date_to) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/orderReport?date_from='+date_from+'&date_to='+date_to
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,Save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/saveOrder',
				data:postData,
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
    };
    return $this;
});