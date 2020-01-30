<?php

FJF_BASE::log("action", __METHOD__);

$this->sessionModel->requireAdminPermissions();

$header = array();
$hasError = false;
$status = FJF_BASE::status();

require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/common_records_model.php");
$header['site_vars'] = CommonRecordsModel::getSiteVars();

require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_dashboard.php");

$dashboard = new AdminDashboard();
$block = $dashboard->addBlock('user tools', 'control and set users here.', 'users');
$tool = $block->addTool('Administrators', 1);
$tool->addAction('manage', '/admin/administrators/');
$tool->addAction('add', '/admin/administrators/add/');
$tool = $block->addTool('Users', 1);
$tool->addAction('manage', '/admin/users/');

$tool->addAction('add', '/admin/users/add/');

$tool = $block->addTool('User Control', 1);
$tool->addAction('manage', '/admin/usercontrol/');


$tool = $block->addTool('Request Seller', 1);
$tool->addAction('manage', '/admin/users-request-seller/');

$tool = $block->addTool('Login Settings', 1);
$tool->addAction('manage', '/admin/login/settings/');
$tool = $block->addTool('Registration Settings', 1);
$tool->addAction('manage', '/admin/registration/settings/');

$block = $dashboard->addBlock('Settings', 'control and set your SEO settings here.', 'whell');
$tool = $block->addTool('Site Vars', 2);
$tool->addAction('manage', '/admin/site_vars/');
$tool = $block->addTool('Site Media', 3);
$tool->addAction('manage', '/admin/site_media/');
$tool->addAction('add', '/admin/site_media/add/');
$tool = $block->addTool('Navigation', 4);
$tool->addAction('manage', '/admin/navigation/');
$tool = $block->addTool('SEO Settings', 10);
$tool->addAction('manage', '/admin/global_seo_controller/');
$tool->addAction('add', '/admin/global_seo_controller/add/');
$tool = $block->addTool('301 Redirects', 11);
$tool->addAction('manage', '/admin/seo_redirect_tool/');
$tool->addAction('add', '/admin/seo_redirect_tool/add/');
$tool = $block->addTool('Robots.txt Editor', 12);
$tool->addAction('manage', '/admin/robots_editor/');

$block = $dashboard->addBlock('Workflow', 'Workflow tool.', 'workflow');
$tool = $block->addTool('Workflow', 999);
$tool->addAction('manage', '/admin/workflow/');

$block = $dashboard->addBlock('Template Pages', 'control and set your template pages here.', 'template');
$tool = $block->addTool('Template Pages', 7);
$tool->addAction('manage', '/admin/pages/');
$tool->addAction('add', '/admin/pages/add/');

$block = $dashboard->addBlock('Homepage', 'control site home page.', 'home');
$tool = $block->addTool('Settings', 8);
$tool->addAction('manage', '/admin/homepage/settings/');

$block = $dashboard->addBlock('Blog', 'control and set your blog here.', 'news');
$tool = $block->addTool('Blog Settings', 9);
$tool->addAction('manage', '/admin/blog/settings/');
$tool = $block->addTool('Blog Categories', 9);
$tool->addAction('manage', '/admin/blog/categories/');
$tool->addAction('add', '/admin/blog/categories/add/');
$tool = $block->addTool('Blog Posts', 9);
$tool->addAction('manage', '/admin/blog/posts/');
$tool->addAction('add', '/admin/blog/posts/add/');

$block = $dashboard->addBlock('Transactions', 'control and set your transactions here.');
$tool = $block->addTool('Transactions', 14);
$tool->addAction('manage', '/admin/transactions/');
$tool->addAction('add', '/admin/transactions/add/');

$block = $dashboard->addBlock('Auctions', 'control and set your products here.');
$tool = $block->addTool('Content Blocks', 16);
$tool->addAction('manage', '/admin/content_blocks/');
$tool->addAction('add', '/admin/content_blocks/add/');
$tool = $block->addTool('Auctions', 16);
$tool->addAction('manage', '/admin/auctions/');
$tool->addAction('add', '/admin/auctions/add/');

$block = $dashboard->addBlock('Contact Us', 'control site home page.', 'home');
$tool = $block->addTool('Settings', 19);
$tool->addAction('manage', '/admin/contact/settings/');
$tool = $block->addTool('Form Submissions', 1);
$tool->addAction('manage', '/admin/subscribers/');
$tool = $block->addTool('Reasons for Contact', 18);
$tool->addAction('manage', '/admin/contact_reasons/');

$block = $dashboard->addBlock('Email Templates', 'control and set your products here.');
$tool = $block->addTool('Email Templates', 22);
$tool->addAction('manage', '/admin/email_templates/');
$tool->addAction('add', '/admin/email_templates/add/');

$block = $dashboard->addBlock('About', 'control site home page.', 'home');
$tool = $block->addTool('Settings', 23);
$tool->addAction('manage', '/admin/about/settings/');

$header['dashboard'] = $dashboard;
unset($dashboard, $block, $tool);

$header["return"] = isset($_GET["return"]) ? $_GET["return"] : null;

?>
