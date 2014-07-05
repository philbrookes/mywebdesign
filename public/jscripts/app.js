var app = angular.module("mywebdesign-app", ['ngRoute']).config(function($routeProvider){
    $routeProvider.when("/login", {
        templateUrl: "/templates/loginform.html",
        controller: "LoginController"
    });
    $routeProvider.when("/", {
        templateUrl: "/templates/home.html",
        controller: "HomeController",
        resolve: {
            "links": function($http){
                return $http.get("/home/links");
            }
        }
    });
    $routeProvider.when("/admins", {
        templateUrl: "/templates/listAdmins.html",
        controller: "adminController",
        resolve: {
            "admins": function($http){
                return $http.get("/admins");
            }
        }
    });
    $routeProvider.otherwise({ redirectTo: '/'});
})
.config(function($httpProvider){
    var logsOutUserOn401 = function($location, $q, FlashService){
        var success = function(response){
            return response;
        };
        var error = function(response){
            if(response.status == 401){
                $q.reject(response);
                FlashService.show(response.data.flash);
                $location.path("/login");
            } else {
                $q.reject(response);
            }
        };
        return function(promise){
            return promise.then(success, error);
        };
    }
    $httpProvider.responseInterceptors.push(logsOutUserOn401);
})
.factory("AuthService", function($http, FlashService){
    
    var loginError = function(response){
        FlashService.show(response.flash);
    }
    var loginSuccess = function(){
        FlashService.clear();
    }
    return {
        login: function(credentials){
            var login = $http.post('/login', credentials);
            login.success(loginSuccess);
            login.error(loginError);
            return login;
        },
        logout: function(){
            return $http.get('/logout');
        },
        isLoggedIn: function(){
            return $http.get('/isLoggedIn');
        }
    }
})
.factory("FlashService", function($rootScope){
    return {
        show: function(message){
            $rootScope.flash = message;
        },
        clear: function(){
            $rootScope.flash = "";
        }
    }
})
.controller("LoginController", function($scope, $location, AuthService) {
    $scope.credentials = { username: "", password: "" };
    $scope.login = function(){
        AuthService.login($scope.credentials).success(function(){
           $location.path("/"); 
        })
        .error(function(){
            
        });
    }
    $scope.logout = function(){
        AuthService.logout().success(function(){
            $location.path("/login");
        });
    }
})

.controller("HomeController", function($scope, links){
    console.log(links.data);
    $scope.links = links.data;
})

.controller("adminController", function($scope, admins){
    console.log(admins.data);
    $scope.admins = admins.data;
});

