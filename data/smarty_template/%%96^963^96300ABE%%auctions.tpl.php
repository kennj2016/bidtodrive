<?php /* Smarty version 2.6.31, created on 2020-01-21 04:04:00
         compiled from auctions.tpl */ ?>
<?php echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<div class="sec-holder"><div class="sec-1"><div class="baron"><div class="baron__clipper"><div class="baron__bar"></div>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auctions_filters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</div></div></div><div class="sec-2"><div class="baron"><div class="baron__clipper"><div class="baron__bar"></div><div class="baron__scroller search-list-container"><div class="content-box"><div class="tablet-left-panel-opener-box"><div class="holder"><div class="input-search"><input type="search" name="mobile_keyword" value="';  echo $_REQUEST['keyword'];  echo '" placeholder="Search by keyword..."></div><div class="filter-opener left-panel-opener-button"><div class="icon"><img class="svg-icon-inject" src="/images/icons/icons-30.svg" alt="Filter" title="Filter"/></div></div></div></div><div class="sep-tablet"></div><div class="top-controll-panel"><div class="left"><div class="result-name">';  if ($_REQUEST['keyword']):  echo '';  echo $_REQUEST['keyword'];  echo '';  else:  echo 'All';  endif;  echo ' Auctions</div><div class="result-detail">Search Results - <span>';  echo $this->_tpl_vars['parameters']['count_records'];  echo ' Listing';  if ($this->_tpl_vars['parameters']['count_records'] > 1):  echo 's';  endif;  echo '</span></div></div><div class="right"><div class="btn gridview"><img class="svg-icon-inject" src="/images/icons/icon-grid-view.svg" alt="Grid View" title="Grid View"/></div><div class="btn listview active"><img class="svg-icon-inject" src="/images/icons/btn-grid.svg" alt="Listview View" title="Listview View"/></div></div></div><div class="module-search-listing"><div class="content"><div class="listing-1 balancer listview">';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auctions_list.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</div></div></div>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/popup_auction_bid_buy.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '<div class="one-col-structure">';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/main/site_bottom.tpl", 'smarty_include_vars' => array('skip_html_bottom' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</div></div></div></div></div></div></div></main></div></body></html>'; ?>
