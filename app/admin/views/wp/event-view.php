<?php \Maven\Core\UI\HtmlComponent::jSonComponent( 'CachedEvent', $event ); ?>
<?php \Maven\Core\UI\HtmlComponent::jSonComponent( 'CachedPriceOperators', $priceOperators ); ?>
<?php \Maven\Core\UI\HtmlComponent::jSonComponent( 'CachedCombinations', $combinations ); ?>
<?php \Maven\Core\UI\HtmlComponent::jSonComponent( 'DefaultPriceOperator', $defaultPriceOperator ); ?>

<div ng-controller="EventCtrl">	
	<input type="hidden" name="mvn[event][id]" ng-value="event.id" />

	<tabset>
		<tab heading="General">
			<div class="form-horizontal" style="margin:15px 0;">
				<div class="form-group"  >
					<label for="" class="col-sm-2 control-label">Price:</label>
					<div class="col-sm-5">
						<div class="input-group">
							<span class="input-group-addon">$</span>
							<input class="form-control" type="text" ng-model="event.price" name="mvn[event][price]"  />
						</div>
					</div>
				</div>
				<div class="form-group"  >
					<label for="" class="col-sm-2 control-label">Registration Start:</label>
					<div class="col-sm-5">
						<input type="hidden" ng-value="event.registrationStartDate| date:'yyyy-MM-dd'" name="mvn[event][registrationStartDate]" />
						<input class="form-control" required type="text" ng-model="event.registrationStartDate" datepicker-popup="{{dateFormat}}"   
						       datepicker-options="dateOptions" close-text="Close" show-button-bar="false" show-weeks="false"/>
					</div>
				</div>
				<div class="form-group"  >
					<label for="" class="col-sm-2 control-label">Registration Start Time:</label>
					<div class="col-sm-5">
						<input class="form-control" required type="hidden" value="{{event.registrationStartTime| date:'HH:mm:ss'}}" name="mvn[event][registrationStartTime]"  />
						<timepicker ng-model="event.registrationStartTime" show-meridian="false"></timepicker>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Registration End:</label>		
					<div class="col-sm-5">
						<input type="hidden" ng-value="event.registrationEndDate| date:'yyyy-MM-dd'" name="mvn[event][registrationEndDate]" />
						<input class="form-control" required ng-model="event.registrationEndDate" type="text" datepicker-popup="{{dateFormat}}"   
						       datepicker-options="dateOptions" close-text="Close" show-button-bar="false" show-weeks="false"/>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Registration End Time:</label>		
					<div class="col-sm-5">
						<input class="form-control" required value="{{event.registrationEndTime| date:'HH:mm:ss'}}" type="hidden" name="mvn[event][registrationEndTime]" />
						<timepicker ng-model="event.registrationEndTime"  show-meridian="false"></timepicker>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Event Start:</label>
					<div class="col-sm-5">
						<input type="hidden" ng-value="event.eventStartDate| date:'yyyy-MM-dd'" name="mvn[event][eventStartDate]" />
						<input class="form-control" required ng-model="event.eventStartDate" type="text" datepicker-popup="{{dateFormat}}"   
						       datepicker-options="dateOptions" close-text="Close" show-button-bar="false" show-weeks="false"/>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Event Start Time:</label>
					<div class="col-sm-5">
						<input class="form-control" required value="{{event.eventStartTime| date:'HH:mm:ss'}}" type="hidden" name="mvn[event][eventStartTime]" />
						<timepicker ng-model="event.eventStartTime"  show-meridian="false"></timepicker>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Event End:</label>
					<div class="col-sm-5">
						<input type="hidden" ng-value="event.eventEndDate| date:'yyyy-MM-dd'" name="mvn[event][eventEndDate]" />

						<input class="form-control" required ng-model="event.eventEndDate" type="text" datepicker-popup="{{dateFormat}}"   
						       datepicker-options="dateOptions" close-text="Close" show-button-bar="false" show-weeks="false"/>
					</div>
				</div>

				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Event End Time:</label>
					<div class="col-sm-5">
						<input class="form-control" required value="{{event.eventEndTime| date:'HH:mm:ss'}}" type="hidden" name="mvn[event][eventEndTime]" />
						<timepicker ng-model="event.eventEndTime"  show-meridian="false"></timepicker>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-3">
						<div class="checkbox"  >
							<label >Allow group registration
								<input class="form-control" type="checkbox" value="1"  ng-model="event.allowGroupRegistration"   name="mvn[event][allowGroupRegistration]" />
							</label>
						</div>
					</div>
				</div>
				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Max group registrants:</label>
					<div class="col-sm-5">
						<input class="form-control" type="text"  ng-model="event.maxGroupRegistrants"   name="mvn[event][maxGroupRegistrants]" />
					</div>
				</div>
				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Attendee Limit:</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" ng-model="event.attendeeLimit"  name="mvn[event][attendeeLimit]" />
					</div>
				</div>
				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Seats Enabled:</label>
					<div class="col-sm-5">
						<input class="form-control" type="checkbox" value="1" ng-model="event.seatsEnabled"  name="mvn[event][seatsEnabled]" />
						<p class="help-block">Indicate if you want to manage available seats. It will be used for variations also</p>
					</div>
				</div>
				<div class="form-group"  >
					<label for="input-time" class="col-sm-2 control-label">Available Seats:</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" ng-model="event.availableSeats"  name="mvn[event][availableSeats]" />
					</div>
				</div>
				<div class="form-group">
					<label for="input-time" class="col-sm-2 control-label">Closed:</label>
					<div class="col-sm-5">
						<input class="form-control" disabled="disabled" type="checkbox" value="1" ng-model="event.closed"  name="mvn[event][closed]" />
					</div>
				</div>
			</div>
		</tab>
		<tab heading="Variations" ng-controller="VariationsCtrl">
			<div style="margin:15px 0;">
				<div class="row">
					<div class="col-md-2">
						<button type="button" ng-click="addVariation()"  class="btn btn-default" style="margin-bottom:15px;">Add Variation</button>
					</div>
					<div class="col-md-10 alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Adding or removing variations will delete all your previously created combinations.<p />
						Removing options will delete related combinations only.
					</div>
				</div>
				<div class="panel panel-default form-horizontal" ng-repeat="variation in variations">
					<div class="panel-body">
						<div class="col-md-6">
							<div class="form-group"  >
								<label for="" class="col-sm-2 control-label" >Name:</label>
								<div class="col-sm-10">
									<div class="col-sm-8">
										<input type="hidden" name="mvn[event][variations][{{$index}}][id]" ng-value="variation.id" />
										<input type="hidden" name="mvn[event][variations][{{$index}}][thingId]" ng-value="eventId" />
										<input  type="text" class="form-control" ng-model="variation.name" name="mvn[event][variations][{{$index}}][name]" placeholder="Variation"/>
									</div>
									<button type="button" ng-click="deleteVariation(variation)" class="btn btn-danger btn-xs">Delete</button>
									<button type="button" ng-click="addOption($index)" class="btn btn-primary btn-xs">Add Option</button>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" ng-repeat="option in variation.options" >
								<label for="" class="col-sm-2 control-label" >Name:</label>
								<div class="col-sm-10">
									<div class="col-sm-8">
										<input type="hidden"  name="mvn[event][variations][{{$parent.$index}}][options][{{$index}}][id]" ng-value="option.id">
										<input type="hidden"  name="mvn[event][variations][{{$parent.$index}}][options][{{$index}}][variationId]" ng-value="variation.id">
										<input  type="text" class="form-control" name="mvn[event][variations][{{$parent.$index}}][options][{{$index}}][name]" ng-model="option.name"  placeholder="Option" />
									</div>
									<button type="button" ng-click="deleteOption(variation, option)" class="btn btn-danger btn-xs">Delete</button>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="panel panel-default " >
					<div class="panel-body">
						<div class="row  form-group"  ng-repeat="variation in variations">
							<div class="col-md-6" >
								<label for="" class="col-sm-2 control-label">{{variation.name}}</label>
								<div class="col-sm-10">
									<select class="form-control" ng-model="selectedCombination[$index]" ng-options="option.name for option in variation.options"></select>
								</div>
							</div>
						</div>
						<div class='pull-right'>
							<button type="button" ng-click="addCombination(selectedCombination)" ng-disabled="addCombinationDisabled()" class="btn btn-primary">Add combination</button>
							<button type="button" ng-click="addAllCombinations()" ng-disabled="allCombinationsDisabled()" class="btn btn-primary"  >Add all</button>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-md-6" ng-repeat="variationCombination in variationsCombinations">
						<div class="panel panel-default form-horizontal" >
							<div class="panel-body">
								<h4 class="options">
									<span class="label label-default" ng-repeat="option in variationCombination.options">{{option.name}}</span>
									<button type="button" ng-click="deleteCombination(variationCombination.groupKey)" class="btn btn-danger btn-xs pull-right">Remove</button>
								</h4>
								<div class="form-horizontal">
									<input type="hidden" name="mvn[event][combinations][{{$index}}][groupKey]" ng-value="variationCombination.groupKey" />
									<input type="hidden" name="mvn[event][combinations][{{$index}}][id]" ng-value="variationCombination.id" />
									<input type="hidden" ng-repeat="option in variationCombination.options" name="mvn[event][combinations][{{$parent.$index}}][options][{{option.variationId}}][variationId]" ng-value="option.variationId"/>
									<input type="hidden" ng-repeat="option in variationCombination.options" name="mvn[event][combinations][{{$parent.$index}}][options][{{option.variationId}}][id]" ng-value="option.id"/>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Operator</label>
										<div class="col-sm-9">
											<select class="form-control" name="mvn[event][combinations][{{$index}}][priceOperator]" ng-model="variationCombination.priceOperator" ng-options="key as  value for (key, value) in priceOperators"></select>
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Price</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input class="form-control" name="mvn[event][combinations][{{$index}}][price]"  type="text" ng-model="variationCombination.price" />
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Seats</label>
										<div class="col-sm-9">
											<input class="form-control" name="mvn[event][combinations][{{$index}}][quantity]"  type="text" ng-model="variationCombination.quantity" />
										</div>
									</div>
								</div><!-- form horizontal -->
							</div>
						</div>
					</div>						
				</div>
			</div>
		</tab>
	</tabset>


	<div class="alert alert-danger" ng-show="post.$invalid">
		<span ng-show="post.$error.required">Required elements</span>
		<span ng-show="post.$error.invalid">Invalid elements</span>
	</div>


</div>
