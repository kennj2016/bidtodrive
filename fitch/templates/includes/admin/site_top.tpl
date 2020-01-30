{strip}
{php} header("Content-type: text/html; charset=utf-8"); {/php}

<!DOCTYPE html>
<html lang="en">
<head>

	<title>{$web_config.company_name} Administration</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png" sizes="16x16" />

	{if $web_config.debug_mode}
		{assign var=version value=$smarty.now|date_format:"%Y%m%d%H%M%S"}
	{else}
		{assign var=version value="20131210"}
	{/if}

	<link rel="stylesheet" type="text/css" href="/css/admin/common.css?v={$version}">
	<link rel="stylesheet" type="text/css" media="(min-width: 998px)" href="/css/admin/pc.css?v={$version}" />
	<link rel="stylesheet" type="text/css" media="(min-width: 756px) and (max-width: 997px)" href="/css/admin/tablet.css?v={$version}" />
	<link rel="stylesheet" type="text/css" media="(max-width: 755px)" href="/css/admin/mobile.css?v={$version}" />

	<link href="/css/admin/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery{if !$web_config.debug_mode}.min{/if}.js"></script>
	<script src="/js/admin/jquery.mCustomScrollbar.concat.min.js"></script>
	<script type="text/javascript" src="/js/admin/TweenMax.min.js"></script>

	<script type="text/javascript" src="/js/admin/jquery.mobile.custom{if !$web_config.debug_mode}.min{/if}.js"></script>

	<link rel="stylesheet" type="text/css" href="/fitch/resources/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom{if !$web_config.debug_mode}.min{/if}.css">
	<script type="text/javascript" src="/fitch/resources/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom{if !$web_config.debug_mode}.min{/if}.js"></script>

	<script src="/fitch/resources/lightbox/js/lightbox-2.6.min.js"></script>
	<link href="/fitch/resources/lightbox/css/lightbox.css" rel="stylesheet" />
	<link href="/css/admin/select2.min.css" rel="stylesheet" />

	<script type="text/javascript" src="/js/admin/select2.min.js"></script>
  
  <script type="text/javascript" src="/js/admin/zxcvbn.min.js"></script>
	<script type="text/javascript" src="/js/admin/password_strength_meter.js"></script>  
	
	<script type="text/javascript" src="/js/admin/common.js?v={$version}"></script>

	<!--[if lt IE 9]>
		<script type="text/javascript" src="https://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
		<script type="text/javascript" src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	{if $parameters.header.include}{$parameters.header.include}{/if}

</head>
<body class="cmd-{$parameters.cmd}">

	{if $parameters.cmd == "admin_login" || $parameters.cmd == "reset_password"}
		<div class="signin-bg">
			<img src="/img/admin/custom/signin.jpg" />
		</div>
	{/if}
	<div class="site-wrap">
		{if $smarty.session.user}

			{if $parameters.header.dashboard && $parameters.header.dashboard->isActive()}
				{foreach from=$parameters.header.dashboard->getBlocks() item=block}
					{if $block->isActive() && count($block->tools) > 1}
						{assign var=active_block value=$block}
					{/if}
				{/foreach}
			{/if}

			<div class="navigation-wrap{if $active_block} with-feture-links{/if}">
				<div class="navigation">

					<a href="/admin/" class="logo">
						<img src="{if $parameters.header.site_vars.cms_logo}/site_media/{$parameters.header.site_vars.cms_logo|escape}/{else}/img/admin/custom/logo.png{/if}" alt="" />
					</a>

					<div class="controls">

						<div class="userinfo">
							<div class="name">{$smarty.session.user->name|escape}</div>
							<div class="type">
								{if $smarty.session.user->is_admin == 1}basic{else}super{/if} admin
							</div>
						</div>

						<div class="icon icon-menu">
							<a href="javascript:void(0);" title="Menu">
								<img src="/img/admin/icon-menu.png" alt="Menu" />
							</a>
						</div>

						<div class="icon">
							<a href="/admin/logout/" title="Logout">
								<img src="/img/admin/icon-logout.png" alt="Logout" />
							</a>
						</div>
					</div>

					{if $active_block}
						<div class="feture-links">
							{foreach from=$active_block->tools item=tool}
								<a href="{$tool->action->url}"{if $tool->isActive()} class="active"{/if}>
									<span>{$tool->title|escape}</span>
								</a>
							{/foreach}
						</div>
					{/if}
				</div>
			</div>

			<div class="menubox">
				<div class="menubox-list">
					<ul>
						{if $parameters.header.dashboard->hasBlocks()}
							{foreach from=$parameters.header.dashboard->getBlocks() item=block}
								{is_admin tool=$block->ids}
									<li>
										{$block->title|escape}
									</li>
									<ul class="submenu">
										{foreach from=$block->tools item=tool}
											{is_admin tool=$tool->id}
												<li>
													<a href="{$tool->action->url}">
														{$tool->title|escape}
													</a>
													<div class="tool-buttons">
														{foreach from=$tool->actions item=action}
															<a href="{$action->url}" class="tool-button-{$action->type}"></a>
														{/foreach}
														{if count($tool->actions) < 2}
															<a href="javascript:void(0);" class="tool-button-none"></a>
														{/if}
													</div>
												</li>
											{/is_admin}
										{/foreach}
									</ul>
								{/is_admin}
							{/foreach}
						{/if}
					</ul>
				</div>
			</div>

		{/if}

		<div class="content">

			{if $smarty.session.user}
				<div class="page-title">{$admin_tools.tool_title|escape}</div>
				{include file="includes/admin/breadcrumbs.tpl"}
			{/if}

			{include file="includes/admin/status.tpl"}

{/strip}