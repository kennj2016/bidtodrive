{strip}
{include file="includes/admin/site_top.tpl"}

<div class="section">
	{*<div class="section-title-box">
		<h3>{$parameters.header.title|escape}</h3>
	</div>*}

	{if $parameters.records}

		<table class="records-list hide-on-mobile">
			<thead>
				<tr>
					<th>
						ID
					</th>
					<th>
						Title
					</th>
					<th>
						Value
					</th>
					<th width="1">
						&nbsp;
					</th>
				</tr>
			</thead>
			<tbody>
				{foreach name=records from=$parameters.records item=item}
					<tr>
						<td>
							{$item->id}
						</td>
						<td>
							<a href="/admin/site_vars/{$item->id}/">{$item->title|escape}</a>
						</td>
						<td>
							{$item->value|escape|truncate:100}
						</td>
						<td class="split">
							<div class="item">
								<a href="/admin/site_vars/{$item->id}/" class="list-action action-edit">Edit</a>
							</div>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
		
		<div class="show-on-mobile">
			{foreach name=records from=$parameters.records item=item}
				
				<table class="records-list-mobile">
					<tr>
						<th>
							ID
						</th>
						<td>
							{$item->id}
						</td>
					</tr>
					<tr>
						<th>
							Title
						</th>
						<td>
							<a href="/admin/site_vars/{$item->id}/">{$item->title|escape}</a>
						</td>
					</tr>
					<tr>
						<th>
							Value
						</th>
						<td>
							{if $item->type eq "date"}
								{$item->value|date_format:$web_config.admin_date_format}
							{elseif $item->type eq "datetime"}
								{$item->value|date_format:$web_config.admin_datetime_format}
							{elseif $item->type eq "time"}
								{$item->value|date_format:$web_config.admin_time_format}
							{else}
								{$item->value|escape|truncate:100}
							{/if}
						</td>
					</tr>
					<tr>
						<th>
							&nbsp;
						</th>
						<td>
							<a href="/admin/site_vars/{$item->id}/" class="list-action action-edit">Edit</a>
						</td>
					</tr>
				</table>
				
			{/foreach}
		</div>

	{else}
		{include file="includes/admin/message.tpl" message="There are no records found."}
	{/if}
</div>

{include file="includes/admin/site_bottom.tpl"}
{/strip}