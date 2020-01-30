<?php /* Smarty version 2.6.31, created on 2020-01-10 10:40:50
         compiled from admin_login.tpl */ ?>
<?php echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/admin/site_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<script type="text/javascript" src="/js/admin/cmd/';  echo $this->_tpl_vars['parameters']['cmd'];  echo '.js"></script><form class="signin" action="" method="post"><div class="logo"><img src="/img/admin/custom/logo.svg" /></div><div class="wrap"><label class="left icon email" for="signin-email"></label><input type="text" placeholder="email" name="email" id="signin-email" class="text" /></div><div class="wrap"><label class="left icon password" for="signin-password"></label><input type="password" placeholder="password" name="password" id="signin-password" class="text" /></div><div class="wrap"><div class="left input"><input name="remember" id="signin-remember" type="checkbox" /></div><label for="signin-remember" class="text">remember my login credentials</label></div><input type="submit" value="SIGN IN" class="submit" /><div class="npg-framework">the <a href="http://www.npgroup.net/" target="_blank">new possibilities group</a> framework</div></form>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/admin/site_bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo ''; ?>