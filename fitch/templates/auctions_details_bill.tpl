{strip}
		{include file="includes/main/site_top.tpl"}
		<div class="row no-gutters">
				<div class="container full-width">
						<div class="col-24">
								<div class="module-bill skin-1">
										<div class="content">
												<div class="header-box">
														<div class="container">
																<div class="holder">
																		<div class="name">
																				<div>
																				<h2 class="title">Bill of Sale: Auction ID <strong>#{$parameters.auction_info->id}</strong></h2>
																				{if $parameters.logged_user_type == "Buyer"}
																						<h3 class="congratulations-buyer">Congratulations! You have successfully purchased this vehicle.</h3>
																				{else}
																						<h3 class="congratulations-buyer">Congratulations! You have successfully sold this vehicle.</h3>
																				{/if}
																			</div>
																		</div>
																		<div class="print-btn" id="print-btn" style="cursor:pointer;" media="print">
																				<div class="icon">
																						<img class="svg-icon-inject" src="/images/icons/icon-print.svg" alt="print bill of sale" title="print bill of sale"/>
																				</div>
																				<div class="text"><span>Print</span>bill of sale</div>
																		</div>
																</div>
														</div>
												</div>
												<div class="container">
														<div class="info-section">
																<div class="section-1">
																		{if $parameters.auction_info->image}
																		<ul class="ul-bill-car-2">
																				<li class="li-bill-car">
																						<a class="swipebox" href="/site_media/{$parameters.auction_info->image}/l/" data-caption="Car">
																							<div class="img-holder" style="background-image: url('/site_media/{$parameters.auction_info->image}/mdt/');background-color: #000000;">
																								<img src="/site_media/{$parameters.auction_info->image}/mdt/" alt="Car Photo" title="Car Photo"/>
																							</div>
																						</a>
																				</li>
																		</ul>
																		{else}
																			<div class="img-holder" style="background-image: url('/images/default-car-image.png') !important;">
																				<img src="/images/default-car-image.png" alt="Car Photo" title="Car Photo"/>
																			</div>
																		{/if}
																</div>
																<div class="section-2">
																		<div class="box">
																				<div class="name" style="color: #0650cb;">{$parameters.auction_info->year}
																						<strong> {$parameters.auction_info->make} {$parameters.auction_info->model}</strong>
																				</div>
																				<div class="property-list">
																						<div class="item">
																								<div class="icon">
																										<img class="svg-icon-inject" src="/images/icons/icon-vin-number.svg" alt="vin number" title="vin number"/>
																								</div>
																								<div class="text">
																										<h5 class="title">vin number</h5>
																										{$parameters.auction_info->vin_number}
																								</div>
																						</div>
																						{if $parameters.auction_info->trim}
																						<div class="item">
																								<div class="icon">
																										<img class="svg-icon-inject" src="/images/icons/icon-trim.svg" alt="trim" title="trim"/>
																								</div>
																								<div class="text">
																										<h5 class="title">trim</h5>
																										{$parameters.auction_info->trim}
																								</div>
																						</div>
																						{/if}
																						{if $parameters.auction_info->mileage}
																							<div class="item">
																									<div class="icon">
																											<img class="svg-icon-inject" src="/images/icons/icon-mileage.svg" alt="mileage" title="mileage" />
																									</div>
																									<div class="text">
																											<h5 class="title">mileage</h5>
																											{$parameters.auction_info->mileage|money_format}
																									</div>
																							</div>
																						{/if}
																						{if $parameters.auction_info->color}
																						<div class="item">
																								<div class="icon">
																										<img class="svg-icon-inject" src="/images/icons/icon-color.svg" alt="color" title="color"/>
																								</div>
																								<div class="text">
																										<h5 class="title">color</h5>
																										{$parameters.auction_info->color}
																								</div>
																						</div>
																						{/if}
																						{if $parameters.auction_info->engine}
																						<div class="item">
																								<div class="icon">
																										<img class="svg-icon-inject" src="/images/icons/icon-engine.svg" alt="engine" title="engine"/>
																								</div>
																								<div class="text">
																										<h5 class="title">engine</h5>
																										{$parameters.auction_info->engine}
																								</div>
																						</div>
																						{/if}
																				</div>
																		</div>
																</div>
																<div class="section-3">
																		<div class="info-box">
																				<span class="tip fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view profile</span>
																				<h3 class="title">Seller information</h3>
																				<div class="holder">
																						<div class="img-holder" style="background-image: url('{if $parameters.seller_info->profile_photo}/site_media/{$parameters.seller_info->profile_photo}/m/{else}/images/default-user-image.png{/if}')"></div>
																						<dl class="list">
																								{if $parameters.seller_info->name}
																										<dt>seller</dt>
																										<dd>{$parameters.seller_info->name}</dd>
																								{/if}
																								{if $parameters.seller_info->city && $parameters.seller_info->state && $parameters.seller_info->zip && $parameters.seller_info->address}
																										<dt>address</dt>
																										<dd>{if $parameters.seller_info->address}{$parameters.seller_info->address}, {/if}{$parameters.seller_info->city}{if $parameters.seller_info->state != "" || $parameters.seller_info->zip != ""}, {$parameters.seller_info->state} {$parameters.seller_info->zip}{/if}</dd>
																								{/if}
																								{if $parameters.seller_info->email}
																										<dt>email</dt>
																										<dd>{$parameters.seller_info->email}</dd>
																								{/if}
																								{if $parameters.seller_info->mobile_number != ""}
																										<dt>phone</dt>
																										<dd>{$parameters.seller_info->mobile_number}</dd>
																								{/if}
																						</dl>
																				</div>
																		</div>
																</div>
																<div class="section-4">
																		<div class="info-box">
																				<h3 class="title">Buyer information</h3>
																				<div class="holder">
																						<dl class="list">
																								<dt>buyer</dt>
																								<dd>{$parameters.buyer_info->name}</dd>
																								<dt>address</dt>
																								<dd>{if $parameters.buyer_info->address}{$parameters.buyer_info->address}, {/if}{$parameters.buyer_info->city}{if $parameters.buyer_info->state != ""},{/if} {$parameters.buyer_info->state} {$parameters.buyer_info->zip}</dd>
																								<dt>email</dt>
																								<dd>{$parameters.buyer_info->email}</dd>
																								{if $parameters.buyer_info->mobile_number != ""}
																										<dt>phone</dt>
																										<dd>{$parameters.buyer_info->mobile_number}</dd>
																								{/if}
																						</dl>
																				</div>
																		</div>
																</div>
														</div>
												</div>
												<div class="info-section-2">
														<div class="container">
																<div class="hold">
																		<div class="box-1">
																			{if $parameters.auction_info->pickup_window}
																				<div class="announce">
																						This vehicle must be picked up within <strong>{$parameters.auction_info->pickup_window} days</strong>
																				</div>
																			{/if}
																				<div class="holder">
																						<h3 class="title">pick up information</h3>
																						<dl class="list">
																							{if $parameters.auction_info->pickup_transporter}
																								<dt>Transporter</dt>
																								<dd>{$parameters.auction_info->pickup_transporter}</dd>
																							{/if}
																							{if $parameters.auction_info->pickup_address && $parameters.auction_info->pickup_city && $parameters.auction_info->pickup_state && $parameters.auction_info->pickup_zip}
																								<dt>address</dt>
																								<dd>{$parameters.auction_info->pickup_address} {$parameters.auction_info->pickup_city}{if $parameters.auction_info->pickup_state || $parameters.auction_info->pickup_zip}, {$parameters.auction_info->pickup_state} {$parameters.auction_info->pickup_zip}{/if}</dd>
																							{/if}
																								{if $parameters.auction_info->transporter_phone}
																									<dt>phone</dt>
																									<dd>{$parameters.auction_info->transporter_phone}</dd>
																								{/if}
																						</dl>
																						<dl class="list">
																							{if $parameters.auction_info->pickup_driver}
																								<dt>Pick Up Driver</dt>
																								<dd>{$parameters.auction_info->pickup_driver}</dd>
																							{/if}
																							{if $parameters.auction_info->driver_phone}
																								<dt>phone</dt>
																								<dd>{$parameters.auction_info->driver_phone}</dd>
																							{/if}
																						</dl>
																						{if $parameters.auction_info->pickup_note}
																							<p class="tip">{$parameters.auction_info->pickup_note}</p>
																						{/if}
																						<hr/>
																						<h3 class="title">Purchasing Agreement</h3>
																						<p>Buyer and seller agree that the vehicle described herein is bought and sold subject to the Auction's Terms and Conditions and Regulating Policy Guide communicated and available to the Buyer and Seller (or their Authorized Representatives).</p>
																				</div>
																		</div>
																		<div class="box-2">
																				<h3 class="title">sale information</h3>
																				<table class="info-table">
																						<tbody>
																						<tr class="">
																								<td class="termin red">Sale price owed to {$parameters.seller_info->name}</td>
																								<td class="val red">${$parameters.auction_info->price_all}</td>
																						</tr>
																						<tr class="">
																								<td class="termin red">Discount</td>
																								<td class="val red">${$parameters.auction_info->discount}</td>
																						</tr>
																						<tr class="border">
																								<td class="termin red">Total</td>
																								<td class="val red">${$parameters.auction_info->current_bid_price}</td>
																						</tr>
																						<tr class="border">
																								<td class="termin green">Buyer fee paid via card on file</td>
																								<td class="val green">${$parameters.auction_info->fee_formatted}</td>
																						</tr>
																						{if $parameters.auction_info->refund_amount != 0}
    																						<tr class="border">
    																								<td class="termin">Buyer fee credit</td>
    																								<td class="val">${$parameters.auction_info->refund_amount|money_format}</td>
    																						</tr>
																						{/if}
																						<tr class="border mark">
																								<td class="termin">Total Amount</td>
																								<td class="val">
																										<span>${$parameters.auction_info->total|money_format}</span></td>
																						</tr>
																						{if $parameters.auction_info->payment_method}
																							<tr>
																								<td class="termin">Payment Methods</td>
																								<td class="val">{$parameters.auction_info->payment_method}</td>
																							</tr>
																						{/if}
																						</tbody>
																				</table>
																		</div>
																</div>
														</div>
												</div>
												<div class="container">
														<div class="info-section alt">
																{if $parameters.auction_info->terms_conditions}
																<div class="section-3">
																		<div class="info-box">
																				<h3 class="title">Terms & Conditions</h3>
																				<div class="holder">
																						{$parameters.auction_info->terms_conditions}
																				</div>
																		</div>
																</div>
																{/if}
																{if $parameters.auction_info->additional_fees}
																<div class="section-4">
																		<div class="info-box">
																				<h3 class="title">Additional Fees</h3>
																				<div class="holder">
																						<p>{$parameters.auction_info->additional_fees}</p>
																				</div>
																		</div>
																</div>
																{/if}
														</div>
												</div>
										</div>
								</div>
						</div>
				</div>
		</div>
		{include file="includes/main/site_bottom.tpl"}
{/strip}
