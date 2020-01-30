{strip}
	{include file="includes/admin/site_top.tpl"}

	<script	type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
	<script	type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
	<script	type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

	<form	class="validate" action="" method="post">
		<div class="section">

			<div class="section-title-box">
				<a href="/admin/auctions/" class="button1">cancel</a>
				{include file="includes/admin/revisions_action.tpl"}
			</div>

			<div class="section">
				<div class="section-title-box">
					<h3>
						Status
					</h3>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							active
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="status">
								<option	value="0">No</option>
								<option	value="1"{if $parameters.record->status} selected="selected"{/if}>Yes</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class="section">
				<div class="section-title-box">
					<h3>
						Main Info
					</h3>
				</div>
				<!-- Title -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="title"	name="title" value="{$parameters.record->title|escape}"/>
						</div>
					</div>
				</div>
				<!-- Vin Number	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							vin	number<span	class="text-red">	*</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="vin number" name="vin_number" value="{$parameters.record->vin_number|escape}"/>
						</div>
					</div>
				</div>
				<!-- Auction	Length (in days)	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Auction	Length<span	class="text-red">	*</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="auctions_length">
							    <option	value="60"	{if	$parameters.record->auctions_length	== 60}	selected="selected"{/if} >1 Hour</option>
								<option	value="1"	{if	$parameters.record->auctions_length	== 1}	selected="selected"{/if} >1 Day</option>
								<option	value="3"	{if	$parameters.record->auctions_length	== 3}	selected="selected"{/if} >3 Days</option>
								<option	value="5"	{if	$parameters.record->auctions_length	== 5}	selected="selected"{/if} >5 Days</option>
							</select>
						</div>
					</div>
				</div>
				<!-- Seller Who Created Auction -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							seller<span	class="text-red">	*</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="user_id">
								<option	value="0">select</option>
								{if	$parameters.users}
									{foreach from=$parameters.users	item=item}
										<option	value="{$item->id}"{if $parameters.record->user_id ==	$item->id} selected="selected"{/if}>{$item->name|escape}</option>
									{/foreach}
								{/if}
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class="section">
				<div class="section-title-box">
					<h3>
						Vin Specs
					</h3>
				</div>
				<!-- Make	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							make
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="make" name="make" value="{$parameters.record->make|escape}"/>
						</div>
					</div>
				</div>
				<!-- Model -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							model
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="model"	name="model" value="{$parameters.record->model|escape}"/>
						</div>
					</div>
				</div>
				<!-- Year	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							year
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="year" name="year" value="{$parameters.record->year|escape}"/>
						</div>
					</div>
				</div>
				<!-- Engine	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							engine
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="engine" name="engine" value="{$parameters.record->engine|escape}"/>
						</div>
					</div>
				</div>
				<!-- Number	Of Cylinders -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							number of	cylinders
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="number	of cylinders"	name="number_of_cylinders" value="{$parameters.record->number_of_cylinders}"/>
						</div>
					</div>
				</div>
				<!-- Number	Of Doors -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							number of	doors
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="number	of doors"	name="number_of_doors" value="{$parameters.record->number_of_doors}"/>
						</div>
					</div>
				</div>
				<!-- Trim	-->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Trim
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="Trim" name="trim" value="{$parameters.record->trim}"/>
						</div>
					</div>
				</div>
				<!-- Trim2 -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Trim2
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="Trim2"	name="trim2" value="{$parameters.record->trim2}"/>
						</div>
					</div>
				</div>
				<!-- Fuel Type -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							fuel type
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="fuel_type">
								<option	value="">select</option>
								{foreach name=fuel_types	from=$web_config.fuel_types key=key item=fuelType}
									<option	value="{$key}"{if $key ==	$parameters.record->fuel_type}	selected="selected"{/if}>{$fuelType}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class="section">
				<div class="section-title-box">
					<h3>
						More Specs
					</h3>
				</div>
				<!-- Exterior Color -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							exterior color
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="color">
								<option	value="">Select	a	color</option>
								{foreach from=$parameters.colors key=key item=item}
									<option	value="{$item}"	{if	$parameters.record->color	== $item}	selected="selected"{/if} >{$item}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Interior Color -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							interior color
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="interior_color">
								<option	value="">Select	a	color</option>
								{foreach from=$parameters.interior_colors	key=key	item=item}
									<option	value="{$item}"	{if	$parameters.record->interior_color ==	$item} selected="selected"{/if}	>{$item}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Condition -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							condition
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="auction_condition">
								<option	value="">Select	a	condition</option>
								{foreach from=$parameters.conditions item=item key=key }
									<option	value="{$item}"	{if	$parameters.record->auction_condition	== $item}	selected="selected"{/if} >{$item}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Mileage -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							mileage<span class="text-red"> *</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="number" class="input-text"	placeholder="mileage"	name="mileage" value="{$parameters.record->mileage|escape}"/>
						</div>
					</div>
				</div>
				<!-- Title Status -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							title	status
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="title_status">
								{foreach from=$parameters.title_statuses item=item key=key }
									<option	value="{$item}"	{if	$parameters.record->title_status ==	$item} selected="selected"{/if}	>{$item}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Title Wait Time -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							title	wait time
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="title_wait_time">
								<option	value="">Select	a	title	wait time</option>
								{foreach from=$parameters.title_wait_times item=item key=key }
									<option	value="{$item}"	{if	$parameters.record->title_wait_time	== $item}	selected="selected"{/if} >{$item}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Transmission -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Transmission
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<div class="input-text">
								<div class="input-checkname-holder">
									<label>
										<input name="transmission" type="radio"	value="Automatic"{if $parameters.record->transmission	== "Automatic"}	checked="checked"{/if} />
										Automatic
									</label>
									<label>
										<input name="transmission" type="radio"	value="Manual"{if	$parameters.record->transmission ==	"Manual"}	checked="checked"{/if} />
										Manual
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Sell to Dealers Only? -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Sell to	Dealers	Only?
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="sell_to">
								<option	value="2"{if $parameters.record->sell_to ==	2} selected="selected"{/if}>Anyone</option>
								<option	value="1"{if $parameters.record->sell_to ==	1} selected="selected"{/if}>Dealers	Only</option>
							</select>
						</div>
					</div>
				</div>
				<!-- Drive Type -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							drive	type
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="drive_type">
								<option	value="">select</option>
								{foreach name=drive_types	from=$web_config.drive_types key=key item=driveType}
									<option	value="{$key}"{if	$key ==	$parameters.record->drive_type}	selected="selected"{/if}>{$driveType}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<!-- Description -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							description
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea	class="input-text	ckeditor"	placeholder="description"	name="description">{$parameters.record->description|escape}</textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div class="section">
				<div class="section-title-box">
					<h3>
						Terms & Photos
					</h3>
				</div>
				<!-- Terms and Conditions select from your Content Blocks -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Terms and Conditions select from your Content Blocks
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="terms_condition_id">
								<option	value="0">select</option>
								{if	$parameters.terms_conditions}
									{foreach from=$parameters.terms_conditions item=item}
										<option	value="{$item->id}"{if $parameters.record->terms_condition_id	== $item->id}	selected="selected"{/if}>{$item->title|escape}</option>
									{/foreach}
								{/if}
							</select>
						</div>
					</div>
				</div>
				<!-- Write New Terms and Conditions -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Write New Terms and Conditions
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea	class="input-text	ckeditor"	placeholder="terms conditions"	name="terms_conditions">{$parameters.record->terms_conditions|escape}</textarea>
						</div>
					</div>
				</div>
				<!-- Additional Fees	select from	your Content Blocks -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Additional Fees	select from	your Content Blocks
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="additional_fees_id">
								<option	value="0">select</option>
								{if	$parameters.additional_fees}
									{foreach from=$parameters.additional_fees	item=item}
										<option	value="{$item->id}"{if $parameters.record->additional_fees_id	== $item->id}	selected="selected"{/if}>{$item->title|escape}</option>
									{/foreach}
								{/if}
							</select>
						</div>
					</div>
				</div>
				<!-- Write New Additional Fees -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Write New Additional Fees
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea	class="input-text	ckeditor"	placeholder="additional_fees"	name="additional_fees">{$parameters.record->additional_fees|escape}</textarea>
						</div>
					</div>
				</div>
				<!-- Payment Pickup -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							payment	pickup
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<select	name="payment_pickup_id">
								<option	value="0">select</option>
								{if	$parameters.payment_pickup}
									{foreach from=$parameters.payment_pickup item=item}
										<option	value="{$item->id}"{if $parameters.record->payment_pickup_id ==	$item->id} selected="selected"{/if}>{$item->title|escape}</option>
									{/foreach}
								{/if}
							</select>
						</div>
					</div>
				</div>
				<!-- Payment Method -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							payment	methods
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							{$parameters.payment_methods_field->htmlInput()}
						</div>
					</div>
				</div>
				<!-- Pickup Window -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							pickup window
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	placeholder="pickup window"	name="pickup_window" value="{$parameters.record->pickup_window}"/>
						</div>
					</div>
				</div>
				<!-- Pickup Note -->
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							pickup note
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea	class="input-text	ckeditor"	placeholder="pickup	note"	name="pickup_note">{$parameters.record->pickup_note|escape}</textarea>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Photos -->
			<div class="form-field-group">
				<div class="form-field-group-label">
					Add	Photos of	Your Car Below
				</div>
				<div class="form-field-group-content">

					<div class="form-field-repeating"	data-records="{$parameters.record->photos|escape}">
						<div class="form-field-repeating-content"></div>
						<div class="form-field-repeating-footer">
							<a class="button1	form-field-repeating-add"	href="#">Add More</a>
						</div>
						<script	type="text/html">
							<div class="form-field-repeating-item">

								<div class="form-field-repeating-item-header list-action-hover">
									<div class="left">
										<a href="#"	class="list-action action-move"></a>
										<span	class="form-field-repeating-item-title">
										<span	class="default">
											Photo	#<span class="form-field-repeating-item-position"></span>
										</span>
										<span	class="custom" rel="[name*=title]"></span>
									</span>
									</div>
									<div class="right">
										<div class="item">
											<a href="#"	class="list-action action-delete form-field-repeating-delete"></a>
										</div>
										<div class="item">
											<a href="#"	class="open"></a>
										</div>
									</div>
								</div>

								<div class="form-field-repeating-item-content">
									<div class="form-field">
										<div class="form-field-label-wrap">
											<div class="form-field-label">
												Title<span class="text-red"> *</span>
											</div>
										</div>
										<div class="form-field-input-wrap">
											<div class="form-field-input">
												<input type="text" class="input-text"	placeholder="Title"	name="photos[<%= index %>][title]" value="<%=	htmlentities(record.title) %>"/>
											</div>
										</div>
									</div>
									<div class="form-field">
										<div class="form-field-label-wrap">
											<div class="form-field-label">
												Image<span class="text-red"> *</span>
											</div>
										</div>
										<div class="form-field-input-wrap">
											<div class="form-field-input">
												<input data-site-media="auctions-images" name="photos[<%=	index	%>][photo]"	value="<%= htmlentities(record.photo)	%>"/>
											</div>
										</div>
									</div>
								</div>

							</div>
						</script>
					</div>

				</div>
			</div>

			<!-- Info (Auction Status, Prices) -->
			<div class="section">
				<div class="section-title-box">
					<h3>
						Auction Status & Prices
					</h3>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Auction	status
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text"	readonly name="auction_status" value="{$parameters.record->auction_status}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Minimum	Bid
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" {if $parameters.record->id != ""}readonly{/if}	name="starting_bid_price"	value="${$parameters.record->starting_bid_price|money_format}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Buy	Price
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" {if $parameters.record->id != ""}readonly{/if}	name="buy_now_price" value="${$parameters.record->buy_now_price|money_format}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Reserve	Price
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" {if $parameters.record->id != ""}readonly{/if} name="reserve_price" value="${$parameters.record->reserve_price|money_format}"/>
						</div>
					</div>
				</div>
				{if	$parameters.record->winning_bid	!= 0}
					<div class="form-field">
						<div class="form-field-label-wrap">
							<div class="form-field-label">
								Winning	Bid
							</div>
						</div>
						<div class="form-field-input-wrap">
							<div class="form-field-input">
								<input type="text" class="input-text"	 readonly	value="${$parameters.record->winning_bid|money_format}"/>
							</div>
						</div>
					</div>
				{/if}
				{if	$parameters.record->buyer_name !=	""}
					<div class="form-field">
						<div class="form-field-label-wrap">
							<div class="form-field-label">
								Buyer
							</div>
						</div>
						<div class="form-field-input-wrap">
							<div class="form-field-input">
								<input type="text" class="input-text"	 readonly	 value="{$parameters.record->buyer_name}"/>
							</div>
						</div>
					</div>
				{/if}
			</div>

			{include file="includes/admin/admin_creators.tpl"}

		</div>
	</form>

	{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

	{include file="includes/admin/site_bottom.tpl"}
{/strip}