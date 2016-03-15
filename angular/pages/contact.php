<h1 class="text-center">Contact Us</h1>
<form id="contactForm" name="contactForm" ng-submit="submit(contactData, contactForm.$valid);" novalidate>

	<div class="form-group" ng-class=" { 'has-error':contactForm.contactName.$touched && contactForm.contactName.$invalid } ">
		<label for="contactName">Your Name</label>
		<input type="text" class="form-control" id="contactName" name="contactName" placeholder="Your Name" ng-model="contactData.contactName" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.contactName.$error" ng-if="contactForm.contactName.$touched" ng-hide="contactForm.contactName.$valid">
			<p ng-message="minlength">Name is too short</p>
			<p ng-message="maxlength">Name is too long</p>
			<p ng-message="required">Name is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':contactForm.contactEmail.$touched && contactForm.contactEmail.$invalid } ">
		<label for="contactEmail">Your Email</label>
		<input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Your Email" ng-model="contactData.contactEmail" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.contactEmail.$error" ng-if="contactForm.contactEmail.$touched" ng-hide="contactForm.contactEmail.$valid">
			<p ng-message="minlength">Email is too short</p>
			<p ng-message="maxlength">Email is too long</p>
			<p ng-message="required">Email is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':contactForm.contactMessage.$touched && contactForm.contactMessage.$invalid } ">
		<label for="contactMessage">Your Message</label>
		<textarea class="form-control" name="contactMessage" id="contactMessage" placeholder="Message" rows="3" ng-model="contactData.message" ng-minlength="10" ng-maxlength="500" ng-required="true"></textarea>
		<div class="alert alert-danger" role="alert" ng-messages="contactForm.contactMessage.$error" ng-if="contactForm.contactMessage.$touched" ng-hide="contactForm.contactMessage.$valid">
			<p ng-message="minlength">Message is too short</p>
			<p ng-message="maxlength">Message is too long</p>
			<p ng-message="required">Message is required</p>
		</div>
	</div>



	<button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
</form>
<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>