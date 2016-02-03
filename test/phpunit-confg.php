<phpunit>
	<testsuites>
		<testsuite name="Jpegery">
			<file>CommentTest.php</file>
			<file>FollowerTest.php</file>
			<file>ImageTest.php</file>
		</testsuite>
	</testsuites>
	<filter>
		<whitelist processUncoveredFilesFromWhitelist="true">
			<directory suffix=".php">../php/classes</directory>
		</whitelist>
	</filter>
</phpunit>