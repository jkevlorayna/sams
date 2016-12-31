app.factory('svcMember', function ($rootScope, $http, $q) {
    $this = {

        list: function (searchText,pageNo,pageSize,type,CourseId,CourseYearId,SectionId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/member?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize+'&type='+type+'&CourseId='+CourseId+'&CourseYearId='+CourseYearId+'&SectionId='+SectionId
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
                url: BasePath+'/class/member/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }, GetAttendance: function (id,Semester,SchoolYear) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/member/attendance/'+id+'?Semester='+Semester+'&SchoolYear='+SchoolYear
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
                url: BasePath+'/class/member/'+id
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
                url: BasePath+'/class/member',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },changePassword: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/member/changepassword',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
		,signUp: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/signup',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },Upload: function (postData,Id) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
				headers: {'Content-Type': undefined},
                url: BasePath+'/class/member/upload/'+Id,
                data:postData,
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