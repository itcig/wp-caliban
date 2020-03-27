<div class="wrap caliban-options">
	<h1>Caliban Settings</h1>

	<form method="POST" name="form_caliban_settings">
		<input type="hidden" name="form_caliban_settings_submitted" value="1">

		<form method="post" action="options.php" novalidate="novalidate">
			<table class="form-table">

				<tr>
					<th scope="row">
						<label for="property_id">Property ID</label></th>
					<td>
						<input id="property_id" name="property_id" type="text" class="regular-text" value="<?= $caliban_settings['property_id'] ?>"/>
					</td>
				</tr>

                <tr>
                    <th scope="row">
                        <label>Enable Link Tracking</label>
                    </th>
                    <td>
                        <label for="enable_link_tracking">
                            <input id="enable_link_tracking" name="enable_link_tracking" type="checkbox" class="checkbox-input" value="1" <?= $caliban_settings['enable_link_tracking'] ? 'checked' : ''; ?> />
                            Enabled
                        </label>
                        <p class="description">Append params to internal links and session IDs to cross-domain links.</p>
                    </td>
                </tr>

				<tr>
					<th scope="row">
						<label for="append_params">Append Params (CBN_APPEND_PARAMS)</label>
                    </th>
					<td>
						<input id="append_params" name="append_params" type="text" class="regular-text" value="<?= $caliban_settings['append_params'] ?>"/>
                        <p class="description">Querystring params to append to all links (comma-separated)</p>
					</td>
				</tr>

                <tr>
                    <th scope="row">
                        <label for="ignore_classes">Ignore Classes (CBN_IGNORE_CLASSES)</label>
                    </th>
                    <td>
                        <input id="ignore_classes" name="ignore_classes" type="text" class="regular-text" value="<?= $caliban_settings['ignore_classes'] ?>"/>
                        <p class="description">Classes for links and forms to ignore Caliban appending (comma-separated)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="session_timeout">Session Duration (CBN_CACHE_EXPIRATION)</label>
                    </th>
                    <td>
                        <input id="session_timeout" name="session_timeout" type="text" class="regular-text" value="<?= $caliban_settings['session_timeout'] ?>"/>
                        <p class="description">The maximum time to store a session for before expiration (in seconds)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label>Debug (CBN_DEBUG)</label>
                    </th>
                    <td>
                        <label for="debug">
                            <input id="debug" name="debug" type="checkbox" class="checkbox-input" value="1" <?= $caliban_settings['debug'] ? 'checked' : ''; ?> />
                            Enabled
                        </label>
                        <p class="description">Enable tracker debug mode (This should never run in production)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label>Debug Forms</label>
                    </th>
                    <td>
                        <label for="debug_forms">
                            <input id="debug_forms" name="debug_forms" type="checkbox" class="checkbox-input" value="1" <?= $caliban_settings['debug_forms'] ? 'checked' : ''; ?> />
                            Enabled
                        </label>
                        <p class="description">Will append all session data as an array to a field <em>cbn_debug</em></p>
                    </td>
                </tr>

			</table>

			<p class="submit">
				<input type="submit" value="Save" class="button button-primary button-large">
			</p>

		</form>
	</form>
</div>
