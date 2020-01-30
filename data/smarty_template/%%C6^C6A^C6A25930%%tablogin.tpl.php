<?php /* Smarty version 2.6.31, created on 2020-01-21 03:36:52
         compiled from includes/main/tablogin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'includes/main/tablogin.tpl', 8, false),)), $this); ?>
<div class="box-pad" id="tab-login">
    <h3 class="tab-title-mobile">login</h3>
    <form action="" method="POST" class="form" id="login-form" autocomplete="off">
        <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
        <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
        <div class="field-block-1">
            <div class="block-1">
                <p><?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['page']->login_intro)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
            </div>
            <div id="login_error" style="display:none;"></div>
            <div class="block-1 block-1-name">
                <input type="text" name="username" value="" style="display: none" />
                <input type="text" name="username" class="text" placeholder="Email"  />
                <input type="text" name="not-an-username" value="" style="display: none" />
            </div>
            <div class="block-1 block-1-password">
                <input type="password" class="text" placeholder="Password" name="password"/>
            </div>
            <div class="block-2 always-2">
                <input id="chk1" type="checkbox" name="remember"/>
                <label for="chk1">Remember me</label>
            </div>
            <div class="block-2 flex-h-center always-2">
                <a class="forgot" href="/forgot-password/" title="Forgot password?">Forgot password?</a>
            </div>
            <div class="block-2 flex-h-center always-2">
                <a class="forgot" href="/register/" title="Create account" style="color: #fff;">Create account</a>
            </div>
            <div class="block-1 flex-v-right">
            	<span class="login-btn-box">
                <input class="submit btn-2 black" type="submit" value="Login" />
              </span>
            </div>
        </div>
    </form>
</div>
