<div class="vbx-applet">
	<h2>Directory Search</h2>
	<p>Let your callers search for users by dialling a few letters from the user's first or last name. They can press pound when done, or simply wait for 5 seconds.</p>
	<h3>Search Prompt</h3>
	<p>When the caller reaches this menu they will hear this prompt:</p>
	<?= AppletUI::audioSpeechPicker('searchMenu'); ?>
	<h3>Menu Prompt</h3>
	<p>The caller can select a user from the menu, or dial 0 to try again. Before the user menu is played, play this prompt:</p>
	<?= AppletUI::audioSpeechPicker('dirMenu'); ?>
	<h3>No Matches</h3>
	<p>Select a message to play when no users are found, before the process is restarted.</p>
	<?= AppletUI::audioSpeechPicker('nomatchMessage'); ?>
	<h3>Restart Search</h3>
	<p>The caller dialed 0 to restart the search, customize this message.</p>
	<?= AppletUI::audioSpeechPicker('restartMessage'); ?>
	<h3>Invalid Selection</h3>
	<p>Customize a specific message about the invalid selection.</p>
	<?= AppletUI::audioSpeechPicker('invalidMessage'); ?>
	<h3>Error Message</h3>
	<p>Pick a message to notify the caller an error occurred before the process is restarted.</p>
	<?= AppletUI::audioSpeechPicker('errorMessage'); ?>
</div>