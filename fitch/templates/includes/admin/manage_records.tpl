{strip}
{if $parameters.view}
	{assign var=view value=$parameters.view}
{/if}
{if $view eq "list-items-main"}

	{if $parameters.manager->rows}
		{foreach name=rows from=$parameters.manager->rows item=row}
			<tr>
				{if $parameters.manager->batch_actions}
					<td class="split" width="1">
						<div class="item">
							<input type="checkbox" name="batch_ids[]" value="{$row->id}" />
						</div>
					</td>
				{/if}
				{foreach from=$parameters.manager->cols item=col}
					<td class="{if $col->width == 1} nowrap{/if}{if $col->action} pointer{/if}"{if $col->width} width="{$col->width}"{/if}{if $col->action}{$col->action()}{/if}>
						{assign var=html value=$row->html($col)}
						{if $col->truncate}<div class="truncate" title="{$html|strip_tags}">{/if}
						{$html}
						{if $col->truncate}</div>{/if}
					</td>
				{/foreach}
				{if $parameters.manager->row_actions || $parameters.manager->batch_actions}
					<td{if $parameters.manager->row_actions} class="split nowrap"{/if} width="1">
						{if $parameters.manager->row_actions}
							{foreach from=$parameters.manager->row_actions item=action}
								<div class="item">
									{$action->html($row)}
								</div>
							{/foreach}
						{else}
							&nbsp;
						{/if}
					</td>
				{/if}
			</tr>
		{/foreach}
	{/if}

{elseif $view eq "list-items-mobile"}

	{if $parameters.manager->rows}
		{foreach name=rows from=$parameters.manager->rows item=row}
			<table class="records-list-mobile">
				{foreach from=$parameters.manager->cols item=col}
					{if !is_a($col, @Position_AdminManagerCol)}
						<tr>
							<th>
								{$col->label()}
							</th>
							<td>
								{$row->html($col)}
							</td>
						</tr>
					{/if}
				{/foreach}
				{if $parameters.manager->row_actions}
					<tr>
						<th>
							&nbsp;
						</th>
						<td class="split">
							{foreach from=$parameters.manager->row_actions item=action}
								<div class="item">
									{$action->html($row)}
								</div>
							{/foreach}
						</td>
					</tr>
				{/if}
			</table>
		{/foreach}
	{/if}

{else}
{include file="includes/admin/site_top.tpl"}

<script src="/js/admin/URI.js" type="text/javascript"></script>
<script src="/js/admin/manage_records.js" type="text/javascript"></script>

<div class="section">
	{if $parameters.manager->tabs}
		{include file="includes/admin/tabs.tpl" tabs=$parameters.manager->tabs}
	{/if}
	{if $parameters.manager->common_actions}
		<div class="section-title-box">
			{*<h3>{$parameters.header.title|escape}</h3>*}
			{foreach from=$parameters.manager->common_actions item=action}
				{if $action->id === 'add'}
					{assign var=label value="Add New `$admin_tools.tool_title_singular`"}
				{else}
                    {assign var=label value=null}
				{/if}
                {$action->html($label)}
			{/foreach}
		</div>
	{/if}

	{if $parameters.manager->filters}
		<div class="section-filters-box">
			<div class="section-filters-header">
				<div class="section-filters-title">
					<div class=section-filters-title-container>
						<img src="/img/admin/filter-icon.svg" alt="Filters Icon" class="section-filters-icon"><span>Filters</span>
					</div>
				</div>
				<div class="section-filters-actions">
					<a href="#" class="filter-action clear">Clear</a>
				</div>
			</div>
			<div class="section-filters-body">
				{foreach from=$parameters.manager->filters item=filter}
					<div class="section-filter">
						<div class="section-filter-box">
							<div class="section-filter-text">
								<span class="section-filter-title">{$filter->label|escape}</span>
								<span class="section-filter-value">
									<span class="section-filter-input">
										{$filter->html()}
									</span>
								</span>
							</div>
						</div>
					</div>
				{/foreach}
			</div>
		</div>
	{/if}

	{if $parameters.manager->rows}

		<table class="records-list hide-on-mobile">
			<thead>
				<tr>
					{if $parameters.manager->batch_actions}
						<th width="1" class="split">
							<div class="item">
								<input type="checkbox" data-batch-ids=".records-list" />
							</div>
						</th>
					{/if}
					{foreach from=$parameters.manager->cols item=col}
						<th{if $col->width} width="{$col->width}"{/if}{if $col->sortable} data-sort-by="{$col->id}"{if $col->sortable} class="sortable-with-icon"{/if}{if $parameters.manager->sort == $col} data-sorted="{$parameters.manager->order}"{/if}{/if}>
							{$col->label()}{if $col->sortable}<div class="sort-icon-container"><img src="/img/admin/sort-icon.svg" alt=""></div>{/if}
						</th>
					{/foreach}
					{if $parameters.manager->row_actions || $parameters.manager->batch_actions}
						<td width="1"{if $parameters.manager->batch_actions} class="split nowrap right"{/if}>
							{if $parameters.manager->batch_actions}
								{foreach from=$parameters.manager->batch_actions item=action}
									<div class="item">
										{$action->html()}
									</div>
								{/foreach}
							{else}
								&nbsp;
							{/if}
						</td>
					{/if}
				</tr>
			</thead>
			<tbody class="sortable-containment" {if $parameters.manager->page < $parameters.manager->total_pages} data-load-more="list-items-main"{/if}>
				{include file="includes/admin/manage_records.tpl" view="list-items-main"}
			</tbody>
		</table>

		<div class="show-on-mobile"{if $parameters.manager->page < $parameters.manager->total_pages} data-load-more="list-items-mobile"{/if}>
			{include file="includes/admin/manage_records.tpl" view="list-items-mobile"}
		</div>

	{else}
		{include file="includes/admin/message.tpl" message="There are no records found."}
	{/if}
</div>

{include file="includes/admin/site_bottom.tpl"}
{/if}
{/strip}
