<?php /* Smarty version 2.6.31, created on 2019-10-15 04:30:34
         compiled from includes/main/breadcrumbs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'includes/main/breadcrumbs.tpl', 11, false),)), $this); ?>
<?php echo '';  if ($this->_tpl_vars['page']->hasBreadcrumbs()):  echo '<div class="row flex no-gutters bg-grey"><div class="container"><div class="col-24"><div class="breadcrumbs"><p><a href="/" class="home"><img src="/images/icons/icon-home.svg" alt="Homepage" title="Homepage"/></a>';  $_from = $this->_tpl_vars['page']->getBreadcrumbs(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['breadcrumbs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['breadcrumbs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['breadcrumb']):
        $this->_foreach['breadcrumbs']['iteration']++;
 echo '';  if ($this->_tpl_vars['breadcrumb']->url):  echo '<a href="';  echo $this->_tpl_vars['breadcrumb']->url;  echo '" title="';  echo $this->_tpl_vars['breadcrumb']->url;  echo '">';  endif;  echo '';  echo ((is_array($_tmp=$this->_tpl_vars['breadcrumb']->link)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp));  echo '';  if ($this->_tpl_vars['breadcrumb']->url):  echo '</a>';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</p></div></div></div></div>';  endif;  echo ''; ?>