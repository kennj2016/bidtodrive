$(function(){
	
	initializeNavPlugins();
	
	function initializeNavPlugins(){
		$('.nav-item-content:not(.mCustomScrollbar)').mCustomScrollbar({
			autoHideScrollbar: true,
			theme: "dark-thick",
			scrollInertia: 150
		});
		
		$('.nav-item-links').nestedSortable({
			expandOnHover: 500,
			maxLevels: 3,
			listType: 'ul',
			handle: 'div',
			items: 'li',
			toleranceElement: '> div',
			forcePlaceholderSize: true,
			placeholder: 'placeholder',
			forceHelperSize: true,
			helper: 'clone',
			appendTo: document.body,
			scroll: false,
			update: function(event, ui){
				$('.nav-item-content li').each(function(){
					var $this = $(this);
					if($this.find('li').length > 0){
						$this.find('.btn-expand').removeClass('hide').addClass('active');
					}else{
						$this.find('.btn-expand').addClass('hide').removeClass('active');
					}
				});
			}
		});
	}
	
	window.onbeforeunload = function(){
		return 'All unsaved changes will be lost.';
	}
	
	// navigation blocks actions
	
	$('body').on('click', '.btn-nav-add', function(){
		var navItemHtml = '';
		navItemHtml += '<div class="nav-item">';
		navItemHtml += '<div class="nav-item-wrapper">';
		navItemHtml += '<div class="nav-item-header">';
		navItemHtml += '<input type="text" name="title" value="nav">';
		navItemHtml += '<a class="btn-links" href="#"></a></div>';
		navItemHtml += '<div class="nav-item-content">';
		navItemHtml += '<ul class="nav-item-links"></ul></div></div>';
		navItemHtml += '<a class="btn-nav-delete" href="#"><span></span></a></div>';
		$('.nav-items').append(navItemHtml);
		initializeNavPlugins();
		return false;
	});
	
	$('body').on('click', '.nav-item .btn-nav-delete', function(){
		var $this = $(this);
		defaultConfirmPopup('Are you sure you want to delete this menu?', function(){
			$this.closest('.nav-item').remove();
		});
		return false;
	});
	
	$('#form-navigation').submit(function(){
		var navigation = [];
		$('.nav-item').each(function(){
			navigation.push({
				'title': $(this).find('[name="title"]').val(),
				'items': getNavigationLinks($(this).find('.nav-item-links'))
			});
		});
		$('[name="navigation"]').val(JSON.stringify(navigation));
		window.onbeforeunload = null;
		return true;
	});
	
	function getNavigationLinks(container){
		var links = [];
		container.find('>[data-link-fields]').each(function(){
			var info = $(this).data('linkFields');
			info.items = getNavigationLinks($(this).find('>ul'));
			links.push(info);
		});
		return links;
	}
	
	// navigation links actions
	
	$('body').on('click', '.nav-item-links .btn-expand', function(){
		$(this).toggleClass('active');
		$(this).closest('li').find('>ul').slideToggle();
		return false;
	});
	
	$('body').on('click', '.nav-item-links .btn-delete', function(){
		var $this = $(this);
		defaultConfirmPopup('Are you sure you want to delete this link?', function(){
			$this.closest('li').remove();
		});
		return false;
	});
	
	$('body').on('click', '.nav-item .btn-links, .nav-item .btn-edit', function(){
		var linkItemHtml = '';
		linkItemHtml += '<li class="nav-item-link" data-link-fields=""><div><span></span>';
		linkItemHtml += '<a class="btn-expand hide" href="#"></a>';
		linkItemHtml += '<a class="btn-delete" href="#"></a>';
		linkItemHtml += '<a class="btn-edit" href="#"></a></div>';
		linkItemHtml += '<ul class="subitems"></ul></li>';
		
		var list = $(this).closest('.nav-item').find('.nav-item-links');
		var linkItem = $(this).hasClass('btn-edit') ? $(this).closest('li[data-link-fields]') : $(linkItemHtml);
		var fields = linkItem.data('linkFields');
		$.post("/admin/navigation/links/", {action: 'popup', fields: fields}, function(html){
			if(html){
				defaultPopup({
					message: html,
					addClass: 'default-text',
					title: (fields ? 'Edit' : 'Create New') + ' Link',
					onafter: function(popup){
						popup.container.find('select').customSelect();
						popup.container.find('form').submit(function(){
							var linkTitle = $('[name="title"]', $(this)).val();
							if(linkTitle){
								if(!fields) list.append(linkItem);
								fields = {
									title: linkTitle,
									link: $('[name="link"]', $(this)).val(),
									is_external: $('[name="is_external"]', $(this)).val()
								};
								linkItem.data('linkFields', fields);
								linkItem.find('> div > span').text(linkTitle);
								popup.close();
							}else{
								defaultErrorPopup("'Title' is missing.");
							}
							return false;
						});
					}
				});
			}
		});
		return false;
	});
	
});