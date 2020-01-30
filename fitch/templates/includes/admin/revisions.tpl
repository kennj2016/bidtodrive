{strip}

{if $id}
	
	<script type="text/javascript" src="/js/admin/URI.js"></script>
	<script type="text/javascript" src="/js/admin/revisions.js"></script>
	
	<div class="form-field-group section revisions-wrapper"{if $delay} data-delay="{$delay}"{/if}>
		<div class="section-title-box form-field-group-label">
			versions
		</div>
		<div class="form-field-group-content">
			<table class="records-list hide-on-mobile">
				<thead>
					<tr>
						<th width="1">
							#
						</th>
						<th width="20%">
							date modified
						</th>
						<th>
							modified by
						</th>
						<th width="1">
							&nbsp;
						</th>
					</tr>
				</thead>
				<tbody class="revisions-main">
					<script type="text/html" id="revision-main">
						<tr>
							<td>
								<%= id %>
							</td>
							<td>
								<%= date %>
							</td>
							<td>
								<%= name %>
							</td>
							<td class="split">
								<div class="item">
									<a href="<%= href %>" class="list-action action-status-<%= status %>"></a>
								</div>
							</td>
						</tr>
					</script>
				</tbody>
			</table>

			<div class="show-on-mobile revisions-mobile">
				<script type="text/html" id="revision-mobile">
					<table class="records-list-mobile">
						<tr>
							<th>
								#
							</th>
							<td>
								<%= id %>
							</td>
						</tr>
						<tr>
							<th>
								date modifed
							</th>
							<td>
								<%= date %>
							</td>
						</tr>
						<tr>
							<th>
								modified by
							</th>
							<td>
								<%= name %>
							</td>
						</tr>
						<tr>
							<th>
								&nbsp;
							</th>
							<td class="border-left">
								<div class="item">
									<a href="<%= href %>" class="list-action action-status-<%= status %>"></a>
								</div>
							</td>
						</tr>
					</table>
				</script>
			</div>
		</div>
	</div>
	
{/if}

{/strip}