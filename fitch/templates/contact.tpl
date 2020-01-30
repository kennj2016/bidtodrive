{strip}
{include file="includes/main/site_top.tpl"}
	
	<div class="row no-gutters bg-image full-height overflow" {if $parameters.settings->hero_image}style="background-image:url(/site_media/{$parameters.settings->hero_image}/);"{/if}>
		<div class="container full-height">
			<div class="col-24 full-height">
				<div class="module-hero-contact">
					<div class="right-bar"></div>
					<div class="content">
						<div class="left">
							<div class="holder">
								{if $parameters.settings->title}<h3 class="title">{$parameters.settings->title|escape}</h3>{/if}
								{if $parameters.settings->subtitle}<p>{$parameters.settings->subtitle|escape}</p>{/if}
								{if $parameters.settings->address != "" && $parameters.settings->city != "" && $parameters.settings->state != "" && $parameters.settings->zip != ""}
									<address class="address">
										<div class="ico">
											<img class="svg-icon-inject" src="/images/icons/icon-location.svg" alt="location" title="location"/>
										</div>
										<div class="text">
											{if $parameters.settings->address}{$parameters.settings->address} <br/>{/if}
											{if $parameters.settings->city}{$parameters.settings->city}{/if}{if $parameters.settings->state}, {$parameters.settings->state}{/if} {$parameters.settings->zip}
										</div>
									</address>
								{/if}
								{if $parameters.settings->phone}
									<div class="tel">
										<div class="ico">
											<img class="svg-icon-inject" src="/images/icons/icon-phone.svg" alt="phone" title="phone"/>
										</div>
										<a href="tel: {$parameters.settings->phone}" title="{$parameters.settings->phone}">{$parameters.settings->phone}</a>
									</div>
								{/if}
								<h6 class="subtitle">Connect with us!</h6>
								<ul class="social">
									{if $page->siteVar("facebook_url")}<li><a href="{$page->siteVar("facebook_url")}" target="_blank" title="facebook"><img class="svg-icon-inject" src="/images/icons/icon-facebook.svg" alt="facebook" title="facebook" /></a></li>{/if}
									{if $page->siteVar("instagram_url")}<li><a href="{$page->siteVar("instagram_url")}" target="_blank" title="instagram"><img class="svg-icon-inject" src="/images/icons/icon-instagram-light.png" alt="instagram" title="instagram" /></a></li>{/if}
									{if $page->siteVar("youtube_url")}<li><a href="{$page->siteVar("youtube_url")}" target="_blank" title="youtube"><img class="svg-icon-inject" src="/images/icons/icon-youtube.svg" alt="youtube" title="youtube" /></a></li>{/if}
								</ul>
							</div>
						</div>
						<div class="right">
							<div class="holder" id="contact-form-wrap">
								<form action="#" class="form" id="contact-form">
									<div class="field-block-1">
										<div class="block-1">
											{if $parameters.settings->form_intro}<p>{$parameters.settings->form_intro}</p>{/if}
										</div>
										<div class="block-2 block-2-name">
											<input type="text" class="text" placeholder="Name" name="name" />
										</div>
										<div class="block-2 block-2-email">
											<input type="email" class="text" placeholder="Email" name="email" />
										</div>
										{assign var=reasons value=$page->getAllContactReasons()}
										{if $reasons}
											<div class="block-1">
												<select name="contact_reason">
													<option value="">Reason for Contacting Us</option>
													{foreach from=$reasons item=item}
														<option value="{$item->title}">{$item->title}</option>
													{/foreach}
												</select>
											</div>
										{/if}
										<div class="block-1 block-1-message">
											<textarea cols="" rows="" placeholder="Message..." name="message"></textarea>
										</div>
										<div class="block-1 flex-v-right">
											<input type="submit" class="submit btn-2 black" value="Submit" />
										</div>
									</div>
								</form>
							</div>
							<div id="contact-form-thank" style="display:none;">
								<h2 class="header-title">Thank You!</h2>
								<h2 class="header-title">Your message was submitted successfully.</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

{include file="includes/main/site_bottom.tpl"}
{/strip}