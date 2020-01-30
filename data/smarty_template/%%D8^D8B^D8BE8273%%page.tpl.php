<?php /* Smarty version 2.6.31, created on 2019-10-15 05:30:34
         compiled from page.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'page.tpl', 9, false),)), $this); ?>
<?php echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<div class="row no-gutters bg-image" ';  if ($this->_tpl_vars['parameters']['page']->hero_image):  echo ' style="background-image:url(\'/site_media/';  echo $this->_tpl_vars['parameters']['page']->hero_image;  echo '\');"';  endif;  echo '><div class="container"><div class="col-24 last first"><div class="module-hero-2"><div class="content"><h3 class="title">';  echo ((is_array($_tmp=$this->_tpl_vars['parameters']['page']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  echo '</h3><p>';  echo ((is_array($_tmp=$this->_tpl_vars['parameters']['page']->subtitle)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  echo '</p></div></div></div></div></div>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/breadcrumbs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  if ($this->_tpl_vars['parameters']['page']):  echo '';  echo $this->_tpl_vars['parameters']['page']->body;  echo '';  endif;  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo ''; ?>