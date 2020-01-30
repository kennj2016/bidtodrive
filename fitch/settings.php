<?php

$WEB_APPLICATION_CONFIG = array();

$WEB_APPLICATION_CONFIG["debug_mode"] = FJF_SERVER != "live";

$WEB_APPLICATION_CONFIG["app_data_path"] = $_SERVER['DOCUMENT_ROOT'] . "/data";
$WEB_APPLICATION_CONFIG["smarty_compile_path"] = $WEB_APPLICATION_CONFIG["app_data_path"] . "/smarty_template";
$WEB_APPLICATION_CONFIG["log_file"] = $WEB_APPLICATION_CONFIG["app_data_path"] . "/log.out";

$WEB_APPLICATION_CONFIG["app_web_path"] = FJF_ROOT;
$WEB_APPLICATION_CONFIG["lib_path"] = $WEB_APPLICATION_CONFIG["app_web_path"] . "/lib";
$WEB_APPLICATION_CONFIG["smarty_path"] = $WEB_APPLICATION_CONFIG["lib_path"] . "/smarty";
$WEB_APPLICATION_CONFIG["templates_path"] = $WEB_APPLICATION_CONFIG["app_web_path"] . "/templates";
$WEB_APPLICATION_CONFIG["commands_path"] = $WEB_APPLICATION_CONFIG["app_web_path"] . "/commands";
$WEB_APPLICATION_CONFIG["includes_path"] = $WEB_APPLICATION_CONFIG["commands_path"] . "/includes";
$WEB_APPLICATION_CONFIG["models_path"] = $WEB_APPLICATION_CONFIG["app_web_path"] . "/models";
$WEB_APPLICATION_CONFIG["resources_path"] = $WEB_APPLICATION_CONFIG["app_web_path"] . "/resources";

$WEB_APPLICATION_CONFIG["company_name"] = "Bid to Drive";
$WEB_APPLICATION_CONFIG["from"] = array(
    "name" => $WEB_APPLICATION_CONFIG["company_name"],
    "address" => "info@" . $_SERVER["SERVER_NAME"]
);

$WEB_APPLICATION_CONFIG["google_map_api_key"] = "AIzaSyBN4FZJunTw-yazUe-H7n5A7wz-EHPeo38";

if (FJF_SERVER == 'live') {
    $WEB_APPLICATION_CONFIG["sendgrid"] = array(
        "server" => "smtp.sendgrid.net",
        "username" => "BIDTODRIVE",
        "password" => "NPG1234!!"
    );
    $WEB_APPLICATION_CONFIG["sendgrid-api-key"] = "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";
} else {
    $WEB_APPLICATION_CONFIG["sendgrid"] = array(
        "server" => "smtp.sendgrid.net",
        "username" => "luunguyenthanh91",
        "password" => "Luu10091991"
    );
}
//ACbb2a4ef25c804f4d62d2fb30875080ea
//957d4a44c3465acc9c9cb29419bf8dfa
if (FJF_SERVER == 'live') {
    $WEB_APPLICATION_CONFIG["twilio"] = array(
        "sid" => "ACbb2a4ef25c804f4d62d2fb30875080ea",
        "token" => "e703e171fd6e95f59ce8649dfda7dd55"
    );
} else {
    $WEB_APPLICATION_CONFIG["twilio"] = array(
        "sid" => "AC47bf73d317b35857af3312a4e8b6bf63",
        "token" => "6ec366430c9d610c758fc78021c643d4"
    );
}
//ACbb2a4ef25c804f4d62d2fb30875080ea
//957d4a44c3465acc9c9cb29419bf8dfa

$WEB_APPLICATION_CONFIG["transactions_statuses"] = array(
    0 => 'Processing',
    1 => 'Inactive',
    2 => 'RMA Requested',
    3 => 'Returned',
    4 => 'Partially Returned',
    5 => 'Cancelled'
);

$WEB_APPLICATION_CONFIG["auction_title_statuses"] = array(
    'Clean' => 'Clean',
    'Salvage' => 'Salvage',
    'Reconstructed' => 'Reconstructed',
    'Lemon Law' => 'Lemon Law',
    'Flood' => 'Flood',
    'Junk' => 'Junk',
    'Bill of Sale' => 'Bill of Sale'
);

$WEB_APPLICATION_CONFIG["auction_exterior_colors"] = array(
    '#000000' => 'Black',
    '#0000ff' => 'Blue',
    '#a52a2a' => 'Brown',
    '#800020' => 'Burgundy',
    '#ffd700' => 'Gold',
    '#808080' => 'Gray',
    '#008000' => 'Green',
    '#ffa500' => 'Orange',
    '#800080' => 'Purple',
    '#ff0000' => 'Red',
    '#c0c0c0' => 'Silver',
    '#d2b48c' => 'Tan',
    '#ffffff' => 'White',
    '#ffff00' => 'Yellow',
    '#fffefe' => 'Other'
);

$WEB_APPLICATION_CONFIG["auction_interior_colors"] = array(
    '#000000' => 'Black',
    '#0000ff' => 'Blue',
    '#a52a2a' => 'Brown',
    '#808080' => 'Gray',
    '#ff0000' => 'Red',
    '#d2b48c' => 'Tan',
    '#ffffff' => 'White',
    '#ffffff' => 'Other'
);

$WEB_APPLICATION_CONFIG["payment_methods"] = array(
    "Check" => "Check",
    "Cash" => "Cash",
    "Bank Check" => "Bank Check",
    "Money Order" => "Money Order",
    "Wire Transfer" => "Wire Transfer"
);

$WEB_APPLICATION_CONFIG["notification_channels"] = array(
    "sms" => "SMS",
    "email" => "Email",
    "both" => "Both",
    "none" => "None"
);

$WEB_APPLICATION_CONFIG["drive_types"] = array(
    "FWD" => "FWD",
    "RWD" => "RWD",
    "AWD" => "AWD",
    "4WD" => "4WD"
);

$WEB_APPLICATION_CONFIG["fuel_types"] = array(
    "Gasoline" => "Gasoline",
    "Diesel" => "Diesel",
    "Hybrid" => "Hybrid",
    "Electric" => "Electric"
);

$WEB_APPLICATION_CONFIG["admin_date_format"] = "%b %e, %Y";
$WEB_APPLICATION_CONFIG["admin_time_format"] = "%I:%M:%S %p";
$WEB_APPLICATION_CONFIG["admin_datetime_format"] = $WEB_APPLICATION_CONFIG["admin_date_format"] . " " . $WEB_APPLICATION_CONFIG["admin_time_format"];

$WEB_APPLICATION_CONFIG["default_cmd"] = "homepage";

$WEB_APPLICATION_CONFIG["homepage"] = array("class" => "Homepage");
$WEB_APPLICATION_CONFIG["car_query_api"] = array("class" => "CarQueryApi");
$WEB_APPLICATION_CONFIG["contact"] = array("class" => "Contact");
$WEB_APPLICATION_CONFIG["about"] = array("class" => "About");
$WEB_APPLICATION_CONFIG["page"] = array("class" => "Page");
$WEB_APPLICATION_CONFIG["news"] = array("class" => "News");
$WEB_APPLICATION_CONFIG["news_details"] = array("class" => "NewsDetails");
$WEB_APPLICATION_CONFIG["seller_profile"] = array("class" => "SellerProfile");

$WEB_APPLICATION_CONFIG["login"] = array("class" => "Login");
$WEB_APPLICATION_CONFIG["register"] = array("class" => "Register");
$WEB_APPLICATION_CONFIG["forgot_password"] = array("class" => "ForgotPassword");
$WEB_APPLICATION_CONFIG["reset_password"] = array("class" => "ResetPassword");
$WEB_APPLICATION_CONFIG["logout"] = array("class" => "Logout");

$WEB_APPLICATION_CONFIG["account"] = array("class" => "Account");
$WEB_APPLICATION_CONFIG["switch_account"] = array("class" => "SwitchAccount");
$WEB_APPLICATION_CONFIG["switch_account_seller"] = array("class" => "SwitchAccountSeller");
$WEB_APPLICATION_CONFIG["get_uship_html"] = array("class" => "GetUshipHtml");
$WEB_APPLICATION_CONFIG["account_buyer"] = array("class" => "AccountBuyer");
$WEB_APPLICATION_CONFIG["account_security_access"] = array("class" => "AccountSecurityAccess");
$WEB_APPLICATION_CONFIG["account_security_access"] = array("class" => "AccountSecurityAccess");
$WEB_APPLICATION_CONFIG["account_buyer_billing_details"] = array("class" => "AccountBuyerBillingDetails");
$WEB_APPLICATION_CONFIG["account_buyer_notification_settings"] = array("class" => "AccountBuyerNotificationSettings");
$WEB_APPLICATION_CONFIG["account_seller_notification_settings"] = array("class" => "AccountSellerNotificationSettings");

$WEB_APPLICATION_CONFIG["auctions"] = array("class" => "Auctions");
$WEB_APPLICATION_CONFIG["auctions_details"] = array("class" => "AuctionsDetails");
$WEB_APPLICATION_CONFIG["auctions_details_bill"] = array("class" => "AuctionsDetailsBill");
$WEB_APPLICATION_CONFIG["auctions_edit"] = array("class" => "AuctionsEdit");
$WEB_APPLICATION_CONFIG["accept_highest_bid"] = array("class" => "AcceptHighestBid");
$WEB_APPLICATION_CONFIG["browser_fallback"] = array("class" => "BrowserFallback");

$WEB_APPLICATION_CONFIG["ajax_account_favorites"] = array("class" => "AjaxAccountFavorites");
$WEB_APPLICATION_CONFIG["ajax_account_content_blocks"] = array("class" => "AjaxAccountContentBlocks");
$WEB_APPLICATION_CONFIG["ajax_account_seller_favorites"] = array("class" => "AjaxAccountSellerFavorites");
$WEB_APPLICATION_CONFIG["ajax_account_notifications"] = array("class" => "AjaxAccountNotifications");
$WEB_APPLICATION_CONFIG["ajax_auctions_cancel_auction"] = array("class" => "AjaxAuctionsCancelAuction");
$WEB_APPLICATION_CONFIG["ajax_auctions_place_bid"] = array("class" => "AjaxAuctionsPlaceBid");
$WEB_APPLICATION_CONFIG["ajax_auctions_buy_now"] = array("class" => "AjaxAuctionsBuyNow");
$WEB_APPLICATION_CONFIG["ajax_auctions_accept"] = array("class" => "AjaxAuctionsAccept");
$WEB_APPLICATION_CONFIG["ajax_users_switcher"] = array("class" => "AjaxUsersSwitcher");
// update July 23 , 2019
$WEB_APPLICATION_CONFIG["ajax_notification_manual"] = array("class" => "AjaxNotificationManual");
// end update July 23 , 2019
$WEB_APPLICATION_CONFIG["ajax_contact"] = array("class" => "AjaxContact");
$WEB_APPLICATION_CONFIG["site_media"] = array("class" => "SiteMedia");

$WEB_APPLICATION_CONFIG["view_license"] = array("class" => "ViewLicense");

$WEB_APPLICATION_CONFIG["cron_auctions"] = array("class" => "CronAuctions");
$WEB_APPLICATION_CONFIG["cron_expiring_auctions"] = array("class" => "CronExpiringAuctions");
$WEB_APPLICATION_CONFIG["cron_expiring_licenses"] = array("class" => "CronExpiringLicenses");
$WEB_APPLICATION_CONFIG["cron_expiring_cards"] = array("class" => "CronExpiringCards");
$WEB_APPLICATION_CONFIG["cron_expired_cards"] = array("class" => "CronExpiredCards");

$WEB_APPLICATION_CONFIG["script_stripe_webhooks"] = array("class"=>"ScriptStripeWebhooks");

//ADMIN PART
$WEB_APPLICATION_CONFIG["admin"] = array("class" => "Admin");
$WEB_APPLICATION_CONFIG["admin_login"] = array("class" => "AdminLogin");
$WEB_APPLICATION_CONFIG["admin_logout"] = array("class" => "AdminLogout");
$WEB_APPLICATION_CONFIG["admin_workflow"] = array("class" => "AdminWorkflow", "tool_id" => 999);
$WEB_APPLICATION_CONFIG["admin_users"] = array("class" => "AdminUsers", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_users_edit"] = array("class" => "AdminUsersEdit", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_subscribers"] = array("class" => "AdminSubscribers", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_login_settings"] = array("class" => "AdminLoginSettings", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_login_settings_autosave"] = array("class" => "AdminLoginSettingsAutosave", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_registration_settings"] = array("class" => "AdminRegistrationSettings", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_registration_settings_autosave"] = array("class" => "AdminRegistrationSettingsAutosave", "tool_id" => 1);
$WEB_APPLICATION_CONFIG["admin_users_permissions"] = array("class" => "AdminUsersPermissions", "tool_id" => 999);
$WEB_APPLICATION_CONFIG["admin_site_vars"] = array("class" => "AdminSiteVars", "tool_id" => 2);
$WEB_APPLICATION_CONFIG["admin_site_vars_edit"] = array("class" => "AdminSiteVarsEdit", "tool_id" => 2);
$WEB_APPLICATION_CONFIG["admin_site_media"] = array("class" => "AdminSiteMedia", "tool_id" => 3);
$WEB_APPLICATION_CONFIG["admin_site_media_api"] = array("class" => "AdminSiteMediaApi", "tool_id" => 3);
$WEB_APPLICATION_CONFIG["admin_site_media_edit"] = array("class" => "AdminSiteMediaEdit", "tool_id" => 3);
$WEB_APPLICATION_CONFIG["admin_site_media_crop"] = array("class" => "AdminSiteMediaCrop", "tool_id" => 3);
$WEB_APPLICATION_CONFIG["admin_site_media_update_folder"] = array("class" => "AdminSiteMediaUpdateFolder", "tool_id" => 3);
$WEB_APPLICATION_CONFIG["admin_navigation"] = array("class" => "AdminNavigation", "tool_id" => 4);
$WEB_APPLICATION_CONFIG["admin_navigation_links"] = array("class" => "AdminNavigationLinks", "tool_id" => 4);
$WEB_APPLICATION_CONFIG["admin_global_seo_controller"] = array("class" => "AdminGlobalSeoController", "tool_id" => 5);
$WEB_APPLICATION_CONFIG["admin_global_seo_controller_edit"] = array("class" => "AdminGlobalSeoControllerEdit", "tool_id" => 5);
$WEB_APPLICATION_CONFIG["admin_global_seo_controller_positions"] = array("class" => "AdminGlobalSeoControllerPositions", "tool_id" => 5);
$WEB_APPLICATION_CONFIG["admin_seo_redirect_tool"] = array("class" => "AdminSeoRedirectTool", "tool_id" => 6);
$WEB_APPLICATION_CONFIG["admin_seo_redirect_tool_edit"] = array("class" => "AdminSeoRedirectToolEdit", "tool_id" => 6);
$WEB_APPLICATION_CONFIG["admin_robots_editor"] = array("class" => "AdminRobotsEditor", "tool_id" => 11);
$WEB_APPLICATION_CONFIG["admin_pages"] = array("class" => "AdminPages", "tool_id" => 7);
$WEB_APPLICATION_CONFIG["admin_pages_edit"] = array("class" => "AdminPagesEdit", "tool_id" => 7);
$WEB_APPLICATION_CONFIG["admin_pages_edit_autosave"] = array("class" => "AdminPagesEditAutosave", "tool_id" => 7);
$WEB_APPLICATION_CONFIG["admin_pages_positions"] = array("class" => "AdminPagesPositions", "tool_id" => 7);
$WEB_APPLICATION_CONFIG["admin_pages_settings"] = array("class" => "AdminPagesSettings", "tool_id" => 7);
$WEB_APPLICATION_CONFIG["admin_homepage_settings"] = array("class" => "AdminHomepageSettings", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_homepage_settings_autosave"] = array("class" => "AdminHomepageSettingsAutosave", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_homepage_slideshow"] = array("class" => "AdminHomepageSlideshow", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_homepage_slideshow_positions"] = array("class" => "AdminHomepageSlideshowPositions", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_homepage_slideshow_edit"] = array("class" => "AdminHomepageSlideshowEdit", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_homepage_about"] = array("class" => "AdminHomepageAbout", "tool_id" => 8);
$WEB_APPLICATION_CONFIG["admin_blog_settings"] = array("class" => "AdminBlogSettings", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_categories"] = array("class" => "AdminBlogCategories", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_categories_edit"] = array("class" => "AdminBlogCategoriesEdit", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_categories_edit_autosave"] = array("class" => "AdminBlogCategoriesEditAutosave", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_categories_positions"] = array("class" => "AdminBlogCategoriesPositions", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_posts"] = array("class" => "AdminBlogPosts", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_posts_edit"] = array("class" => "AdminBlogPostsEdit", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_blog_posts_edit_autosave"] = array("class" => "AdminBlogPostsEditAutosave", "tool_id" => 9);
$WEB_APPLICATION_CONFIG["admin_transactions"] = array("class" => "AdminTransactions", "tool_id" => 14);
$WEB_APPLICATION_CONFIG["admin_transactions_view"] = array("class" => "AdminTransactionsView", "tool_id" => 14);
$WEB_APPLICATION_CONFIG["admin_content_blocks"] = array("class" => "AdminContentBlocks", "tool_id" => 16);
$WEB_APPLICATION_CONFIG["admin_content_blocks_edit"] = array("class" => "AdminContentBlocksEdit", "tool_id" => 16);
$WEB_APPLICATION_CONFIG["admin_content_blocks_edit_autosave"] = array("class" => "AdminContentBlocksEditAutosave", "tool_id" => 16);
$WEB_APPLICATION_CONFIG["admin_content_blocks_positions"] = array("class" => "AdminContentBlocksPositions", "tool_id" => 16);
$WEB_APPLICATION_CONFIG["admin_auctions"] = array("class" => "AdminAuctions", "tool_id" => 17);
$WEB_APPLICATION_CONFIG["admin_auctions_edit"] = array("class" => "AdminAuctionsEdit", "tool_id" => 17);
$WEB_APPLICATION_CONFIG["admin_auctions_edit_autosave"] = array("class" => "AdminAuctionsEditAutosave", "tool_id" => 17);
$WEB_APPLICATION_CONFIG["admin_auctions_positions"] = array("class" => "AdminAuctionsPositions", "tool_id" => 17);
$WEB_APPLICATION_CONFIG["admin_contact_reasons"] = array("class" => "AdminContactReasons", "tool_id" => 18);
$WEB_APPLICATION_CONFIG["admin_contact_reasons_edit"] = array("class" => "AdminContactReasonsEdit", "tool_id" => 18);
$WEB_APPLICATION_CONFIG["admin_contact_reasons_edit_autosave"] = array("class" => "AdminContactReasonsEditAutosave", "tool_id" => 18);
$WEB_APPLICATION_CONFIG["admin_contact_reasons_positions"] = array("class" => "AdminContactReasonsPositions", "tool_id" => 18);
$WEB_APPLICATION_CONFIG["admin_contact_settings"] = array("class" => "AdminContactSettings", "tool_id" => 19);
$WEB_APPLICATION_CONFIG["admin_contact_settings_autosave"] = array("class" => "AdminContactSettingsAutosave", "tool_id" => 19);
$WEB_APPLICATION_CONFIG["admin_email_templates"] = array("class" => "AdminEmailTemplates", "tool_id" => 22);
$WEB_APPLICATION_CONFIG["admin_email_templates_edit"] = array("class" => "AdminEmailTemplatesEdit", "tool_id" => 22);
$WEB_APPLICATION_CONFIG["admin_email_templates_edit_autosave"] = array("class" => "AdminEmailTemplatesEditAutosave", "tool_id" => 22);
$WEB_APPLICATION_CONFIG["admin_email_templates_positions"] = array("class" => "AdminEmailTemplatesPositions", "tool_id" => 22);
$WEB_APPLICATION_CONFIG["admin_about_settings"] = array("class" => "AdminAboutSettings", "tool_id" => 23);
$WEB_APPLICATION_CONFIG["admin_about_settings_autosave"] = array("class" => "AdminAboutSettingsAutosave", "tool_id" => 23);
$WEB_APPLICATION_CONFIG["admin_users_request_seller"] = array("class" => "AdminUsersRequestSeller", "tool_id" => 1);

$WEB_APPLICATION_CONFIG["script_sitemap"] = array("class" => "ScriptSitemap");
$WEB_APPLICATION_CONFIG["end_time_auction"] = array("class" => "EndTimeAuction");
