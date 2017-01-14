app.factory('svcEventDetailsReport', function ($rootScope, $http, $q) {
    $this = {
        ReportByCourse: function (EventId,CourseId,CourseYearId,SectionId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/event-report/'+EventId+'/'+CourseId+'/'+CourseYearId+'/'+SectionId
            }).success(function (data, status) {
                deferred.resolve(data);
            }).error(function (data, status) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
		ReportByOrganization: function (EventId,Organization) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/event-report-organization/'+EventId+'/'+Organization
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
