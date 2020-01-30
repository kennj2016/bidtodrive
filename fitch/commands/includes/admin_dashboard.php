<?php

class AdminDashboard
{

    private $blocks = array();
    private $order = null;

    function addBlock($title, $description = null, $icon = null)
    {
        $block = new AdminDashboardBlock($title, $description, $icon);
        $this->blocks[] = $block;
        return $block;
    }

    function hasBlocks()
    {
        return !empty($this->blocks);
    }

    function getBlocks()
    {
        $blocks = $this->blocks;

        if ($this->order === null) {
            $this->order = array();
            if ($order = FJF_BASE_RICH::getRecord(
                "site_data",
                "type='admin-settings' AND name='tools-order'"
            )) {
                $order = json_decode($order->data);
                if ($order && $order->blocks) $this->order = $order->blocks;
            }
        }

        if ($this->order) usort($blocks, array($this, 'sort_cmp_function'));

        return $blocks;
    }

    function isActive()
    {
        foreach ($this->blocks as $block) if ($block->isActive()) return $block;
        return null;
    }

    function sort_cmp_function($a, $b)
    {
        $asp = array_search(strtolower($a->title), $this->order);
        $bsp = array_search(strtolower($b->title), $this->order);
        $abp = array_search($a, $this->blocks);
        $bbp = array_search($b, $this->blocks);
        if ($asp !== false && $bsp !== false) return $asp - $bsp;
        if ($asp !== false) return -1;
        if ($bsp !== false) return 1;
        return $abp - $bbp;
    }

}

class AdminDashboardBlock
{

    public $title;
    public $description = "";
    public $icon = "default";
    public $custom_icon = false;
    public $tools = array();
    public $ids = array();

    function __construct($title, $description = null, $icon = null)
    {
        $this->title = $title;
        if ($description) $this->description = $description;
        if ($icon) {
            if (strpos($icon, ".") === 0) {
                $this->custom_icon = true;
                $this->icon = ltrim($icon, ".");
            } else {
                $this->icon = $icon;
            }
        }
    }

    function addTool($title, $id = null)
    {
        $tool = new AdminDashboardTool($title, $id);
        if ($tool->id) {
            $this->ids[] = $tool->id;
            $this->ids = array_unique($this->ids);
        }
        $this->tools[] = $tool;
        return $tool;
    }

    function isActive()
    {
        foreach ($this->tools as $tool) if ($tool->isActive()) return true;
        return false;
    }

}

class AdminDashboardTool
{

    public $id = 0;
    public $title;
    public $actions = array();
    public $action = null;

    function __construct($title, $id = null)
    {
        $this->title = $title;
        if ($id) $this->id = $id;
    }

    function addAction($type, $url, $default = false)
    {
        $action = new AdminDashboardAction($type, $url);
        if ($default || !$this->action) $this->action = $action;
        $this->actions[] = $action;
        return $action;
    }

    function isActive()
    {
        foreach ($this->actions as $action) if ($action->isActive()) return true;
        return false;
    }

}

class AdminDashboardAction
{

    public $url;
    public $type;

    function __construct($type, $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    function isActive()
    {
        return strpos($_SERVER["REQUEST_URI"], $this->url) !== false;
    }

}

?>