'use strict';
controllers.controller('homeController', ['$scope', '$http', 'promiseTracker', function($scope, $http, promiseTracker) {
  $scope.user = {};
  $scope.user.addresses = [{'id': 'address_1'}];
  $scope.user.morePhoneNumbers = [{'id': 'phonenumber_1'}];
  $scope.user.socialTypes = [{'id': 'socialtype_1'}];
  $scope.bloodGroupOptions = {
    'O-': 'O-',
    'O+': 'O+',
    'A-': 'A-',
    'A+': 'A+',
    'B-': 'B-',
    'B+': 'B+',
    'AB-': 'AB-',
    'AB+': 'AB+',
    'Dont Know': 'Dont Know',
  };
  $scope.user.bloodGroup = 'A+';
  $scope.maritalStatusOptions = {
    'Unmarried': 'Unmarried',
    'Married': 'Married',
    'Divorced': 'Divorced',
    'Widowed': 'Widowed'
  };
  $scope.user.maritalStatus = 'Unmarried';
  $scope.addressTypeOptions = {
    'Native': 'Native',
    'Current': 'Current'
  };
  $scope.user.addressType = 'Current';
  console.log($scope.user);
  // Inititate the promise tracker to track form submissions.
  $scope.progress = promiseTracker();
  $scope.addNewAddress = function(){
    var length = $scope.user.addresses.length + 1;
    $scope.user.addresses.push({'id': 'address_'+length});
  }
  $scope.messengerTypeOptions = {
    'Whatsapp': 'Whatsapp',
    'Home': 'Home',
    'Work': 'Work'
  };
  $scope.socialTypeOptions = {
    'Facebook': 'Facebook',
    'Twitter': 'Twitter',
    'Skype': 'Skype',
    'Your Website': 'Your Website',
    'Your Blog': 'Your Blog'
  };
  $scope.defaultMessengerType = 'Whatsapp';
  $scope.addNewPhoneNumber = function(){
    var length = $scope.user.morePhoneNumbers.length + 1;
    $scope.user.morePhoneNumbers.push({'id': 'phonenumber_'+length});
  }
  $scope.socialType = 'Facebook';
  $scope.addNewSocialType = function(){
    var length = $scope.user.socialTypes.length + 1;
    $scope.user.socialTypes.push({'id': 'socialtype_'+length});
  }
  // Form submit handler.
  $scope.submitForm = function(form) {
        // Trigger validation flag.
        $scope.submitted = true;

        // If form is invalid, return and let AngularJS show validation errors.
        if (form.$invalid) {
          return;
        }

        // Default values for the request.
        var config = {
          params : {
            'callback' : 'JSON_CALLBACK',
            'name' : $scope.name,
            'email' : $scope.email,
            'subjectList' : $scope.subjectList,
            'url' : $scope.url,
            'comments' : $scope.comments
          },
        };

        // Perform JSONP request.
        var $promise = $http.jsonp('response.json', config)
          .success(function(data, status, headers, config) {
            if (data.status == 'OK') {
              $scope.name = null;
              $scope.email = null;
              $scope.subjectList = null;
              $scope.url = null;
              $scope.comments = null;
              $scope.messages = 'Your form has been sent!';
              $scope.submitted = false;
            } else {
              $scope.messages = 'Oops, we received your request, but there was an error processing it.';
              $log.error(data);
            }
          })
          .error(function(data, status, headers, config) {
            $scope.progress = data;
            $scope.messages = 'There was a network error. Try again later.';
            $log.error(data);
          })
          .finally(function() {
            // Hide status messages after three seconds.
            $timeout(function() {
              $scope.messages = null;
            }, 3000);
          });

        // Track the request and show its progress to the user.
        $scope.progress.addPromise($promise);
      };
}]);