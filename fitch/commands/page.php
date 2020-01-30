<?php

class Page extends FJF_CMD
{

    function execute()
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/page_model.php");
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
        $this->page = new PageModel();
        $this->sessionModel = new SessionModel();

        $page = $this->page->loadTemplatePage($this->page->getURLPartLast());

        if (!$page) {

            if ($records = FJF_BASE_RICH::getRecords("seo_redirect", "status = 1 ORDER BY id")) {

                $request_uri = preg_replace("/\#.+$/", "", $_SERVER["REQUEST_URI"]);
                $request_uri = explode("?", $request_uri);
                $request_path = $request_uri[0];
                $request_query = array();
                if (count($request_uri) > 1) parse_str($request_uri[1], $request_query);

                $urls = array(
                    "scheme+domain+path" => "http" . (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 's' : '') . "://" . $_SERVER["SERVER_NAME"] . $request_path,
                    "domain+path" => $_SERVER["SERVER_NAME"] . $request_path,
                    "path" => $request_path
                );

                $matchesGroups = array(
                    "scheme+domain+path+query" => array(),
                    "scheme+domain+path" => array(),
                    "domain+path+query" => array(),
                    "domain+path" => array(),
                    "path+query" => array(),
                    "path" => array()
                );

                foreach ($records as $item) {

                    $old_uri = preg_replace("/\#.+$/", "", $item->old_url);
                    $old_uri = explode("?", $old_uri);
                    $old_path = $old_uri[0];
                    $old_query = array();
                    if (count($old_uri) > 1) parse_str($old_uri[1], $old_query);
                    $old_query_count = count($old_query);

                    foreach ($urls as $group => $url) {
                        if ($old_path == $url) {

                            if (!$old_query_count) {
                                $matchesGroups[$group][] = $item->new_url;
                            } elseif ($old_query_count == count(array_intersect_assoc($old_query, $request_query))) {
                                if (!array_key_exists($old_path, $matchesGroups[$group . "+query"])) {
                                    $matchesGroups[$group . "+query"][$old_path] = array();
                                }
                                if (!array_key_exists($old_query_count, $matchesGroups[$group . "+query"][$old_path])) {
                                    $matchesGroups[$group . "+query"][$old_path][$old_query_count] = array();
                                }
                                $matchesGroups[$group . "+query"][$old_path][$old_query_count][] = $item->new_url;
                            }

                        }
                    }

                }

                foreach ($matchesGroups as $matches) {
                    if ($matches) {
                        $redirect = array_shift($matches);

                        if (is_array($redirect)) {
                            ksort($redirect);
                            $redirect = array_reverse($redirect);
                            $redirect = $redirect[0][0];
                        }

                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: " . $redirect);
                        exit;
                    }
                }

            }

            //$this->page->loadTemplatePage('page-not-found');
            $this->page->setMetadata('robots', 'noindex, follow');
            $this->page->setMetadata('title', 'Page Not Found');
            header("HTTP/1.0 404 Not Found");

            return $this->displayTemplate("page_not_found.tpl", array());
        }

        $this->page->extractMetadata($page);
        if (isset($page->title) && $page->title != "") {
            $this->page->addBreadcrumbs($page->title);
        }

        return $this->displayTemplate("page.tpl", array(
            "body_class" => "t1",
            "page" => $page
        ));
    }

}

?>