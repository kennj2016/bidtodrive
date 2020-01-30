{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/taxes/" class="button1">cancel</a>
			{include file="includes/admin/revisions_action.tpl"}
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Rate
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="rate" name="rate" value="{$parameters.record->rate|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Zip Code<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="zip code" name="zip_code" value="{$parameters.record->zip_code|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					City<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text"  placeholder="city" name="city" value="{$parameters.record->city|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					City Rate
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="city rate" name="city_rate" value="{$parameters.record->city_rate|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					City Reporting Code
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="city reporting code" name="city_reporting_code" value="{$parameters.record->city_reporting_code|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Post Office<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text"  placeholder="post office" name="post_office" value="{$parameters.record->post_office|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					State<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="state_id">
						<option value="">none (default)</option>
						{foreach from=$parameters.states key=value item=state}
							<option value="{$value|escape}"{if $value == $parameters.record->state_id} selected="selected"{/if}>
								{$state->name|escape}
							</option>
						{/foreach}
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					State Rate
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="state rate" name="state_rate" value="{$parameters.record->state_rate|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					State Reporting Code
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="state reporting code" name="state_reporting_code" value="{$parameters.record->state_reporting_code|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					County<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text"  placeholder="county" name="county" value="{$parameters.record->county|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					County Rate
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="county rate" name="county_rate" value="{$parameters.record->county_rate|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					County Reporting Code
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="county reporting code" name="county_reporting_code" value="{$parameters.record->county_reporting_code|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Special District Rate
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="special district rate" name="special_district_rate" value="{$parameters.record->special_district_rate|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Special District Reporting Code
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="special district reporting code" name="special_district_reporting_code" value="{$parameters.record->special_district_reporting_code|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					z2t ID
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text"  placeholder="z2t id" name="z2t_id" value="{$parameters.record->z2t_id|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Shipping Taxable
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="shipping_taxable">
						<option value="0">No</option>
						<option value="1"{if $parameters.record->shipping_taxable} selected="selected"{/if}>Yes</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Primary Record
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="primary_record">
						<option value="0">No</option>
						<option value="1"{if $parameters.record->primary_record} selected="selected"{/if}>Yes</option>
					</select>
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					active
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="status">
						<option value="0">No</option>
						<option value="1"{if $parameters.record->status} selected="selected"{/if}>Yes</option>
					</select>
				</div>
			</div>
		</div>

		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

{include file="includes/admin/site_bottom.tpl"}
{/strip}