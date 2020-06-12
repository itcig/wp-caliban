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
                        <label for="ignore_params">Ignore Params (CBN_IGNORE_PARAMS)</label>
                    </th>
                    <td>
                        <input id="ignore_params" name="ignore_params" type="text" class="regular-text" value="<?= $caliban_settings['ignore_params'] ?>"/>
                        <p class="description">Params to ignore from adding to session or adding to form append (comma-separated)</p>
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
                        <label for="first_attribution_params">First Attribution Params (CBN_FIRST_ATTRIBUTION_PARAMS)</label>
                    </th>
                    <td>
                        <input id="first_attribution_params" name="first_attribution_params" type="text" class="regular-text" value="<?= $caliban_settings['first_attribution_params'] ?>"/>
                        <p class="description">Params that should only be added to session on a landing page but do not necessarily symbolize the start of a campaign (comma-separated)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="campaign_start_params">Campaign Start Params (CBN_CAMPAIGN_START_PARAMS)</label>
                    </th>
                    <td>
                        <input id="campaign_start_params" name="campaign_start_params" type="text" class="regular-text" value="<?= $caliban_settings['campaign_start_params'] ?>"/>
                        <p class="description">Params that when present indicate the start of a new session (comma-separated). Uses `utm_campaign`, `gaclid` and `msclkid` by default.</p>
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
                        <label for="redis_servers">Redis Servers (CBN_REDIS_SERVERS)</label>
                    </th>
                    <td>
                        <input id="redis_servers" name="redis_servers" type="text" class="regular-text" value="<?= $caliban_settings['redis_servers'] ?>"/>
                        <p class="description">Redis server(s) to connect to in format <code>tcp://10.50.50.180:7001</code>. For a cluster, separate multiple instance with comma.</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="redis_options">Redis Options (CBN_REDIS_OPTIONS)</label>
                    </th>
                    <td>
                        <textarea id="redis_options" name="redis_options" class="regular-text"><?= $caliban_settings['redis_options'] ?></textarea>
                        <p class="description">JSON-encoded string for Predis client parameters</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="form_input_namespace">Form Input Namespace (CBN_FORM_INPUT_NAMESPACE)</label>
                    </th>
                    <td>
                        <input id="form_input_namespace" name="form_input_namespace" type="text" class="regular-text" value="<?= $caliban_settings['form_input_namespace'] ?>"/>
                        <p class="description">Instead of appending all params as hidden inputs of the same name to forms, add all session data params as keys of an array by this namespace.</p>
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

			</table>

			<p class="submit">
				<input type="submit" value="Save" class="button button-primary button-large">
			</p>

		</form>
	</form>
</div>
