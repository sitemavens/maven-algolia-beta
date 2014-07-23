var app = angular.module('mavenAlgolia.services');

app.factory('AlgoliaHelper', ['$q', '$rootScope', 'AlgoliaClient', 'MAConfig', function($q, $rootScope, AlgoliaClient, MAConfig) {

		var algoliaHelperInstance = {};
		var helper = false;

		var searchCallback = function(success, content) {
			algoliaHelperInstance.log('AlgoliaHelper:searchCallback');

			algoliaHelperInstance.page = content.page;
			algoliaHelperInstance.nbPages = content.nbPages;
			algoliaHelperInstance.hitsPerPage = content.hitsPerPage;
			algoliaHelperInstance.nbHits = content.nbHits;
			$rootScope.$broadcast('algoliaResultUpdated', content);
			if (!$rootScope.$$phase) {
				$rootScope.$apply();
			}
		};



		algoliaHelperInstance = {
			indexName: '',
			rangeSize: 2, // Define how many pages links should be showed before and after the current page
			page: 0,
			nbPages: 0,
			hitsPerPage: 0,
			nbHits: 0,
			numericFilters: [],
			tagFilters: [],
			options: {
				hitsPerPage: 12,
				facets: '',
				numericFilters: '',
				tagFilters: ''
			},
			log: function(logTxt) {
				if (this.debug() && angular.isDefined(console)) {
					console.log(logTxt);
				}
			},
			debug: function() {
				return MAConfig.debug;
			},
			get: function(indexName) {

				if (typeof (indexName) !== "undefined") {
					this.indexName = indexName;
				}
				else{
					
					if ( ! this.indexName ){
						throw 'Index name is required to get a helper';
					}
				}

				if (!helper) {
					helper = new AlgoliaSearchHelper(AlgoliaClient.get(), this.indexName);
				}

				return helper;
			},
			search: function(value, options) {
				this.log('AlgoliaHelper:Instance:search');
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
						this.numericFilters = options.numericFilters;
					}

					if (typeof (options.tagFilters) !== "undefined") {
						this.tagFilters = options.tagFilters;
					}

					if (typeof (options.hitsPerPage) !== "undefined") {
						this.options.hitsPerPage = options.hitsPerPage;
					}
				}
				this.options.tagFilters = this.tagFilters;

				this.options.numericFilters = this._getNumericFilters();

				this.get().search(value, searchCallback, this.options);
			},
			setIndex: function(index) {
				if (index) {
					this.get().index = index;
				} else {
					this.log('AlgoliaHelper:Instance:setIndex - Empty index was passed');
				}
			},
			sortByIndex: function(index, page) {
				this.log('AlgoliaHelper:Instance:sortByIndex');
				if (index) {
					var newPage = (page > 0) ? page : 0;
					this.setIndex(index);
					this.get().gotoPage(newPage);
				} else {
					this.log('Empty sort index was passed');
				}
			},
			/**
			 * Set the number of pages showed besides the current one
			 * @param {int} size
			 * @returns {void}
			 */
			setRangeSize: function(size) {
				if (size) {
					this.rangeSize = size;
				} else {
					this.rangeSize = 2;
				}
			},
			hidePreviousPage: function() {
				return (this.page < 1);
			},
			showPreviousDots: function() {
				return (this.page > this.rangeSize);
			},
			hideNextPage: function() {
				return (this.page + 1 >= this.nbPages || this.nbPages === 0 || this.nbPages === 1);
			},
			showNextDots: function() {
				return (this.page < this.nbPages - this.rangeSize && this.nbPages > (this.rangeSize * 2) + 1);
			},
			/**
			 * Get the array of pages numbers to show
			 * @returns {Array}
			 */
			getPaginationRange: function() {
				var ps = [];
				var start, end, current;

				start = this.page;
				current = this.page;
				if (start > this.rangeSize - 1) {
					start = this.page - this.rangeSize;
					end = current + this.rangeSize + 1;
					if (end > this.nbPages) {
						end = this.nbPages;
					}
				} else {
					start = 0;
					end = (this.rangeSize * 2) + 1;
					if (end > this.nbPages) {
						end = this.nbPages;
					}
				}

				for (var i = start; i < end; i++) {
					ps.push(i);
				}

				return ps;
			},
			/**
			 * Get the page number to display, as algolia starts in 0 we need to increase the value in 1
			 * @param {Number} page
			 * @returns {Number}
			 */
			displayPageNum: function(page) {
				// increment the page in 1 since algolia starts in 0
				return page + 1;
			},
			/**
			 * Number of results where it starts
			 * @returns {Number}
			 */
			displayingResultsFrom: function() {
				return (this.hitsPerPage < this.nbHits) ? ((this.page === 0) ? 0 : this.hitsPerPage * this.page) : this.nbHits;
			},
			/**
			 * Number of results where it ends
			 * @returns {Number}
			 */
			displayingResultsTo: function() {
				return (this.hitsPerPage < this.nbHits) ? (((this.hitsPerPage * this.page) + this.hitsPerPage) > this.nbHits ? this.nbHits : ((this.hitsPerPage * this.page) + this.hitsPerPage)) : this.nbHits;
			},
			/**
			 * Number of items in the result
			 * @returns {Number}
			 */
			totalResults: function() {
				return this.nbHits;
			},
			/**
			 * Clear numberic filters
			 * @returns {void}
			 */
			clearNumericFilters: function() {
				this.numericFilters = [];
			},
			/**
			 * Add a numeric filter to the array of filters
			 * Filters format is
			 *					array
			 *						filterObjects object {'field': fieldName, 'value': fieldValue, 'compare': compareOperator}
			 * 
			 * ex: multiple filters [{'field': 'price', 'value': [10, 100], 'compare': 'BEETWEEN'}, {'field': 'stock', 'value': 0, 'compare': '>'}]
			 * ex: single filter {'field': 'price', 'value': [10, 100], 'compare': 'BEETWEEN'}
			 * 
			 * @param {Array} filters
			 * @param {String} relation Could be 'AND' || 'OR'
			 * @returns {Boolean} Return true if the filter was added or False if it is not
			 */
			addNumericFilter: function(filters, relation) {
				// If relation was not defined use AND by default
				if (!angular.isDefined(relation)) {
					relation = 'AND';
				} else if (relation !== 'AND' && relation !== 'OR') {
					// If relation is not valid return false
					return false;
				}
				var _this = this;
				var filter = {};
				filter[relation] = [];
				// If it is a single filter convert it in an array to process it
				if (!angular.isArray(filters)) {
					filters = [filters];
				}
				angular.forEach(filters, function(fieldObj, key) {
					if (angular.isObject(fieldObj) && angular.isDefined(fieldObj.field) && angular.isDefined(fieldObj.value) && angular.isDefined(fieldObj.compare)) {
						// Generate the query for algolia
						var filterQuery = _this.makeNumericFilterQuery(fieldObj.field, fieldObj.value, fieldObj.compare);
						if (filterQuery) {
							// Insert the query in the array of queries
							filter[relation].push(filterQuery);
						}
					}
				});
				if (filter) {
					// Insert the filter to the global filters
					_this.numericFilters.push(filter);
				}
				return true;
			},
			/**
			 * Build the string query for a numeric field in Algolia
			 * @param {String} field
			 * @param {Number} value
			 * @param {string} compare
			 * @returns {String}
			 */
			makeNumericFilterQuery: function(field, value, compare) {
				if (!angular.isDefined(field) || !angular.isDefined(value)) {
					return '';
				}

				// If it is empty compare use = (equal) as default
				if (!angular.isDefined(compare)) {
					compare = '=';
				}
				// if the compare is BEETWEEN we need to ensure that the value is an array of 2 positions, if it is not, return empty query
				if (compare === 'BEETWEEN' && (!angular.isArray(value) || value.length !== 2)) {
					return '';
				}
				var filter = field;

				switch (compare) {
					case 'BEETWEEN':
						filter += ':';
						break;
					default:
						filter += compare;
						break;
				}

				if (compare === 'BEETWEEN') {
					filter += value[0] + ' to ' + value[1];
				} else {
					filter += value;
				}
				return filter;
			},
			/**
			 * Build numericFilters based on current filters
			 * @returns {Array}
			 */
			_getNumericFilters: function() {
				var _this = this;
				var numericFilters = [];
				if (angular.isArray(this.numericFilters)) {
					// Loop into the global array of filters
					angular.forEach(this.numericFilters, function(numericFilterObject, key) {
						// Loop into the filters getting the array of filter objects and the relation
						angular.forEach(numericFilterObject, function(filters, relation) {
							if (relation === 'OR') {
								// if relation value is "OR" just push the array of filters to generate an OR query in Algolia
								numericFilters.push(filters);
							} else if (relation === 'AND') {
								// if relation value is "AND" we need to insert the queries separately in the array of filters to generate an AND query in Algolia
								angular.forEach(filters, function(filter, key) {
									numericFilters.push(filter);
								});
							}
						});
					});
				}
				this.log(numericFilters);
				return numericFilters;
			}
		};

		return algoliaHelperInstance;

	}]);