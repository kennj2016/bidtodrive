{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>
<script type="text/javascript" src="/fitch/resources/zeroclipboard-1.2.3/ZeroClipboard.js"></script>
<script type="text/javascript">
	ZeroClipboard.setDefaults({ldelim}moviePath: '/fitch/resources/zeroclipboard-1.2.3/ZeroClipboard.swf'{rdelim});
</script>

<div class="section">

	<div class="section-title-box">
		{*<h3>{$parameters.header.title|escape}</h3>*}
		<a href="javascript:void(0);" class="button1">
			Upload
			<input type="file" class="media-box-input-file" multiple="multiple" />
		</a>
		<a href="/admin/site_media/add/" class="button1">New Folder</a>
	</div>

	<div class="media-box" data-folders="{$parameters.folders|@json_encode|escape}">
		
		<div class="media-box-folders-wrap">
			<div class="media-box-folders">
				<a class="action select">
					<select></select>
				</a>
			</div>
		</div>
		
		<div class="media-box-options">
			<div class="sort">
				<a class="active asc" rel="datetime_create">
					Date
				</a>
				<a rel="size">
					Size
				</a>
				<a rel="name_orig">
					Name
				</a>
			</div>
		</div>
		
		<div class="media-box-files-wrap">
			<div class="media-box-files"></div>
		</div>
		
		<div class="media-box-size"></div>
		
	</div>

</div>

{include file="includes/admin/site_bottom.tpl"}
{/strip}