{strip}
	{include file="includes/main/site_top.tpl"}
	{if $smarty.request.action == "verify" || $smarty.request.action == "admin-verify"}

		{include file="includes/main/popup_verify.tpl"}

	{else}
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
									<h3 class="title">BID TO DRIVE</h3>
									<p class="subtitle">Bid on cars from across the country remotely. </p>
									<p>{$parameters.page->left_description|escape}</p>
								</div>
							</div>
							<div class="right">
								<div class="holder">
									<div id="buyer-ragistration-form-thank" style="display: none;" class="ragistration-form-thank">{$parameters.page->buyer_registration_confirmation_message|escape}</div>
									<div id="seller-ragistration-form-thank" style="display: none;" class="ragistration-form-thank">{$parameters.page->seller_registration_confirmation_message|escape}</div>
									<div class="module-tab-2 break skin-1-alt color-1" id="registration-wrap">
										<div class="content">
											<div class="tab-index">
												<div class="list">
													<a style="background:#fff;color:#0650cb" class="item fake-tab" href="/register/" title="Login">register</a>

												</div>
											</div>
											<div class="tab-content">
												<div class="tab-item active">
													<div class="box-pad">
														<h3 class="tab-title-mobile">register</h3>
														<p>{$parameters.page->register_intro|escape}</p>
														<br/>
														<div class="module-tab-3">
															<div class="content">
																<div class="tab-index">
																	<div class="list">
																		<a class="item fake-tab-inner {if $parameters.subaction != "buyer_tab"}active{/if}" href="javascript:void(0);" id="seller-tab-btn" title="seller"><span>seller</span></a>
																		<a class="item fake-tab-inner {if $parameters.subaction == "buyer_tab"}active{/if}" href="javascript:void(0);" id="buyer-tab-btn" title="buyer"><span>buyer</span></a>
																	</div>
																</div>
																<div class="tab-content">
																	<div class="tab-item active">

																		<div id="seller-tab" {if $parameters.subaction == "buyer_tab"}style="display: none;"{/if}>
																			<h3 class="tab-title-mobile">buyer</h3>
																			<div id="seller-registration-form-err-msg" style="display: none;"></div>
																			<form class="form" action="#" method="POST" id="seller-registration-form" enctype="multipart/form-data" autocomplete="off">
																				<p class="registration-step-number">Step 1</p>
																				<input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
																				<input style="opacity: 0;position: absolute;" type="email" name="fakeemailremembered">
																				<input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
																				<input type="hidden" name="action" value="seller-registration" />
																				<div class="field-block-1">
																					<div class="block-1">
																						<input type="text" class="text" placeholder="Dealership Name" name="seller_name"/>
																					</div>
																					<div class="block-1">
																						<input type="email" name="seller_email" value="" style="display: none" />
																						<input type="email" class="text" placeholder="Email" name="seller_email"/>
																						<input type="email" name="not-an-email" value="" style="display: none" />
																					</div>
																					<div class="block-1">
																						<input required type="text" class="text" placeholder="Address" name="address"/>
																					</div>
																					<div class="block-1">
																						<input type="text" class="text" placeholder="Discount Code" name="discount_code"/>
																					</div>
																					<div class="block-2">
																						<input type="tel" class="text" placeholder="Zip Code" name="zip"/>
																					</div>
																					<div class="block-2">
																						<input type="tel" class="text phone_mask" placeholder="Mobile Phone" name="mobile_number"/>
																					</div>
																					<div class="block-2">
																						<input type="password" class="text" placeholder="Password" name="seller_password"/>
																					</div>
																					<div class="block-2">
																						<input type="password" class="text" placeholder="Verify Password" name="seller_verify_password"/>
																					</div>
																					<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" class="submit btn-2 black" id="seller-tab-2-btn" title="Seller Verification">Next: Seller Verification</a>
																					</div>
																				</div>
																			</form>
																				</div>
																		<div id="seller-tab-2" style="display: none;">
																			<h3 class="tab-title-mobile">buyer</h3>
																			<form class="form" action="#" method="POST" id="veifying-type">
																				<div id="veifying-type-form-err-msg" style="display: none;"></div>
																				<p class="registration-step-number registration-step-number-2">Step 2</p>
																				<input type="hidden" name="action" value="seller-confirmation" />
																				<input type="hidden" name="type" value="dealer" />
																				<div class="field-block-1">
																					<div id="seller-dealer-tab" style="display: none;">
																						<div class="block-1">
																							<label>Dealer License Information</label>
																							<input type="text" class="text" placeholder="Issued to" name="dealers_license_issued_to" />
																						</div>
																						<div class="block-1">
																							<select name="dealers_license_state" class="text" placeholder="State">
																								<option value="">State</option>
																								{if $parameters.states}
																									{foreach from=$parameters.states item=item}
																										<option value="{$item->abbr}">{$item->name}</option>
																									{/foreach}
																								{/if}
																							</select>
																						</div>
																						<div class="block-1">
																							<input type="tel" class="text" placeholder="License Number" name="dealers_license_number" />
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Issue Date" name="dealers_license_issue_date" />
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Expiration Date" name="dealers_license_expiration_date" />
																						</div>
																						<div class="block-1">
																							<label>Please attach a scanned (or photographed) copy of your Dealer License:</label>
																							<div class="module-uploader skin-1 color-1">
																								<span class="fileUpload btn btn-default skin-2 fileUploadSeller">
																										<span>Choose File</span>
																										<input type="file" class="uploadFile"/>
																								</span>
																								<div class="list-group files"></div>
																								<script class="fileUploadProgressTemplate" type="text/x-jquery-tmpl">
																									{literal}
																										<div class="list-group-item">
																											<div class="progress progress-striped active">
																												<div class="progress-bar progress-bar-info" style="width: 0%;"></div>
																											</div>
																										</div>
																									{/literal}
																								</script>
																								<script class="fileUploadItemTemplate" type="text/x-jquery-tmpl">

																										<div class="list-group-item">
																											<div class="holder">
																												<div class="name">
																													{literal}<span>${file_name}</span>{/literal}
																												</div>
																												<div>
																													<button type="button" class="preview popup" data-file_id="{literal}${file}{/literal}">
																														<span class="icon">
																															<img class="svg-icon-inject" src="/images/icons/icon-file.svg" alt="{literal}${file}{/literal}" title="{literal}${file}{/literal}" />
																														</span>
																													</button>
																													<button type="button" class="closed">&times;</button>
																													<input type="hidden" name="dealers_license_photo" value="{literal}${file}{/literal}">
																												</div>
																											</div>
																										</div>

																								</script>
																							</div>
																						</div>
																					</div>
																					<div class="block-2">
																						<input id="chk1" type="checkbox" name="seller_terms"/>
																						<label class="check-label long check-label-agree" for="chk1">
																							<div>By registering, I am agreeing to the Bid to Drive <a class="login-terms-conditions" href="/terms-conditions/" title="Terms & Conditions">Terms & Conditions</a>.</div>
																						</label>
																					</div>
																					<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" id="seller-registration-form-submit" class="submit btn-2 black" title="Complete Registration">Complete Registration</a>
																					</div>
																				</div>
																			</form>
																		</div>

																		<div id="buyer-tab" {if $parameters.subaction != "buyer_tab"}style="display: none;"{/if}>
																			<h3 class="tab-title-mobile">buyer</h3>
																			<div id="buyer-registration-form-err-msg" style="display: none;"></div>
																			<form action="#" method="POST" class="form" id="buyer-registration-form" autocomplete="off">
																				<p class="registration-step-number">Step 1</p>
																				<input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
																				<input style="opacity: 0;position: absolute;" type="email" name="fakeemailremembered">
																				<input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
																				<input type="hidden" name="action" value="buyer-registration" />
																				<div class="field-block-1">
																					<div class="block-1">
																						<p>Verify if you're a Individual or a dealer.</p>
																					</div>
																					<div class="block-2 block-2-individual">
																						<input id="chk13" type="radio" checked name="type" value="individual"/>
																						<label for="chk13">
																							Individual
																							<a href="javascript:void(0);" class="" id="buyer-individual-btn" title="Individual"></a>
																						</label>
																					</div>
																					<div class="block-2 block-2-dealer">
																						<input id="chk14" type="radio" name="type" value="dealer"/>
																						<label for="chk14">
																							Dealer
																							<a href="javascript:void(0);" class="" id="buyer-dealer-btn" title="Dealer"></a>
																						</label>
																					</div>
																					<div class="block-1 block-1-name buyer-individual-name">
																						<input type="text" class="text" placeholder="Name" name="buyer_name_ind"/>
																					</div>
																					<div class="block-1 block-1-name buyer-dealer-name">
																						<input type="text" class="text" placeholder="Contact Name" name="company_name"/>
																					</div>
																					<div class="block-1 block-1-name buyer-dealer-name">
																						<input type="text" class="text" placeholder="Dealership Name" name="buyer_name"/>
																					</div>
																					<div class="block-1 block-1-email">
																						<input type="email" name="buyer_email" value="" style="display: none" />
																						<input type="email" class="text" placeholder="Email" name="buyer_email"/>
																						<input type="email" name="not-an-email" value="" style="display: none" />
																					</div>
																					<div class="block-1">
																						<input type="text" class="text" placeholder="Address" name="address"/>
																					</div>
																					<div class="block-2">
																						<input type="tel" class="text" placeholder="Zip Code" name="zip"/>
																					</div>
																					<div class="block-2">
																						<input type="tel" class="text phone_mask" placeholder="Mobile Phone" name="mobile_number"/>
																					</div>
																					<div class="block-2 block-2-password">
																						<input type="password" class="text" placeholder="Password" name="buyer_password"/>
																					</div>
																					<div class="block-2 block-2-confirm-password">
																						<input type="password" class="text" placeholder="Verify Password" name="buyer_verify_password"/>
																					</div>
																					<div class="block-1">
																						<input type="text" class="text" placeholder="Discount Code" name="discount_code"/>
																					</div>
																					<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" class="submit btn-2 black" id="buyer-tab-2-btn" title="Verify account type">Next <em>:</em> <span> verify account type</span></a>
																					</div>
																				</div>
																			</form>
																		</div>
																		<div id="buyer-tab-2" style="display: none;">
																			<h3 class="tab-title-mobile">seller</h3>
																			<form class="form" action="#" method="POST" id="veifying-type-buyer">
																				<div id="veifying-type-form-err-msg-buyer" style="display: none;"></div>
																				<p class="registration-step-number">Step 2</p>
																				<input type="hidden" name="action" value="buyer-verifying-type" />
																				<div class="field-block-1">
																					<div id="buyer-individual-tab">
																						<div class="block-1">
																							<label>Driver's License Information</label>
																							<input type="tel" class="text" placeholder="DL Number" name="individual_dl_number"/>
																						</div>
																						<div class="block-1 block-1-individual-state">
																							<select name="individual_state" class="text" placeholder="State">
																								<option value="">State</option>
																								{if $parameters.states}
																									{foreach from=$parameters.states item=item}
																										<option value="{$item->abbr}">{$item->name}</option>
																									{/foreach}
																								{/if}
																							</select>
																						</div>
																						<div class="block-1">
																							<input type="tel"  class="text date_mask" placeholder="Date of Birth" name="individual_date_of_birth"/>
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Issue Date" name="individual_issure_date"/>
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Expiration Date" name="individual_expiration_date"/>
																						</div>
																						<div class="block-1">
																							<label>Please attach a scanned (or photographed) copy of your Driver's License:</label>
																							<div class="module-uploader skin-1 color-1">
																								<span class="fileUpload btn btn-default skin-2 fileUploadIndividual">
																									<span>Choose File</span>
																									<input type="file" id="drivers_license_photo" class="uploadFile" />
																								</span>
																								<div class="list-group files"></div>
																								<script class="fileUplo adProgressTemplate" type="text/x-jquery-tmpl">
																									{literal}
																										<div class="list-group-item">
																											<div class="progress progress-striped active">
																													<div class="progress-bar progress-bar-info" style="width: 0%;"></div>
																											</div>
																										</div>
																									{/literal}
																								</script>
																								<script class="fileUploadItemTemplate" type="text/x-jquery-tmpl">

																										<div class="list-group-item">
																											<div class="holder">
																												<div class="name">
																													{literal}<span>${file_name}</span>{/literal}
																												</div>
																												<div>
																													<button type="button" class="preview popup" data-file_id="{literal}${file}{/literal}">
																														<span class="icon">
																															<img class="svg-icon-inject" src="/images/icons/icon-file.svg" alt="{literal}${file}{/literal}" title="{literal}${file}{/literal}" />
																														</span>
																													</button>
																													<button type="button" class="closed">&times;</button>
																													<input type="hidden" name="drivers_license_photo" value="{literal}${file}{/literal}">
																												</div>
																											</div>
																										</div>
																								</script>
																							</div>
																						</div>
																					</div>
																					<div id="buyer-dealer-tab" style="display: none;">
																						<div class="block-1">
																							<label>Dealer License Information</label>
																							<input type="text" class="text" placeholder="Issued to" name="dealers_license_issued_to" />
																						</div>
																						<div class="block-1 block-1-dealers-state">
																							<select name="dealers_license_state" class="text" placeholder="State">
																								<option value="">State</option>
																								{if $parameters.states}
																									{foreach from=$parameters.states item=item}
																										<option value="{$item->abbr}">{$item->name}</option>
																									{/foreach}
																								{/if}
																							</select>
																						</div>
																						<div class="block-1">
																							<input type="tel" class="text" placeholder="License Number" name="dealers_license_number" />
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Issue Date" name="dealers_license_issue_date" />
																						</div>
																						<div class="block-2">
																							<input type="tel" class="text date_mask" placeholder="Expiration Date" name="dealers_license_expiration_date" />
																						</div>
																						<div class="block-1">
																							<label>Please attach a scanned (or photographed) copy of your Dealer License:</label>
																							<div class="module-uploader skin-1 color-1">
																								<span class="fileUpload btn btn-default skin-2 fileUploadDealer">
																										<span>Choose File</span>
																										<input type="file" class="uploadFile"/>
																								</span>
																								<div class="list-group files"></div>
																								<script class="fileUploadProgressTemplate" type="text/x-jquery-tmpl">
																									{literal}
																										<div class="list-group-item">
																											<div class="progress progress-striped active">
																												<div class="progress-bar progress-bar-info" style="width: 0%;"></div>
																											</div>
																										</div>
																									{/literal}
																								</script>
																								<script class="fileUploadItemTemplate" type="text/x-jquery-tmpl">

																										<div class="list-group-item">
																											<div class="holder">
																												<div class="name">
																													{literal}<span>${file_name}</span>{/literal}
																												</div>
																												<div>
																													<button type="button" class="preview popup" data-file_id="{literal}${file}{/literal}">
																														<span class="icon">
																															<img class="svg-icon-inject" src="/images/icons/icon-file.svg" alt="{literal}${file}{/literal}" title="{literal}${file}{/literal}" />
																														</span>
																													</button>
																													<button type="button" class="closed">&times;</button>
																													<input type="hidden" name="dealers_license_photo" value="{literal}${file}{/literal}">
																												</div>
																											</div>
																										</div>

																								</script>
																							</div>
																						</div>
																					</div>
																					<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" class="submit btn-2 black" id="credit-card-information-btn" title="Next Step">Next<em>:</em> <span> credit card information</span></a>
																					</div>
																				</div>
																			</form>
																		</div>
																		<form action="#" class="form" id="credit-card-information-tab" style="display: none;">
																			<p class="registration-step-number">Step 3</p>
																			<label>You must store credit card information on this site in order to make a bid, but you can skip for now if you don't have it handy.</label>
																			<input type="hidden" name="action" value="credit-card-info" />
																			<div id="complete-registration-err" style="display: none;"></div>
																			<div class="field-block-1">
																				<div class="block-1">
																					<input type="text" class="text" placeholder="Name as it appears on card" name="card_name"/>
																					<input type="hidden" name="stripe_id" value=""/>
																				</div>
																				<div class="block-1">
																					<input type="tel" class="text" placeholder="Card Number" name="card_number"/>
																				</div>
																				<div class="block-3 block-3-until-mob">
																					<select id="dealer_card_month" name="card_month" class="text" placeholder="Month">
																						<option value=""></option>
																						<option value="01">January</option>
																						<option value="02">February</option>
																						<option value="03">March</option>
																						<option value="04">April</option>
																						<option value="05">May</option>
																						<option value="06">June</option>
																						<option value="07">July</option>
																						<option value="08">August</option>
																						<option value="09">September</option>
																						<option value="10">October</option>
																						<option value="11">November</option>
																						<option value="12">December</option>
																				</select>
																				</div>
																				<div class="block-3 block-3-until-mob">
																					<select id="dealer_card_year" name="card_year" class="text" placeholder="Year">
																						<option value=""></option>
																						{assign var=yearStart value=$smarty.now|date_format:"%Y"}
																						{assign var=yearEnd value=`$yearStart+10`}
																						{section name=card_years start=$yearStart loop=$yearEnd step=1}
																							<option value="{$smarty.section.card_years.index}">{$smarty.section.card_years.index}</option>
																						{/section}
																				</select>
																				</div>
																				<div class="block-3 block-3-until-mob">
																					<input type="tel" class="text" placeholder="CVV" name="card_cvv"/>
																				</div>
																				<div class="block-2">
																					<input id="chk2" type="checkbox" name="buyer_terms"/>
																					<label class="check-label long check-label-agree" for="chk2">
																						<div>By registering, I am agreeing to the Bid to Drive <a class="login-terms-conditions" href="/terms-conditions/" title="Terms & Conditions">Terms & Conditions</a>.</div>
																					</label>
																				</div>
																				<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" class="submit btn-2 black" id="complete-registration" title="COMPLETE REGISTRATION">COMPLETE REGISTRATION</a>
																				</div>
																				<div class="block-1 flex-v-right">
																						<a href="javascript:void(0);" class="submit btn-2 black" id="complete-registration-2" title="SKIP & COMPLETE REGISTRATION">SKIP & COMPLETE REGISTRATION</a>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{include file="includes/main/popup_file_upload.tpl" upload=true}

	{/if}
{include file="includes/main/site_bottom.tpl"}
{/strip}
