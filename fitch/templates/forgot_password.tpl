{strip}
{include file="includes/main/site_top.tpl"}
	
	<div class="row no-gutters bg-image full-height overflow">
		<div class="container full-height">
			<div class="col-24 full-height">
				<div class="module-login">
					<span class="tint"></span>
					<div class="honeycomb"></div>
					<div class="content">
						<div class="box-holder">
							<div class="sign"></div>
							<div class="left">
								<div class="holder">
									<h3 class="title">bid to drive</h3>
									<p class="subtitle">Bid on cars from across thecountry remotely. </p>
									<p>{$parameters.page->forgot_password_intro}</p>
								</div>
							</div>
							<div class="right">
								<div class="holder">
									<div id="forgot_password_success" style="display: none;"><h2 style="color: #ffffff;">A link to update your password has been sent to your email.</h2></div>
									<div class="module-tab-2 break skin-1-alt color-1"  id="forgot-pass">
										<div class="content">
											<div class="box-pad">
												<h1 class="subtitle">Forgot Password</h1>
												<div id="forgot_password_error"></div>
												<form action="forgot" method="POST" class="form" id="forgot-pass-form">
													<div class="field-block-1">
														<div class="block-1">
															<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquid aspernatur eligendi enim fuga illo.</p>
														</div>
														<div id="forgot-err-box"></div>
														<div class="block-1 block-1-email">
															<input type="email" class="text" placeholder="Email Address" name="forgot_email"/>
														</div>
														<div class="block-1 flex-v-right">
															<button class="submit btn-2 black">Reset my password</button>
														</div>
														<div class="block-2 flex-h-center">
														<span class="remember">
															<span>Just Remembered? </span><a class="colorfix" href="/login/" title="Login">Login</a>
														</span>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
{include file="includes/main/site_bottom.tpl"}
{/strip}