
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


require('angular');

var ngApp = angular.module('App', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

ngApp.controller('AppCont', function($scope, $http) {

    $scope.groups = [];
    $scope.sGroup = {};
    $scope.conversations = [];

    $scope.intUserForm = function () {
        $scope.createUserForm = {
            name : '',
            users : []
        };
    };
    $scope.intUserForm();

    $http({
        method: 'GET',
        url: 'groups'
    }).then(function (response) {
        if (response.data)
            $scope.groups = response.data;
    }, function (response) {
        console.log("Error!, Group has not loaded.");
    });

    Echo.private('users.'+Laravel.user.id).listen('GroupCreated', function (data) {
        $scope.groups.push(data.group);
    });

    $scope.toggleSelection = function (userId) {
        var idx = $scope.createUserForm.users.indexOf(userId);

        // Is currently selected
        if (idx > -1) {
            $scope.createUserForm.users.splice(idx, 1);
        }

        // Is newly selected
        else {
            $scope.createUserForm.users.push(userId);
        }
    };

    $scope.createUser = function () {
        var formData = $scope.createUserForm;
        $scope.intUserForm();

        $http({
            method: 'POST',
            url: 'groups/create',
            data: formData
        }).then(function (response) {
            /*if(response.data)
                $scope.groups.push(response.data);*/
        }, function (response) {
            console.log("Error!, Group has not created")
        });
    };

    $scope.selectGroup = function ($group) {
        $scope.sGroup = $group;

        Echo.private('groups.'+$scope.sGroup.id).listen('NewMessage', function (data) {
            $scope.conversations.push(data);
        });

        $http({
            method: 'GET',
            url: 'conversations/' + $scope.sGroup.id
        }).then(function (response) {
            if (response.data)
                $scope.conversations = response.data;
        }, function (response) {
            console.log("Error!, Conversations has not loaded.");
        });
    };

    $scope.sendMessage = function () {

        var formData = {
            message: $scope.message,
            group_id: $scope.sGroup.id
        };

        $http({
            method: 'POST',
            url: 'conversations/create',
            data: formData
        }).then(function (response) {

        }, function (response) {
            console.log("Error!, Conversations has not loaded.");
        });
    };



});
