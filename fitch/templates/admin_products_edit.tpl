{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/products/" class="button1">cancel</a>
			{include file="includes/admin/revisions_action.tpl"}
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				Overview
			</div>
			<div class="form-field-group-content">
		
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Category<span class="text-red"> *</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							{$parameters.category_field->htmlInput()}
						</div>
					</div>
				</div>
				
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							SKU<span class="text-red"> *</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="SKU" name="sku" value="{$parameters.record->sku|escape}"/>
						</div>
					</div>
				</div>
		
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Title<span class="text-red"> *</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Title" name="title" value="{$parameters.record->title|escape}"/>
						</div>
					</div>
				</div>
				
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Description
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<textarea class="input-text ckeditor" placeholder="Description" name="description">{$parameters.record->description|escape}</textarea>
						</div>
					</div>
				</div>
				
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							Price<span class="text-red"> *</span>
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<input type="text" class="input-text" placeholder="Price" name="price" value="{$parameters.record->price|escape}"/>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				Images
			</div>
			<div class="form-field-group-content">

				<div class="form-field-repeating" data-records="{$parameters.record->images|escape}">
					<div class="form-field-repeating-content"></div>
					<div class="form-field-repeating-footer">
						<a class="button1 form-field-repeating-add" href="#">Add More</a>
					</div>
					<script type="text/html">
						<div class="form-field-repeating-item">

							<div class="form-field-repeating-item-header list-action-hover">
								<div class="left">
									<a href="#" class="list-action action-move"></a>
									<span class="form-field-repeating-item-title">
										<span class="default">
											Image #<span class="form-field-repeating-item-position"></span>
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
											Title<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="Title" name="images[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
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
											<input data-site-media="products" name="images[<%= index %>][image]" value="<%= htmlentities(record.image) %>"/>
										</div>
									</div>
								</div>
							</div>

						</div>
					</script>
				</div>

			</div>
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				Repeating Fieldgroup
			</div>
			<div class="form-field-group-content">

				<div class="form-field-repeating" data-records="{$parameters.record->repeating_fieldgroup|escape}">
					<div class="form-field-repeating-content"></div>
					<div class="form-field-repeating-footer">
						<a class="button1 form-field-repeating-add" href="#">Add More</a>
					</div>
					<script type="text/html">
						<div class="form-field-repeating-item">

							<div class="form-field-repeating-item-header list-action-hover">
								<div class="left">
									<a href="#" class="list-action action-move"></a>
									<span class="form-field-repeating-item-title">
										<span class="default">
											Repeating Fieldgroup #<span class="form-field-repeating-item-position"></span>
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
											Title<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="Title" name="repeating_fieldgroup[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Description<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<textarea class="input-text ckeditor" placeholder="Description" name="repeating_fieldgroup[<%= index %>][description]"><%= htmlentities(record.description) %></textarea>
										</div>
									</div>
								</div>
							</div>

						</div>
					</script>
				</div>

			</div>
		</div>
		
        <div class="form-field-group">
			<div class="form-field-group-label">
				Product Variations
			</div>
			<div class="form-field-group-content">
                
  			<div class="form-field-repeating" data-records="{$parameters.record->variations|escape}">
					<div class="form-field-repeating-content"></div>
					<div class="form-field-repeating-footer">
						<a class="button1 form-field-repeating-add" href="#">Add More</a>
					</div>
					<script type="text/html">
						<div class="form-field-repeating-item">

							<div class="form-field-repeating-item-header list-action-hover">
								<div class="left">
									<a href="#" class="list-action action-move"></a>
									<span class="form-field-repeating-item-title">
										<span class="default">
											Product Variations #<span class="form-field-repeating-item-position"></span>
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
											Sku<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="Sku" name="variations[<%= index %>][sku]" value="<%= htmlentities(record.title) %>"/>
										</div>
									</div>
								</div>
        				<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Title<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="Title" name="variations[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Description<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<textarea class="input-text ckeditor" placeholder="Description" name="variations[<%= index %>][description]"><%= htmlentities(record.description) %></textarea>
										</div>
									</div>
								</div>
      					<div class="form-field">
        					<div class="form-field-label-wrap">
        						<div class="form-field-label">
        							Price
        						</div>
        					</div>
        					<div class="form-field-input-wrap">
        						<div class="form-field-input">
        							<input type="text" class="input-text" placeholder="Price" name="variations[<%= index %>][price]" value="<%= htmlentities(record.price) %>"/>
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
											<input data-site-media="products" name="variations[<%= index %>][image]" value="<%= htmlentities(record.image) %>"/>
										</div>
									</div>
								</div>
								               
							</div>

						</div>
					</script>
				</div>

				
                    
                                               
            </div>
        </div>                        
		

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Active
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="status">
						<option value="0">No</option>
						<option value="1"{if $parameters.record->status} selected="selected"{/if}>Yes</option>
					</select>
				</div>
			</div>
		</div>

		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

{include file="includes/admin/site_bottom.tpl"}
{/strip}