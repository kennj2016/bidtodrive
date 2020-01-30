{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

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
		
		<!-- Intro -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Intro
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
							<input type="text" class="input-text" placeholder="Title" name="intro_title" value="{$parameters.record->intro_title|escape}" />
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
							<textarea type="text" class="input-text" placeholder="Subtitle" name="intro_subtitle">{$parameters.record->intro_subtitle}</textarea>
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
							<input data-site-media="hero-images" name="intro_image" value="{$parameters.record->intro_image}"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Key Features -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Key Features
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
							<input type="text" class="input-text" placeholder="Title" name="key_features_title" value="{$parameters.record->key_features_title|escape}" />
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
							<textarea type="text" class="input-text" placeholder="Subtitle" name="key_features_intro_text">{$parameters.record->key_features_intro_text}</textarea>
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Backgroung Image
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input data-site-media="hero-images" name="key_features_background_image" value="{$parameters.record->key_features_background_image}"/>
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-field-group">
				<div class="form-field-group-label">
					Key Features Buckets
				</div>
				<div class="form-field-group-content key-featured-buckets">
					<div class="form-field-repeating" data-records="{$parameters.record->buckets|escape}">
						<div class="form-field-repeating-content"></div>
						<div class="form-field-repeating-footer">
							<a class="button1 form-field-repeating-add" href="#">Add More</a>
						</div>
						<script type="text/html">
							<div class="form-field-repeating-item custom-bucket-item">
	
								<div class="form-field-repeating-item-header list-action-hover">
									<div class="left">
										<a href="javascript:void(0);" class="list-action action-move"></a>
										<span class="form-field-repeating-item-title">
											<span class="default">
												Bucket #<span class="form-field-repeating-item-position"></span>
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
												<input type="text" class="input-text" placeholder="Title" name="buckets[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
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
												<input type="text" class="input-text" placeholder="Subtitle" name="buckets[<%= index %>][subtitle]" value="<%= htmlentities(record.subtitle) %>"/>
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
												<input data-site-media="svg-icons" name="buckets[<%= index %>][icon]" value="<%= htmlentities(record.icon) %>"/>
											</div>
										</div>
									</div>
									<div class="form-field">
										<div class="form-field-label-wrap">
											<div class="form-field-label">
												Button text
											</div>
										</div>
										<div class="form-field-input-wrap">
											<div class="form-field-input">
												<input type="text" class="input-text" placeholder="button text" name="buckets[<%= index %>][button_text]" value="<%= htmlentities(record.button_text) %>"/>
											</div>
										</div>
									</div>
									<div class="form-field">
										<div class="form-field-label-wrap">
											<div class="form-field-label">
												Button url
											</div>
										</div>
										<div class="form-field-input-wrap">
											<div class="form-field-input">
												<input type="text" class="input-text" placeholder="button url" name="buckets[<%= index %>][button_url]" value="<%= htmlentities(record.button_url) %>"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</script>
					</div>
				</div>
			</div>
		</div>
		
		<!-- How It Works -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				How It Works
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
							<input type="text" class="input-text" placeholder="Title" name="how_it_works_title" value="{$parameters.record->how_it_works_title|escape}" />
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-field-group">
				<div class="form-field-group-label">
					How It Works Steps
				</div>
				<div class="form-field-group-content how-it-works-steps">
					<div class="form-field-repeating" data-records="{$parameters.record->steps|escape}">
						<div class="form-field-repeating-content"></div>
						<div class="form-field-repeating-footer">
							<a class="button1 form-field-repeating-add" href="#">Add More</a>
						</div>
						<script type="text/html">
							<div class="form-field-repeating-item custom-step-item">
	
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
												<input type="text" class="input-text" placeholder="Title" name="steps[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
											</div>
										</div>
									</div>
									<div class="form-field">
										<div class="form-field-label-wrap">
											<div class="form-field-label">
												description
											</div>
										</div>
										<div class="form-field-input-wrap">
											<div class="form-field-input">
												<input type="text" class="input-text" placeholder="description" name="steps[<%= index %>][description]" value="<%= htmlentities(record.description) %>"/>
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
												<input data-site-media="svg-icons" name="steps[<%= index %>][icon]" value="<%= htmlentities(record.icon) %>"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</script>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Leadership -->
		<div class="form-field-group">
			<div class="form-field-group-label">
				Leadership
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
							<input type="text" class="input-text" placeholder="Title" name="leadership_title" value="{$parameters.record->leadership_title|escape}" />
						</div>
					</div>
				</div>
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							leadership description
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea type="text" class="input-text ckeditor" placeholder="description" name="leadership_description">{$parameters.record->leadership_description}</textarea>
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
							<input data-site-media="hero-images" name="leadership_image" value="{$parameters.record->leadership_image}"/>
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