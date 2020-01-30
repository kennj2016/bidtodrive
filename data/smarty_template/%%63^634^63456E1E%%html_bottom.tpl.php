<?php /* Smarty version 2.6.31, created on 2020-01-22 02:05:28
         compiled from includes/main/html_bottom.tpl */ ?>
<?php echo '';  $_from = $this->_tpl_vars['page']->getEmbedCode('body:after'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['code']):
 echo '';  echo $this->_tpl_vars['code'];  echo '';  endforeach; endif; unset($_from);  echo '</body></html>'; ?>