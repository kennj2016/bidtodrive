{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/products_inventory/" class="button1">cancel</a>
			<input class="button1" type="submit" name="submit" value="Save" />
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					amount of product
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="amount of product" name="amount" value="{$parameters.amount|escape}"/>
				</div>
			</div>
		</div>
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Note<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text"  placeholder="note" name="note" id="note"></textarea>
				</div>
			</div>
		</div>
		{include file="includes/admin/admin_creators.tpl"}


		{if $parameters.history}
			<div class="section revisions-wrapper">
				<div class="section-title-box">
					<h3>history</h3>
				</div>

				<table class="records-list hide-on-mobile">
					<thead>
						<tr>
							<th width="1">
								#
							</th>
							<th width="25%">
								date
							</th>
							<th>
								Note
							</th>
						</tr>
					</thead>
					<tbody class="revisions-main">
						{foreach from=$parameters.history item=item name=history}
							<tr>
								<td>{$smarty.foreach.history.iteration}</td>
								<td>{$item->datetime_create|date_format:"%m/%d/%Y"}</td>
								<td>{$item->description|escape}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>

				<div class="show-on-mobile revisions-mobile">
				    {foreach from=$parameters.history item=item name=history}
						<table class="records-list-mobile">
							<tr>
								<th>
									#
								</th>
								<td>
									{$smarty.foreach.history.iteration}
								</td>
							</tr>
							<tr>
								<th>
									date
								</th>
								<td>
									{$item->datetime_create|date_format}
								</td>
							</tr>
							<tr>
								<th>
									Note
								</th>
								<td>
									{$item->description|escape}
								</td>
							</tr>
						</table>
						{/foreach}
				</div>
			</div>

		{/if}

	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}
