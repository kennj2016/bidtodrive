{strip}

<span class="submit-actions{if $parameters.record->revision_tag == 'pending' && $smarty.session.user->is_admin == 2} pending-for-approve{/if}">
	{if $smarty.session.user->is_admin == 2}
		{if $parameters.record->revision_tag == 'pending'}
			<input class="button1 submit-approve" type="button" value="Approve" />
			<input class="hidden" type="submit" name="submit" value="Approve" />
		{else}
			<input class="hidden" type="submit" name="submit" value="" />
		{/if}
		<input class="button1 submit-publish" type="button" value="Save and Publish" />
		<input class="button1 submit-save" type="button" value="Save for Later" />
		<div class="mini-box-admin_hidden_register_seller" style="width: 300px;">
			<br/>
			<span> Manager register seller </span>
			<input type="radio" name="admin_hidden_register_seller" value="0"
			{if intval($parameters.record->admin_hidden_register_seller) === 0 || empty($parameters.record->admin_hidden_register_seller)}
				checked
			{/if}
			 /><span style="padding-left:10px;"> Hidden register </span>
			<input type="radio" name="admin_hidden_register_seller" value="1"
			{if intval($parameters.record->admin_hidden_register_seller) === 1}
				checked
			{/if}
			/><span  style="padding-left:10px;"> Show register </span>
		</div>
	{else}
		<input class="hidden" type="submit" name="submit" value="" />
		<input class="button1" type="button" value="Submit for Approval" />
		<input class="button1" type="button" value="Save for Later" />
	{/if}
</span>

{/strip}