var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaHelper', ['$q', 'AlgoliaClient', function($q, AlgoliaClient) {

		var algoliaHelperInstance = {};
		var deferred = $q.defer();
		var helper = false;

		var searchCallback = function(success, content) {
			if (success) {
				deferred.resolve(content);
			} else {
				deferred.reject('Something went wrong!!!');
			}
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
			search: function(value, options) {

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

				return deferred.promise;

			}
		};

		return algoliaHelperInstance;

	}]);