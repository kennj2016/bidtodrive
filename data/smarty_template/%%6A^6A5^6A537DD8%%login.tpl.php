<?php /* Smarty version 2.6.31, created on 2020-01-21 03:36:52
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'login.tpl', 16, false),)), $this); ?>
<?php echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<div class="row no-gutters bg-image full-height overflow"><div class="container full-height"><div class="col-24 full-height"><div class="module-login"><span class="tint"></span><div class="honeycomb"></div><div class="content"><div class="box-holder"><div class="sign"></div><div class="left"><div class="holder"><h3 class="title">bid to drive</h3>';  if ($this->_tpl_vars['parameters']['page']->left_title):  echo '<p class="subtitle">';  echo ((is_array($_tmp=$this->_tpl_vars['parameters']['page']->left_title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  echo '</p>';  endif;  echo '';  if ($this->_tpl_vars['parameters']['page']->left_description):  echo '<p>';  echo ((is_array($_tmp=$this->_tpl_vars['parameters']['page']->left_description)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  echo '</p>';  endif;  echo '</div></div><div class="right"><div class="holder"><div class="module-tab-2 break skin-1-alt color-1"><div class="content"><div class="tab-index"><div class="list"><a class="item fake-tab active" href="/login/" title="login">login</a>';  echo '</div></div><div class="tab-content"><div class="tab-item active">';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/tablogin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</div></div></div></div></div></div></div></div></div></div></div></div>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo ''; ?>