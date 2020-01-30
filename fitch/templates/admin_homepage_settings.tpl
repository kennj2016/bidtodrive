{strip}
{include file="includes/admin/site_top.tpl"}

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/" class="button1">cancel</a>
			{include file="includes/admin/revisions_action.tpl"}
		</div>
		
		<!-- Hero -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Hero
			</div>
			<div class="form-field-group-content">			
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Title" name="hero_title" value="{$parameters.record->hero_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Subtitle
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea type="text" class="input-text" placeholder="Subtitle" name="hero_subtitle">{$parameters.record->hero_subtitle}</textarea>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Image
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="hero-images" name="hero_image" value="{$parameters.record->hero_image}"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Buyer Sign Up CTA -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Buyer Sign Up CTA
			</div>
			<div class="form-field-group-content">			
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Title" name="buyer_cta_title" value="{$parameters.record->buyer_cta_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Subtitle
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea type="text" class="input-text" placeholder="Subtitle" name="buyer_cta_subtitle">{$parameters.record->buyer_cta_subtitle}</textarea>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Background Image
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="homepage-images" name="buyer_cta_background_image" value="{$parameters.record->buyer_cta_background_image}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Icon
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="svg-icons" name="buyer_cta_icon" value="{$parameters.record->buyer_cta_icon}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Button Text
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="button text" name="buyer_cta_button_text" value="{$parameters.record->buyer_cta_button_text|escape}" />
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Seller Sign Up CTA -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Seller Sign Up CTA
			</div>
			<div class="form-field-group-content">			
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Title" name="seller_cta_title" value="{$parameters.record->seller_cta_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Subtitle
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea type="text" class="input-text" placeholder="Subtitle" name="seller_cta_subtitle">{$parameters.record->seller_cta_subtitle}</textarea>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Background Image
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="homepage-images" name="seller_cta_background_image" value="{$parameters.record->seller_cta_background_image}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Icon
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="svg-icons" name="seller_cta_icon" value="{$parameters.record->seller_cta_icon}"/>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Button Text
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="button text" name="seller_cta_button_text" value="{$parameters.record->seller_cta_button_text|escape}" />
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				How It Works
			</div>
			<div class="form-field-group-content">
				<div class="form-field-repeating" data-records="{$parameters.record->repeating_fieldgroups|escape}">
					<div class="form-field-repeating-content"></div>
					<div class="form-field-repeating-footer">
						<a class="button1 form-field-repeating-add" href="#">Add More</a>
					</div>
					<script type="text/html">
						<div class="form-field-repeating-item">

							<div class="form-field-repeating-item-header list-action-hover">
								<div class="left">
									<a href="javascript:void(0);" class="list-action action-move"></a>
									<span class="form-field-repeating-item-title">
										<span class="default">
											Step #<span class="form-field-repeating-item-position"></span>
										</span>
										<span class="custom" rel="[name*=title]"></span>
									</span>
								</div>
								<div class="right">
									<div class="item">
										<a href="#" class="list-action action-delete form-field-repeating-delete"></a>
									</div>
									<div class="item">
										<a href="#" class="open"></a>
									</div>
								</div>
							</div>

							<div class="form-field-repeating-item-content">
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											title
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="Title" name="repeating_fieldgroups[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											subtitle
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<textarea class="input-text" placeholder="subtitle" name="repeating_fieldgroups[<%= index %>][subtitle]"><%= htmlentities(record.subtitle) %></textarea>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Background Image
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input data-site-media="homepage-images" name="repeating_fieldgroups[<%= index %>][background_image]" value="<%= htmlentities(record.background_image) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Icon
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input data-site-media="svg-icons" name="repeating_fieldgroups[<%= index %>][icon]" value="<%= htmlentities(record.icon) %>"/>
										</div>
									</div>
								</div>
							</div>

						</div>
					</script>
				</div>
			</div>
		</div>
		
		<!-- Current Auctions -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Current Auctions
			</div>
			<div class="form-field-group-content">			
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Title" name="current_auctions_title" value="{$parameters.record->current_auctions_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Subtitle
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea type="text" class="input-text" placeholder="Subtitle" name="current_auctions_subtitle">{$parameters.record->current_auctions_subtitle}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				Metadata
			</div>
			<div class="form-field-group-content">
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Meta Title
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Meta Title" name="meta_title" value="{$parameters.record->meta_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Meta Keywords
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea class="input-text" placeholder="Meta Keywords" name="meta_keywords">{$parameters.record->meta_keywords|escape}</textarea>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Meta Description
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea class="input-text" placeholder="Meta Description" name="meta_description">{$parameters.record->meta_description|escape}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/revisions.tpl" id="$parameters.record->id"}

{include file="includes/admin/site_bottom.tpl"}
{/strip}