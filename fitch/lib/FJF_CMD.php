<?php

abstract class FJF_CMD
{
    protected $tool_title = null; // Plural
    protected $tool_title_singular = null;
    protected $record = null;
    protected $bread_crumb_parent = [];
    protected $bread_crumb_current = null;

    /** main command logic */
    public abstract function execute();

    /** checks for ajax requests. return true - if the page was requested via ajax **/
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

    protected function fetchTemplate($template, $params = array())
    {
        $result = "";
        if (file_exists($GLOBALS["WEB_APPLICATION_CONFIG"]["templates_path"])) {
            if (is_array($params)) $params["cmd"] = $GLOBALS['REQUEST_CMD'];
            $GLOBALS["smartyEngine"]->assign("parameters", $params);
            $result = $GLOBALS["smartyEngine"]->fetch($template);
        } else {
            FJF_BASE::log("Template '$template' doesn't exist", __METHOD__);
        }
        return $result;
    }

    /** displays smarty template */
    protected function displayTemplate($template, $params = array())
    {
        if (file_exists($GLOBALS["WEB_APPLICATION_CONFIG"]["templates_path"])) {
            FJF_BASE::log("Displaying template '$template'", __METHOD__);
            if (is_array($params)) $params["cmd"] = $GLOBALS['REQUEST_CMD'];
            $tools = [
                'tool_title' => $this->getToolTitle(),
                'tool_title_singular' => $this->getToolTitleSingular(),
                'record_title' => $this->getRecordTitle(),
                'current_breadcrumb' => $this->getCurrentBreadCrumb(),
                'parent_breadcrumbs' => $this->getParentBreadCrumbs()
            ];
            $GLOBALS["smartyEngine"]->assign("admin_tools", $tools);
            $GLOBALS["smartyEngine"]->assign("parameters", $params);
            $GLOBALS["smartyEngine"]->display($template);
        } else {
            FJF_BASE::log("Template '$template' doesn't exist", __METHOD__);
        }
    }

    /** publishes smarty template */
    protected function publishTemplate($publishFilePath, $template, $params = array())
    {
        if (file_exists($GLOBALS["WEB_APPLICATION_CONFIG"]["templates_path"])) {
            FJF_BASE::log("Fetching template '$template'", "publishTemplate");
            $GLOBALS["smartyEngine"]->assign("parameters", $params);

            $file = $GLOBALS["smartyEngine"]->fetch($template);

            if ($fp = @fopen($publishFilePath, "w")) {

                $result = @fputs($fp, $file);
                if ($result) {
                    return true;
                } else {
                    FJF_BASE::log("Cannot write to '$publishFilePath'", "publishTemplate");
                }

                @flose($fp);

            } else {
                FJF_BASE::log("File '$publishFilePath' is not writable", "publishTemplate");
            }

        } else {
            FJF_BASE::log("Template '$template' doesn't exist", "publishTemplate");
        }
    } // end publishTemplates

    function displayJSON($data = null)
    {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($data);
        return true;
    }

    public function getToolTitle()
    {
        return (string)$this->tool_title;
    }

    protected function setToolTitle($title)
    {
        $this->tool_title = $title;
    }

    public function getToolTitleSingular()
    {
        $title = (string)$this->tool_title_singular;
        if ($title !== '')
            return $title;
        $plural = $this->getToolTitle();
        if ($plural !== '')
            return preg_replace('/^([a-zA-Z0-9-_\s]+)s$/', '$1', $plural);
        return '';
    }

    protected function setToolTitleSingular($title)
    {
        $this->tool_title_singular = (string)$title;
    }

    public function setRecord(stdClass $record)
    {
        $this->record = clone $record;
    }

    public function getRecord()
    {
        return $this->record;
    }

    protected function isValidRecord()
    {
        return $this->record instanceof stdClass;
    }

    public function getRecordTitle()
    {
        $title = '';
        if ($this->isValidRecord()) {
            if (isset($this->record->title))
                $title = $this->record->title;
            elseif (isset($this->record->name))
                $title = $this->record->name;
        }
        return (string)$title;
    }

    protected function addParentBreadCrumb($urlPart, $title = null)
    {
        if ($title === null)
            $title = $this->getToolTitle();
        $this->bread_crumb_parent[] = [
            'url' => $urlPart,
            'title' => $title
        ];
        return $this;
    }

    public function getParentBreadCrumbs()
    {
        return $this->bread_crumb_parent;
    }

    protected function setCurrentBreadCrumb($title)
    {
        $this->bread_crumb_current = (string)$title;
    }

    protected function getCurrentBreadCrumb()
    {
        $title = $this->getToolTitle();
        if ($this->bread_crumb_current === null) {
            if ($this->isValidRecord()) {
                if (isset($this->record->id)) {
                    $title = $this->getRecordTitle();
                    if ($title !== '')
                        $title = "Edit {$title}";
                } else {
                    $toolTitle = $this->getToolTitleSingular();
                    if ($toolTitle !== '')
                        $title = "Add {$toolTitle}";
                }
            }
        } else {
            $title = (string)$this->bread_crumb_current;
        }
        return $title;
    }

}

?>