var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaHelper', ['$q','$rootScope',  'AlgoliaClient', function($q,$rootScope, AlgoliaClient) {

		var algoliaHelperInstance = {};
		var helper = false;
		var controllerScope;
		
		var searchCallback = function(success, content) {
				
			$rootScope.$broadcast('algoliaResultUpdated', content);
			
			$rootScope.$apply();

		};
		
		
		
		algoliaHelperInstance = {
			indexName: '',
			options: {
				hitsPerPage: 12,
				facets: '',
				numericFilters: ''
			},
			
			get: function() {
				if (!helper) {
					helper = new AlgoliaSearchHelper(AlgoliaClient.get(), this.indexName);
				}

				return helper;
			},
			search: function(value, options, scope) {
				
				controllerScope = scope;
				
				if (!value) {
					value = '';
				}

				if (options) {
					if (typeof (options.indexName) !== "undefined") {
						this.indexName = options.indexName;
					}

					if (typeof (options.facets) !== "undefined") {
						this.options.facets = options.facets;
					}

					if (typeof (options.numericFilters) !== "undefined") {
						this.options.numericFilters = options.numericFilters;
					}
				}
				
				this.get().search(value, searchCallback, this.options);
				
				//return deferred.promise;

			}
		};

		return algoliaHelperInstance;

	}]);