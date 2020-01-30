{strip}

{assign var=admin_creators value=$parameters.record->_admin_creators}

<div class="section">
	<div class="section-title-box">
		<h3>
			Admin Creators
		</h3>
	</div>
	<div class="form-field">
		<div class="form-field-label-wrap">
			<div class="form-field-label">
				Created By
			</div>
		</div>
		<div class="form-field-input-wrap">
			<div class="form-field-input">
				<div class="input-text">
					{if $admin_creators.created_by}
						{$admin_creators.created_by|escape}
					{else}
						<i>Unknown</i>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class="form-field">
		<div class="form-field-label-wrap">
			<div class="form-field-label">
				Date Created
			</div>
		</div>
		<div class="form-field-input-wrap">
			<div class="form-field-input">
				<div class="input-text">
					{$parameters.record->datetime_create|date_format:$web_config.admin_datetime_format}
				</div>
			</div>
		</div>
	</div>

	{if $parameters.record->datetime_update}
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Modified by
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<div class="input-text">
						{if $admin_creators.updated_by}
							{$admin_creators.updated_by|escape}
						{else}
							<i>Unknown</i>
						{/if}
					</div>
				</div>
			</div>
		</div>
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Date Modified
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<div class="input-text">
						{$parameters.record->datetime_update|date_format:$web_config.admin_datetime_format}
					</div>
				</div>
			</div>
		</div>
	{/if}

	{if $parameters.record->approved}
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Approved By
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<div class="input-text">
						{if $admin_creators.approved_by}
							{$admin_creators.approved_by|escape}
						{else}
							<i>Unknown</i>
						{/if}
					</div>
				</div>
			</div>
		</div>
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Date Approved
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<div class="input-text">
						{$parameters.record->datetime_approve|date_format:$web_config.admin_datetime_format}
					</div>
				</div>
			</div>
		</div>
	{/if}

</div>
		
{/strip}