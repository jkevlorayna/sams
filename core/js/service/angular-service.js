app.factory('svcSupplier', function ($rootScope, $http, $q) {
    $this = {

        search: function (search,weekOfStart,weekOfEnd) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/forecast/summary?where=' + search +  '&weekOfStart=' + weekOfStart + '&weekOfEnd=' + weekOfEnd
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
        getByName: function (Name) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/supplier/search/' + Name
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
        },
        getById: function (SupplierId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/supplier/' + SupplierId
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
        },
        getByEmail: function () {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/supplier/profile/'
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
        },saveSupplier: function (supplier) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: '/supplier/',
                data: supplier
            }).success(function (data, status) {
                console.log(supplier);
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
        ,loadSalmonellaDetails: function (chr) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/SalmonellaIndex/' + chr,
                data: chr
            }).success(function (data, status) {
                console.log(chr);
                deferred.resolve(data);
                $this.objects = data.Results;
                $this.count = data.Count;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        } , loadSalmonellaSampling: function (chr) {
                    var deferred = $q.defer();
                    $http({
                        method: 'GET',
                        url: '/SalmonellaSampling/' + chr,
                        data: chr
                    }).success(function (data, status) {
                        console.log(chr);
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
app.factory('svcEstimates', function ($rootScope, $http, $q) {
    $this = {
        GetForecastByRange: function (farmId,weekOfStart, weekOfEnd) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/Forecast/ByRange/?farmId=' + farmId + '&weekOfStart=' + weekOfStart + '&weekOfEnd=' + weekOfEnd
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
        },
        GetForecastByRangeEmployee: function (farmId,weekOfStart, weekOfEnd) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/Forecast/ByRangeEmployee/?farmId=' + farmId + '&weekOfStart=' + weekOfStart + '&weekOfEnd=' + weekOfEnd
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
        },
        GetWeekForecasts: function (week, year, FarmId) {
                var deferred = $q.defer();
                $http({
                    method: 'GET',
                    url: '/forecast/week/?week=' + week + '&year=' + year + '&FarmId=' + FarmId
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
            },
        GetForecasts: function (weekOfStart, weekOfEnd, farmId) {
                var deferred = $q.defer();
                $http({
                    method: 'GET',
                    url: '/forecast/?weekOfStart=' + weekOfStart + '&weekOfEnd=' + weekOfEnd + '&farmId=' + farmId
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
        },
            saveForecast: function (forecast) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: '/forecast/',
                data:forecast
            }).success(function (data, status) {
                console.log(forecast);
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
app.factory('svcDeliveries', function ($rootScope, $http, $q) {
    $this = {

        GetDeliveries: function (datefrom, dateto, pageno, pagesize) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/deliveries/' + datefrom + '/' + dateto + '/' + pageno + '/' + pagesize
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
        },
        SaveDelivery: function (deliveries) {
            var deferred = $q.defer();
            console.log(deliveries);
            $http({
                method: 'POST',
                url: '/deliveries/',
                data: deliveries
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
        },
        deleteDelivery: function (id) {
            var deferred = $q.defer();
            $http.delete('/deliveries/' + id).success(function (response) { deferred.resolve(response); }).error(function (err, status) {
                deferred.reject(err);
            });
            return deferred.promise;
        },
        getById: function (deleviriesId) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/deliveries/' + deleviriesId
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
app.factory('svcUsers', function ($rootScope, $http, $q) {
    $this = {
        getRoles: function () {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/user/roles/'
            }).success(function (response, status) {
                deferred.resolve(response);
            }).error(function (err, status) {
                deferred.resolve(err);
            });
            return deferred.promise;
        }
    };
    return $this;
});
app.factory('svcLanguageText', function ($rootScope, $http, $q, $location, $filter, $timeout) {
    var aLanguageText = [];
    var status = 'ready';
    var $this = {
        data: aLanguageText,
        getText: function (key) {
            var deferred = $q.defer();
            switch (status) {
                case "ready":
                    $this.loadText().then(function (s) {
                        deferred.resolve($this.filterText(key));
                    })
                    break;
                case "loading":
                    var wait = function () {
                        if (status == 'loaded') {
                            deferred.resolve($this.filterText(key));
                        } else {
                            $timeout(wait, 500);
                        }
                    }
                    $timeout(wait, 500);
                    break;
                case "loaded":
                    deferred.resolve($this.filterText(key));
                    break;
            }
            return deferred.promise;
        },
        filterText: function (key) {
            var t = $filter('filter')(aLanguageText, { TextKey: key }, true);
            if (t.length > 0) {
                return t[0];
            } else {
                return { Id: 0, TextKey: key, TextValue: '' };
            }
        },
        loadText: function () {
            status = 'loading';
            var deferred = $q.defer();
            aLanguageText = [];
            $http({
                method: 'GET',
                url: '/language/'
            }).success(function (data) {
                aLanguageText = data;
                status = 'loaded';
                deferred.resolve('texts received.');
            })
            return deferred.promise;
        },
        saveText: function (t) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: '/language/',
                data: t
            }).success(function (data) {

                if (data.error) {
                    deferred.reject(data);
                } else {
                    deferred.resolve(data);
                    if (t.Id == 0) {
                        aLanguageText.push(data);
                    }
                }
            });
            return deferred.promise;
        }
    }
    return $this;
});
app.factory('svcSession', function ($rootScope, $http, $q) {
    var loadcount = 0;
    var $this = {
        settings: { edit: false },
    };
    return $this;
});

