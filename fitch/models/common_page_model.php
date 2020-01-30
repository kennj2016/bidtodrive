<?php

class CommonPageModel
{

    protected $blocks = array();
    protected $metadata = array();
    protected $data = array();
    protected $breadcrumbs = array();
    protected $navigations = array();
    protected $site_vars = array();
    protected $settings = null;
    protected $embed_codes = array();
    protected $url_path = array();
    protected $url_path_normalized = array();
    protected $url_parts = array();
    protected $url_parts_total = 0;
    protected $https = false;
    protected $scheme = "http";
    protected $static_server = "";

    function __construct(array $blocks = array())
    {
        $GLOBALS["smartyEngine"]->assign("page", $this);
        $this->setBlocks($blocks);

        $this->https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
        if ($this->https) $this->scheme = "https";

        $this->url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($this->url_path, "/");
        $this->url_parts = $url ? explode("/", $url) : array();
        $this->url_parts_total = count($this->url_parts);
        $this->url_path_normalized = $this->url_parts_total ? "/" . implode("/", $this->url_parts) . "/" : "/";

        if ($value = $this->siteVar("cdn_server")) {
            $cdnServer = str_replace(array("http:", "https:"), "", $value);
        } else {
            $cdnServer = $_SERVER["SERVER_NAME"];
        }
        $this->static_server = $this->scheme . "://" . trim($cdnServer, "/");
    }

    function getStaticServer()
    {
        return $this->static_server;
    }

    function getScheme()
    {
        return $this->scheme;
    }

    function isHTTPS()
    {
        return $this->https;
    }

    function getBaseURL()
    {
        return $this->scheme . "://" . $_SERVER['SERVER_NAME'] . "/";
    }

    function getURLPath()
    {
        return $this->url_path;
    }

    function getURLParts()
    {
        return $this->url_parts;
    }

    function getURLPartsTotal()
    {
        return $this->url_parts_total;
    }

    function getURLPart($position = 0)
    {
        if (is_int($position)) {
            if ($position < 0) $position += $this->url_parts_total;
            return 0 <= $position && $position < $this->url_parts_total ? $this->url_parts[$position] : null;
        } else {
            foreach ($this->url_parts as $i => $part) {
                if ($part == $position) return $i <= $this->url_parts_total ? $this->url_parts[$i + 1] : null;
            }
        }
        return null;
    }

    function getURLPartFirst()
    {
        return $this->getURLPart(0);
    }

    function getURLPartLast()
    {
        return $this->getURLPart(-1);
    }

    function setBlocks($blocks)
    {
        if ($blocks) foreach ($blocks as $block => $options) $this->setBlock($block, $options);
    }

    function setBlock($name, $options = true)
    {
        $this->blocks[$name] = $options;
    }

    function hasBlock($name)
    {
        return array_key_exists($name, $this->blocks);
    }

    function getBlock($name)
    {
        return $this->hasBlock($name) ? $this->blocks[$name] : null;
    }

    function setData($name, $value)
    {
        $this->data[$name] = $value;
    }

    function hasData($name)
    {
        return array_key_exists($name, $this->data);
    }

    function getData($name)
    {
        return $this->hasData($name) ? $this->data[$name] : null;
    }

    function setBreadcrumbs($breadcrumbs = null)
    {
        $this->breadcrumbs = array();
        if ($breadcrumbs) $this->addBreadcrumbs($breadcrumbs);
    }

    function addBreadcrumbs($link, $url = null)
    {
        if (is_array($link)) foreach ($link as $u => $l) $this->addBreadcrumbs($l, $u);
        else {
            if ($url && strpos($url, '/') !== 0 && !preg_match("/^[a-z\d]+:\/\//", $url)) {
                $url = preg_replace(
                        "/\/[^\/]+$/", "",
                        $this->breadcrumbs ? $this->breadcrumbs[count($this->breadcrumbs) - 1]->url : '/'
                    ) . $url . (substr($url, -1) != '/' ? '/' : '');
            }
            $this->breadcrumbs[] = (object)array('link' => $link, 'url' => $url);
        }
    }

    function hasBreadcrumbs()
    {
        return !empty($this->breadcrumbs);
    }

    function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    function goBack()
    {
        FJF_BASE::redirect($this->getBackURL());
    }

    function getBackURL()
    {
        $c = $this->breadcrumbs ? count($this->breadcrumbs) : 0;
        return $c > 1 ? $this->breadcrumbs[$c - 2]->url : '';
    }

    function setNavigation($name, $value)
    {
        $name = strtolower($name);
        $this->navigations[$name] = $value;
        if ($value) $this->checkNavigationItems($value);
    }

    function checkNavigationItems($items)
    {
        $hasCurrent = false;
        foreach ($items as $item) {
            $item->is_current = $item->url == $this->url_path_normalized;
            if ($item->is_current) $hasCurrent = true;
            $item->has_current = $item->items ? $this->checkNavigationItems($item->items) : false;
            $item->is_parent_url = $item->url && strpos($this->url_path_normalized, $item->url) === 0;
        }
        return $hasCurrent;
    }

    function hasNavigation($name)
    {
        $name = strtolower($name);
        return array_key_exists($name, $this->navigations) && $this->navigations[$name];
    }

    function getNavigation($name)
    {
        $name = strtolower($name);
        return $this->hasNavigation($name) ? $this->navigations[$name] : null;
    }


    /*
     * @param (name0, name1, ...)
     * @param (array(name0, name1, ...))
     * @return int total
     */
    function hasBlocks()
    {
        $names = func_num_args() > 1 ? func_get_args() : func_get_arg(0);
        $count = 0;
        foreach ($names as $name) $count += $this->hasBlock($name) ? 1 : 0;
        return $count;
    }

    /*
     * @param (name0, name1, ...)
     * @param (array(name0, name1, ...))
     * @return array blocks
     */
    function getBlocks()
    {
        $names = func_num_args() > 1 ? func_get_args() : func_get_arg(0);
        $blocks = array();
        foreach ($names as $name) {
            if ($block = $this->getBlock()) $blocks[] = $block;
        }
        return $blocks;
    }

    /*
    * @param (name, value[, replace = false])
    * @param (array(name0 => value0, name1 => value1, ...)[, replace = false])
     */
    function setMetadata()
    {
        $a0 = func_get_arg(0);
        $num = func_num_args();
        if (is_array($a0)) {
            $values = $a0;
            $replace = $num > 1 ? func_get_arg(1) : true;
            if ($this->getMetadata('is_main')) $replace = false;
            foreach ($values as $name => $value) {
                if ($replace || !$this->getMetadata($name)) $this->metadata[$name] = $value;
            }
        } else {
            $name = $a0;
            $value = func_get_arg(1);
            $replace = $num > 2 ? func_get_arg(2) : true;
            if ($this->getMetadata('is_main')) $replace = false;
            if ($replace || !$this->getMetadata($name)) $this->metadata[$name] = $value;
        }
    }

    function getMetadata($name)
    {
        return array_key_exists($name, $this->metadata) ? $this->metadata[$name] : null;
    }

    function extractMetadata($record)
    {
        if ($record) {
            if (isset($record->meta_title) && $record->meta_title) $this->setMetadata('title', $record->meta_title, true);
            if (isset($record->meta_keywords) && $record->meta_keywords) $this->setMetadata('keywords', $record->meta_keywords, true);
            if (isset($record->meta_description) && $record->meta_description) $this->setMetadata('description', $record->meta_description, true);
        }
    }

    function siteMediaUrl($folder, $file, $size = null)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
        return SiteMediaModel::getFileUrl($folder, $file, $size);
    }

    function siteMediaExists($folder, $file, $size = null)
    {
        include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/site_media_model.php");
        return SiteMediaModel::isFileExists($folder, $file, $size);
    }

    function siteVar($name)
    {
        return RecordsModel::getSiteVar($name);
    }

    function loadSettings($name)
    {
        $this->settings = RecordsModel::getSiteData("pages_settings", $name);
        if ($this->settings) $this->extractMetadata($this->settings);
    }

    function getSettings($param = null)
    {
        if ($param == null) return $this->settings;
        return $param && isset($this->settings->{$param}) ? $this->settings->{$param} : null;
    }

    function loadTemplatePage($page)
    {
        if ($page && !is_object($page)) $page = RecordsModel::getTemplatePage($page);
        if ($page) {
            $this->setData('template-page', $page);
            $this->setMetadata('title', $page->title);
            $this->extractMetadata($page);
        }
        return $page;
    }

    function loadSeoSettings()
    {
        $settings = RecordsModel::getGlobalSeoController();
        if ($settings) {
            $this->extractMetadata($settings);
            $this->setMetadata("is_main", $settings->is_main);
        }
    }

    function addEmbedCode($id, $code, $target)
    {
        $this->embed_codes[$id] = array(
            'code' => $code,
            'target' => $target
        );
    }

    function getEmbedCode($target)
    {
        $result = array();
        foreach ($this->embed_codes as $embedCode) {
            if ($embedCode['target'] == $target) $result[] = $embedCode['code'];
        }
        return $result;
    }

    function addJS($value, $target = null)
    {
        $isSrc = strpos($value, 'http://') === 0 || strpos($value, 'https://') === 0 || strpos($value, '/') === 0 || strpos($value, '//') === 0;
        if ($isSrc && strpos($value, '/') === 0 && strpos($value, '//') !== 0) {
            $value = $this->static_server . $value;
        }
        $this->addEmbedCode(
            $isSrc ? $value : md5($value),
            '<script type="text/javascript"' . ($isSrc ? ' src="' . $value . '"' : '') . '>' . ($isSrc ? '' : $value) . '</script>',
            $target ? $target : 'head'
        );
    }

    function addCmdJS()
    {
        $this->addJS('/js/main/cmd/' . $GLOBALS['REQUEST_CMD'] . '.js');
    }

    function addCSS($src)
    {
        if (strpos($src, '/') === 0 && strpos($src, '//') !== 0) {
            $src = $this->static_server . $src;
        }
        $this->addEmbedCode($src, '<link rel="stylesheet" type="text/css" href="' . $src . '">', 'head');
    }

    function addCmdCSS()
    {
        $this->addCSS('/css/main/cmd/' . $GLOBALS['REQUEST_CMD'] . '.css');
    }

}

?>