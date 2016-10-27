app.factory('svcEventDetails', function ($rootScope, $http, $q) {
    $this = {
        List: function (searchText,pageNo,pageSize,EventId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/eventDetail/list?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&EventId='+EventId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		GetById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/event/details'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		Delete: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/event/details/'+id
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
                url: BasePath+'/class/event/details',
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