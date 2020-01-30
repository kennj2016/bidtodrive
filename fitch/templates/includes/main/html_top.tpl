{strip}
{php} header("Content-type: text/html; charset=utf-8"); {/php}
<!DOCTYPE html>
<html lang="en" class="{if $parameters.cmd == "browser_fallback"}browserfall {/if} {if !isset($smarty.session.user)}non-logged-user{/if}" style="opacity: 1;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="format-detection" content="telephone=no" />
    {if $parameters.cmd == "auctions"}
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    {else}
        <meta name="viewport" content="width=device-width, initial-scale=1">
    {/if}
    <title>
        {if $parameters.cmd == "browser_fallback"}
            Bid to Drive
        {elseif $parameters.cmd == "auctions_edit" && $parameters.action == "edit"}
            Edit Auction: {$parameters.record->year} {$parameters.record->make} {$parameters.record->model} | Bid to Drive
        {elseif $parameters.cmd == "auctions_edit" && $parameters.action == "create"}
            Create Auction | Bid to Drive
        {elseif $parameters.cmd == "auctions_edit" && $parameters.action == "relist"}
            Relist Auction | Bid to Drive
        {elseif $parameters.cmd == "login"}
            Login | Bid to Drive
        {elseif $parameters.cmd == "register"}
            Create Account | Bid to Drive
        {elseif $parameters.cmd == "news"}
            The latest from the Bid to Drive newsroom | Bid to Drive
        {else}
            {$page->getMetadata('title')|escape} | Bid to Drive
        {/if}</title>
    <meta content="{$page->getMetadata('keywords')|escape}" name="keywords">
    <meta content="{$page->getMetadata('description')|escape}" name="description">

    {if $parameters.cmd == "browser_fallback" || $page->getMetadata('title') == "Page Not Found"}
        <meta name="robots" content="noindex, nofollow">
    {/if}

    <!--[if lte IE 9]>
        <script>
            window.location.replace("/browser-fallback/");
        </script>
    <![endif]-->

    {if $web_config.debug_mode}
        {assign var=version value=$smarty.now|date_format:"%Y%m%d%H%M%S"}
    {else}
        {assign var=version value=$smarty.now|date_format:"%Y%m%d%H%M%S"}
    {/if}

    {assign var=pageTitle value=$page->getMetadata('title')}

    <meta property="og:url" content="{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{if isset($pageTitle) && $pageTitle != "" && $pageTitle != "CompanyName"}{$pageTitle} | Bid to Drive{else}Bid to Drive | Easing the transaction between buyers and sellers.{/if}" />
    <meta property="og:description" content="{$page->getMetadata('description')|escape}" />
    <meta property="og:image" content="https://{$smarty.server.SERVER_NAME}/images/og_image.png">

    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png" sizes="16x16" />

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/main/all.css?v={$version}" />
    <link rel="stylesheet" type="text/css" href="/css/main/custom.css?v={$version}" />
    <link rel="stylesheet" type="text/css" href="/css/main/slick-lightbox.css" />
    <link rel="stylesheet" href="/fitch/resources/fancybox/source/jquery.fancybox.css?v=2.1.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="/fitch/resources/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="/fitch/resources/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/fitch/resources/Textile-Editor-Textarea/dist/css/textileToolbar.css"/>
     <link rel="stylesheet" type="text/css" href="/css/main/custom.css" />
     <!-- <script src="../../../kit.fontawesome.com/5381299f20.js"></script> -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {foreach from=$page->getEmbedCode('head') item=code}{$code}{/foreach}
    {user_type assign="user_type"}
</head>
<body class="cmd-{$parameters.cmd}
    {if $parameters.auction_info->auction_status == "Completed" && ($parameters.user->user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id || $parameters.user->user_type == "Buyer" && $parameters.auction_info->winning_user_id != $parameters.user->id || !isset($smarty.session.user))} not-winning-buyer
    {else}
        {if $parameters.cmd == "auctions" || $parameters.cmd == "account_buyer"} full-height desktop{/if}
        {if $parameters.cmd == "seller_profile" } t2 full-height{/if}
        {if $parameters.cmd == "auctions_details" && $user_type != "Seller" && isset($smarty.session.user) && $parameters.auction_info->auction_status != "Canceled" && $parameters.auction_info->auction_status != "Expired"} t2 full-height{/if}
        {if ($parameters.cmd != "auctions_details" || $user_type == "Seller") && isset($smarty.session.user) && $parameters.cmd != "auctions" && $parameters.cmd != "account"} t1 full-height{/if}
        {if $parameters.cmd == "account_security_access"} t1 full-height{/if}
        {if $parameters.cmd == "account_buyer_billing_details"} t1 full-height{/if}
        {if $parameters.cmd == "account_seller_notification_settings"} t2 full-height{/if}
        {if $parameters.cmd == "login" || $parameters.cmd == "register"} login-page{/if}
        {if $parameters.cmd == "contact"} contact-page{/if} {$user_type}
    {/if}">
    {foreach from=$page->getEmbedCode('body:before') item=code}{$code}{/foreach}

{/strip}
