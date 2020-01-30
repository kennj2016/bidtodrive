<?php /* Smarty version 2.6.31, created on 2020-01-21 04:05:31
         compiled from includes/main/account_listings.tpl */ ?>
<div id="seller-my-listing" class="page active" <?php if ($this->_tpl_vars['parameters']['action'] == 'edit_auction' || $this->_tpl_vars['parameters']['action'] == 'relist_auction' || $this->_tpl_vars['parameters']['action'] == 'create_auction' || $this->_tpl_vars['parameters']['action'] == 'account_content_blocks' || $this->_tpl_vars['parameters']['action'] == 'account_info'): ?>style="display:none;"<?php endif; ?>>
	<h4 class="head-title button-add">
		<div class="ico">
			<img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="my watched listing" title="my watched listing"/>
		</div>
		<span>My listings</span>
		<form id="seller-watched-listings-sort" class="drop-filters">
		    <input type="hidden" id="auction_status_filter" name="auction_status" value="">
			<div id="sort-dropdown">
				<select name="sort" class="select-3" id="sort-filter">
					<option value="">Sort By</option>
					<option value="1" <?php if ($_REQUEST['sort'] == '1'): ?>selected=""<?php endif; ?>>
						Auction End Time (Closest)
					</option>
					<option value="2" <?php if ($_REQUEST['sort'] == '2'): ?>selected=""<?php endif; ?>>
						Distance (Closest)
					</option>
					<option value="3" <?php if ($_REQUEST['sort'] == '3'): ?>selected=""<?php endif; ?>>
						Mileage (Low to High)
					</option>
					<option value="4" <?php if ($_REQUEST['sort'] == '4'): ?>selected=""<?php endif; ?>>
						Mileage (High to Low)
					</option>
					<option value="5" <?php if ($_REQUEST['sort'] == '5'): ?>selected=""<?php endif; ?>>
						Vehicle Year (Most Recent)
					</option>
					<option value="6" <?php if ($_REQUEST['sort'] == '6'): ?>selected=""<?php endif; ?>>
						Vehicle Year (Oldest)
					</option>
					<option value="7" <?php if ($_REQUEST['sort'] == '7'): ?>selected=""<?php endif; ?>>
						Price (Low to High)
					</option>
					<option value="8" <?php if ($_REQUEST['sort'] == '8'): ?>selected=""<?php endif; ?>>
						Price (High to Low)
					</option>
				</select>
			</div>
		</form>
	</h4>
	<?php if ($this->_tpl_vars['parameters']['auctions_statuses']): ?>
		<div class="top-controll-panel" style="border-top:none;">
			<div class="left">
				<div class="result-detail">
				    <form id="auctions-statuses-form">
    					<div id="auctions-statuses-filter">
    					    <input type="hidden" id="auction_status" name="auction_status" value="">
							<a title="total" href="javascript:void(0);" data-auction-status-filter="total" data-auction-status-count="<?php echo $this->_tpl_vars['parameters']['auctionsStatusesTotal']; ?>
">Total: <?php echo $this->_tpl_vars['parameters']['auctionsStatusesTotal']; ?>
</a> |
							<?php echo $this->_tpl_vars['countSold']; ?>

    						<?php $_from = $this->_tpl_vars['parameters']['auctions_statuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['statuses'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['statuses']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['status'] => $this->_tpl_vars['count']):
        $this->_foreach['statuses']['iteration']++;
?>
    							<a title="<?php echo $this->_tpl_vars['status']; ?>
" href="javascript:void(0);" data-auction-status-filter="<?php echo $this->_tpl_vars['status']; ?>
" data-auction-status-count="<?php echo $this->_tpl_vars['count']; ?>
"><?php echo $this->_tpl_vars['count']; ?>
 <?php if ($this->_tpl_vars['status'] == 'Canceled'): ?>Unsold<?php else:  echo $this->_tpl_vars['status'];  endif; ?></a><?php if (! ($this->_foreach['statuses']['iteration'] == $this->_foreach['statuses']['total'])): ?> | <?php endif; ?>
    						<?php endforeach; endif; unset($_from); ?>
							 <!-- | <a title="Unsold" href="javascript:void(0);" data-auction-status-filter="Unsold" data-auction-status-count="<?php echo $this->_tpl_vars['parameters']['countUnSold']; ?>
"><?php echo $this->_tpl_vars['parameters']['countUnSold']; ?>
 Unsold</a> -->
    					</div>
    				</form>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="module-search-listing" class="module-search-listing">
		<div class="content">
			<!-- <h4 class="title-action" style="margin:0px 0px 10px 10px"></h4> -->
			<div class="listing-1 balancer gridview">

				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seller_watched_auction_list.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	</div>
</div>