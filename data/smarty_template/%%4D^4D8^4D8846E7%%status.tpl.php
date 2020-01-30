<?php /* Smarty version 2.6.31, created on 2020-01-10 10:40:50
         compiled from includes/admin/status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'trim', 'includes/admin/status.tpl', 13, false),array('modifier', 'escape', 'includes/admin/status.tpl', 13, false),array('modifier', 'nl2br', 'includes/admin/status.tpl', 13, false),)), $this); ?>
<?php echo '';  if ($this->_tpl_vars['parameters']['status']):  echo '';  if ($this->_tpl_vars['parameters']['has_error']):  echo '';  $this->assign('type', 'error');  echo '';  $this->assign('fixed', 1);  echo '';  else:  echo '';  $this->assign('type', 'success');  echo '';  $this->assign('fixed', 0);  echo '';  endif;  echo '';  $this->assign('status', ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['parameters']['status'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)));  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/admin/message.tpl", 'smarty_include_vars' => array('type' => $this->_tpl_vars['type'],'message' => "<b>".($this->_tpl_vars['status'])."</b>",'fixed' => $this->_tpl_vars['fixed'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  endif;  echo ''; ?>