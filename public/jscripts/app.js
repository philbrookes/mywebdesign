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
    $routeProvider.when("/admin/edit/:id", {
        templateUrl: "/templates/editAdmin.html",
        controller: "editAdminController",
        resolve: {
            "admin": function($route, $http){
                return $http.get("/admin/" + $route.current.params.id);
            }
        }
    });
    $routeProvider.when("/admin/create", {
        templateUrl: "/templates/editAdmin.html",
        controller: "createAdminController"
    });
    
    $routeProvider.when("/customer/:customer_id/item/edit/:id", {
        templateUrl: "/templates/editItem.html",
        controller: "editItemController",
        resolve: {
            "item": function($route, $http){
                return $http.get("/item/" + $route.current.params.id);
            },
            "products": function($http){
                return $http.get("/products");
            }
        }
    });
    $routeProvider.when("/customer/:customer_id/item/create", {
        templateUrl: "/templates/editItem.html",
        controller: "createItemController",
        resolve: {
            "customer": function($http, $route){
                return $http.get("/customer/" + $route.current.params.customer_id)
            },
            "products": function($http){
                return $http.get("/products");
            }
        }
    });
    $routeProvider.when("/customers", {
        templateUrl: "/templates/listCustomers.html",
        controller: "customerController",
        resolve: {
            "customers": function($http){
                return $http.get("/customers");
            }
        }
    });
    $routeProvider.when("/customer/create", {
        templateUrl: "/templates/editCustomer.html",
        controller: "createCustomerController"
    });
    $routeProvider.when("/customer/:id", {
        templateUrl: "/templates/viewCustomer.html",
        controller: "viewCustomerController",
        resolve: {
            "customer": function($route, $http){
                return $http.get("/customer/" + $route.current.params.id);
            }
        }
    });
    $routeProvider.when("/customer/edit/:id", {
        templateUrl: "/templates/editCustomer.html",
        controller: "editCustomerController",
        resolve: {
            "customer": function($route, $http){
                return $http.get("/customer/" + $route.current.params.id);
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
            if(response.status === 401){
                $q.reject(response);
                FlashService.show(response.data.flash);
                $location.path("/login");
            } else {
                FlashService.show(response.data.flash);
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
    $scope.links = links.data;
})
.controller("adminController", function($scope, $http, $route, admins){
    $scope.admins = admins.data;
    $scope.delete = function(admin){
        $http.get("/admin/delete/" + admin.id).success(function(){
            $route.reload();
        });
    };
})
.controller("editAdminController", function($scope, $http, $location, admin, FlashService){
    $scope.admin = admin.data;
    $scope.apply = function(){
        $http.post("/admin/" + $scope.admin.id, $scope.admin)
            .success(function(data){
                FlashService.clear();
                $location.path("/admins");
            })
            .error(function(data){
                FlashService.show(data.flash);
            })
    }
})
.controller("createAdminController", function($scope, $http, $location, FlashService){
    $scope.admin = {};
    $scope.apply = function(){
        $http.post("/admin", $scope.admin)
            .success(function(data){
                FlashService.clear();
                $location.path("/admins");
            })
            .error(function(data){
                FlashService.show(data.flash);
            })
    }
})
.controller("customerController", function($scope, $http, $route, customers){
    $scope.customers = customers.data;
    $scope.delete = function(customer){
        $http.get("/customer/delete/" + customer.id).success(function(){
            $route.reload();
        });
    };
})
.controller("createCustomerController", function($scope, $http, $location, FlashService){
    $scope.customer = {};
    $scope.apply = function(){
        $http.post("/customer", $scope.customer)
            .success(function(data){
                console.log(data);
                FlashService.clear();
                $location.path("/customers");
            })
            .error(function(data){
                console.log(data);
                FlashService.show(data.flash);
            })
    }
})
.controller("editCustomerController", function($scope, $http, $location, customer, FlashService){
    $scope.customer = customer.data;
    $scope.apply = function(){
        $http.post("/customer/" + $scope.customer.id, $scope.customer)
            .success(function(data){
                FlashService.clear();
                $location.path("/customers");
            })
            .error(function(data){
                FlashService.show(data.flash);
            })
    }
})
.controller("viewCustomerController", function($scope, customer){
    $scope.customer = customer.data;
})
.controller("editItemController", function($scope, $http, $filter, $location, FlashService, item, products){
    $scope.item = item.data;    
    //date fields are a pain then, this hacks it up to match what chrome wants
    $scope.item.next_bill_date =  $filter("date")(item.data.next_bill_date, 'yyyy-MM-dd').split(" ")[0];
    $scope.products = products.data;
    $scope.apply = function(){
        $http.post("/customer/" + $scope.item.customer_id + "/item/edit/" + $scope.item.id, $scope.item)
            .success(function(data){
                console.log(data);
                FlashService.clear();
                $location.path("/customer/" + $scope.item.customer_id);
            })
            .error(function(data){
                FlashService.show(data.flash);
            })
    }
})
.controller("createItemController", function($scope, $http, $location, FlashService, products, customer){
    $scope.item = {};
    $scope.products = products.data;
    $scope.customer = customer.data;
    $scope.apply = function(){
        $scope.item.customer_id = $scope.customer.id;
        $http.post("/item", $scope.item)
            .success(function(data){
                FlashService.clear();
                $location.path("/customer/" + $scope.customer.id );
            })
            .error(function(data){
                console.log(data);
                FlashService.show(data.flash);
            })
    }
});
