<?php
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/records_model.php");

class ScriptSitemap extends FJF_CMD
{

		var $content = "";
		var $serverURL = "";
		var $lastMod = "";

		function __construct()
		{
				$this->serverURL = $_SERVER["SERVER_NAME"];
		}

		function execute()
		{
			$pattern = 'Y-m-d';
			$now = date($pattern);

			$pages = array(
				"/" => ["url" => "/", "priority" => "0.9", "changefreq" => "weekly", "lastmod" => $now],
				"auctions" => ["url" => "/auctions/", "priority" => "0.8", "changefreq" => "weekly", "lastmod" => $now],
				"about-us" => ["url" => "/about-us/", "priority" => "0.8", "changefreq" => "weekly", "lastmod" => $now],
				"news" => ["url" => "/news/", "priority" => "0.8", "changefreq" => "weekly", "lastmod" => $now],
				"contact-us" => ["url" => "/contact-us/", "priority" => "0.8", "changefreq" => "monthly", "lastmod" => $now]
			);
			
			if ($pagesRecords = FJF_BASE_RICH::getRecords("pages", "status = 1 AND approved=1 AND url_title <> '404' ORDER BY id ", null, false, "id, url_title, datetime_create, datetime_update")) 
			{
				foreach ($pagesRecords as $page) {
					$key = $page->url_title;
					if ($page->id && !array_key_exists($key, $pages)) {
						$pages[$key] = array(
							"url" => "/" . $key . "/",
							"priority" => "0.7",
							"changefreq" => "weekly",
							"lastmod" => $page->datetime_update ? date($pattern, strtotime($page->datetime_update)) : date($pattern, strtotime($page->datetime_create))
						);
					}
				}
			}

			if ($auctions = FJF_BASE_RICH::getRecords("auctions", "status = 1 AND approved = 1 AND expiration_date > NOW() AND auction_status = 'Active' ORDER BY id", null, false, "id, make, model, year, datetime_create, datetime_update, expiration_date")) 
			{
				foreach ($auctions as $page) {
					$key = strtolower ($page->make . " " . $page->model . " " . $page->year);
					if ($page->id && !array_key_exists($key, $pages)) {
						$pages[$key] = array(
							"url" => "/auctions/" . $page->id . "/",
							"priority" => "0.6",
							"changefreq" => "weekly",
							"lastmod" => $page->datetime_update ? date($pattern, strtotime($page->datetime_update)) : date($pattern, strtotime($page->datetime_create))
						);
					}
				}
			}
			
			if ($news = FJF_BASE_RICH::getRecords("blog_posts", "status = 1 AND approved = 1 ORDER BY id", null, false, "id, url_title, datetime_create, datetime_update")) 
			{
				foreach ($news as $page) {
					$key = "news/" . $page->url_title;
					if ($page->id && !array_key_exists($key, $pages)) {
						$pages[$key] = array(
							"url" => "/" . $key . "/",
							"priority" => "0.6",
							"changefreq" => "weekly",
							"lastmod" => $page->datetime_update ? date($pattern, strtotime($page->datetime_update)) : date($pattern, strtotime($page->datetime_create))
						);
					}
				}
			}
			
			if ($sellers = FJF_BASE_RICH::getRecords("users", "status = 1 AND user_type = 'Seller' ORDER BY id", null, false, "id, url_title, datetime_create, datetime_update, user_type")) 
			{
				foreach ($sellers as $page) {
					$key = "seller/" . $page->url_title;
					if ($page->id && !array_key_exists($key, $pages)) {
						$pages[$key] = array(
							"url" => "/" . $key . "/",
							"priority" => "0.6",
							"changefreq" => "weekly",
							"lastmod" => $page->datetime_update ? date($pattern, strtotime($page->datetime_update)) : date($pattern, strtotime($page->datetime_create))
						);
					}
				}
			}

			foreach ($pages as $page) {
				$this->addUrl($page["url"], $page["priority"], $page["changefreq"], $page["lastmod"]);
			}

			$this->saveSitemap();

			exit("Done");
		}

		function addUrl($url, $priority, $changefreq = 'monthly', $lastmod = null)
		{
			$url = trim($url, " /");
			$lastmod = $lastmod ?: date('Y-m-d');
			if ($url) $url .= "/";
			$content = "  <url>\n";
			$content .= "    <loc>https://" . $this->serverURL . "/" . $url . "</loc>\n";
			$content .= "    <lastmod>" . $lastmod . "</lastmod>\n";
			$content .= "    <changefreq>" . $changefreq . "</changefreq>\n";
			$content .= "    <priority>" . $priority . "</priority>\n";
			$content .= "  </url>\n";
			$this->content .= $content;
			return true;
		}

		function saveSitemap()
		{
			if ($this->content) {
				$cacheFile = $_SERVER["DOCUMENT_ROOT"] . "/sitemap.xml";
				$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
				$content .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
				$content .= $this->content;
				$content .= "</urlset>\n";
				return @file_put_contents($cacheFile, $content);
			}
			return false;
		}

}

?>