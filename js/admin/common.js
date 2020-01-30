(function($){
	$.fn.disableSelection = function(){
		return this.attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
	};
})(jQuery);

(function($){
	var index = 0;
	$.fn.ckeditor = function(){
		return this.each(function(){
			var This = $(this).addClass('ckeditor');
			if(!This.data('ckeditor')){
				if(!This.attr('id')) This.attr('id', 'ckeditor-'+index++);
				if(typeof CKEDITOR != 'undefined'){

					var config = $(this).data('ckeditor-config');
					var preset = config ? "custom" : $(this).data('ckeditor-preset');
					switch(preset){
						case 'custom':
							break;
						case 'minimal':
							config = {toolbar : [['Bold', 'Italic', 'Underline']]};
							break;
						case 'minimal+link':
							config = {toolbar : [['Bold', 'Italic', 'Underline', '-', 'Link', 'Unlink']]};
							break;
						default:
							config = {
								extraPlugins : 'site_media',
								uiColor: '#FAFAFA',
								filebrowserBrowseUrl : '/fitch/resources/ckfinder/ckfinder.html',
								filebrowserImageBrowseUrl : '/fitch/resources/ckfinder/ckfinder.html?type=Images',
								filebrowserFlashBrowseUrl : '/fitch/resources/ckfinder/ckfinder.html?type=Flash',
								filebrowserUploadUrl : '/fitch/resources/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
								filebrowserImageUploadUrl : '/fitch/resources/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
								filebrowserFlashUploadUrl : '/fitch/resources/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
							}
					}
					config.readOnly = $(this).attr('readonly');

					This.data('ckeditor', CKEDITOR.replace(this, config));
				}
			}
		});
	};
	$.fn.ckeditorUpdateElement = function(){
		return this.each(function(){
			var ckeditor = $(this).data('ckeditor');
			if(ckeditor) ckeditor.updateElement();
		});
	};
	$.fn.ckeditorDestroy = function(){
		return this.each(function(){
			var This = $(this), ckeditor = This.data('ckeditor');
			if(ckeditor){
				ckeditor.destroy();
				This.data('ckeditor', null);
			}
		});
	};
	$.fn.ckeditorRefresh = function(){
		return this.ckeditorDestroy().ckeditor();
	};
})(jQuery);

// Simple JavaScript Templating
// John Resig - http://ejohn.org/ - MIT Licensed
(function(){
	var cache = {};

	this.tmpl = function tmpl(str, data){
		// Figure out if we're getting a template, or if we need to
		// load the template - and be sure to cache the result.
		var fn = !!/^[\w\-]+$/.test(str) ?
			cache[str] = cache[str] ||
				tmpl(document.getElementById(str).innerHTML) :

			// Generate a reusable function that will serve as a template
			// generator (and which will be cached).
			new Function("obj",
				"var p=[],print=function(){p.push.apply(p,arguments);};" +

				// Introduce the data as local variables using with(){}
				"with(obj){p.push('" +

				// Convert the template into pure JavaScript
				str
					.replace(/[\r\t\n]/g, " ")
					.split("<%").join("\t")
					.replace(/((^|%>)[^\t]*)'/g, "$1\r")
					.replace(/\t=(.*?)%>/g, "',$1,'")
					.split("\t").join("');")
					.split("%>").join("p.push('")
					.split("\r").join("\\'")
			 + "');}return p.join('');");

		// Provide some basic currying to the user
		return data ? fn( data ) : fn;
	};
})();


(function($){
	var index = 0;
	$.fn.customSelect = function(){
		return this.each(function(){
			var targetSelect = $(this);
			if(!targetSelect.is('select') || targetSelect.data('custom-select')) return;
			targetSelect.data('custom-select', true);

			var
				targetOptions = targetSelect.find('option'),
				isMultiple = targetSelect.prop('multiple'),
				customSelect = $('<div class="custom-select"><div class="value"></div><div class="options"></div></div>').addClass(isMultiple ? 'multiple' : 'single').disableSelection(),
				customValue = customSelect.find('.value'),
				customOptionsWrap = customSelect.find('.options'),
				customOptions,
				close,
				value = null;

			function updateValue(trigger){
				var opt = targetOptions.filter(':selected');
				customValue.text(opt.length ? opt.text() || opt.val() : '');

				customOptions.removeClass('selected');
				targetOptions.each(function(index){
					if($(this).prop('selected')) customOptions.eq(index).addClass('selected');
				});

				var oldVlaue = value;
				value = ''+targetSelect.val();
				if(trigger && oldVlaue !== null && oldVlaue !== value) targetSelect.change();
			}

			function optClick(option, ctrl){
				var index = $(option).index(), unselectAll = true, selectThis = true;
				if(isMultiple && ctrl){
					unselectAll = false;
					if(targetOptions.eq(index).prop('selected')) selectThis = false;
				}
				if(unselectAll){
					targetOptions.prop('selected', false);
					customOptions.removeClass('selected');
				}
				if(selectThis){
					targetOptions.eq(index).prop('selected', true);
					customOptions.eq(index).addClass('selected');
				}else{
					targetOptions.eq(index).prop('selected', false);
					customOptions.eq(index).removeClass('selected');
				}
				updateValue(true);
				if(close) close();
			}

			function scrollbar(){
				if(!customOptionsWrap.is('.mCustomScrollbar')) customOptionsWrap.mCustomScrollbar({
					autoHideScrollbar: false,
					theme: "dark-thick",
					scrollInertia: 150
				});
			}

			targetSelect.hide().after(customSelect).change(function(){
				updateValue();
			});

			targetOptions.each(function(){
				var This = $(this), opt = $('<div class="option"></div>').text(This.text());
				if(This.is(':selected')) opt.addClass('selected')
				customOptionsWrap.append(opt);
				if(!customOptions) customOptions = opt;
				else customOptions = customOptions.add(opt);
			});
			customOptions.on('click tap', function(e){
				optClick(this, e.ctrlKey || e.metaKey || e.type == 'tap');
				return false;
			});

			if(isMultiple) scrollbar();
			else{
				function click(event){
					if(!$(event.target).closest(customSelect).length) close();
				}

				close = function(){
					customSelect.removeClass('opened');
					customOptionsWrap.hide();
					$('body').unbind('click', click);
				}

				customValue.click(function(){
					if(targetSelect.prop('disabled')) return false;
					if(!customSelect.is('.opened')){
						customSelect.addClass('opened');
						customOptionsWrap.show();
						scrollbar();
						$('body').bind('click', click);
					}else close();
				});
			}

			updateValue();
		});
	};
})(jQuery);

$(function(){
	$('.form-field-input [type="password"],.check_pass_strength').each(function(){
		check_pass_strength($(this));
	});
	function check_pass_strength($object) {
		$object.on('keyup change focus blur', function(){main_check_pass_strength($object);});
		main_check_pass_strength($object);
		function main_check_pass_strength($object) {
			var pass1 = $object.val(), strength;
			var parent = $object.parent();
			if(parent.find('#pass-strength-result').length == 0){
				parent.append("<div id='pass-strength-result'></div>");
			}
			var passStrengthResult = parent.find('#pass-strength-result');
			passStrengthResult.removeClass('short bad good strong');
			if (!pass1) {
				passStrengthResult.html( '&nbsp;' );
				return;
			}
			strength = wp.passwordStrength.meter( pass1, wp.passwordStrength.userInputBlacklist(), pass1 );
			switch ( strength ) {
				case -1:
					passStrengthResult.addClass( 'bad' ).html( "Unknown" );
					break;
				case 2:
					passStrengthResult.addClass('bad').html( "Weak" );
					break;
				case 3:
					passStrengthResult.addClass('good').html( "Medium" );
					break;
				case 4:
					passStrengthResult.addClass('strong').html( "Strong" );
					break;
				case 5:
					passStrengthResult.addClass('short').html( "Mismatch" );
					break;
				default:
					passStrengthResult.addClass('short').html( 'Very weak' );
			}
		}
	}
});

$(function(){

	$(".page-two,.menubox").mCustomScrollbar({
		autoHideScrollbar: false,
		theme: "dark-thick",
		scrollInertia: 150
	});

	$(".icon-menu").click(function(){
		$(".menubox").toggleClass("menubox-active");
		return false;
	});

	(new TimelineMax())
		.to("html", 0.5, {opacity : 1})
		.staggerFrom(".navigation div", 0.5, {opacity : 0, top : -25, ease : Expo.easeOut, delay : 0.2}, 0.05, "sametime1")
		.staggerFrom(".content", 0.5, {opacity : 0, top : -25, ease : Expo.easeOut, delay : 0.2}, 0.05, "sametime1")
		.staggerFrom(".box, .section, .section-small-field, .section-large-field", 0.5, {opacity : 0, top : -50, ease : Expo.easeOut, delay : 0.2}, 0.05, "sametime1");

});

$(function(){
	
	var nav = $('.feture-links');
	var links = nav.find('a');
	var total = links.length;
	
	if(total > 5) (function(){
		
		var navWrap = $('.navigation-wrap');
		var text = links.find('span');
		var half = Math.round(total / 2);
		
		function update(){
			if(nav.is(':visible')){
				navWrap.removeClass('two-rows');
				nav.empty().append(links);
				
				var ok = true;
				links.each(function(index){
					if($(this).innerWidth() < text.eq(index).outerWidth() + 20) ok = false;
				});
				
				if(!ok){
					navWrap.addClass('two-rows');
					nav.append(
						$('<div/>').append(links.filter(':lt('+half+')')),
						$('<div/>').append(links.filter(':gt('+(half-1)+')'))
					);
				}
			}
		}
		
		$(window).bind('resize orientationchange', update);
		update();
		
	})();
	
});

/*
 * form fields
 */
$(function(){

	$('.geocode-search-latlon').click(function(){
		if(typeof google == 'undefined') return false;

		var frm = $(this).closest('form'), geocoder = new google.maps.Geocoder();
		var address = [];
		frm.find('[name=address],[name=city],[name=state],[name=zip],[name=country]').each(function(){
			var inpt = $(this), val = inpt.val();
			if(inpt.is('select') && val.match(/^\d+$/)) val = inpt.find('option:selected').text();
			if(val) address.push(val);
		});

		if(!address.length){
			defaultErrorPopup('Address parts are missing.', 1);
		}else{
			geocoder.geocode({address: address.join(' ')}, function(result, status){
				if(status == google.maps.GeocoderStatus.OK){
					defaultSuccessPopup('Address was found.', 1);
					frm.find('[name=lat]').val(result[0].geometry.location.lat());
					frm.find('[name=lon]').val(result[0].geometry.location.lng());
				}else{
					defaultErrorPopup('Could not find the address.', 1);
				}
			});
		}
	});

	$('.submit-actions').each(function(){
		var This = $(this), btns = This.find('[type=button]'), submit = $('[name=submit]');

		btns.keypress(function(event){
			if(event.keyCode == 13 || event.keyCode == 32) $(this).click();
		});

		btns.click(function(event){
			submit.val($(this).val()).click();
		});

		if(This.is('.pending-for-approve')){
			var
				frm = This.closest('form'),
				inpts = frm.find(':input:not([name=submit])'),
				value = inpts.serialize(),
				btn1 = btns.filter('.submit-approve'),
				btn2 = btns.filter('.submit-save,.submit-publish');
			inpts.on('keyup change blur', function(){
				var v = inpts.serialize();
				if(value == v){
					btn2.hide();
					btn1.show();
					submit.val(btn1.val());
				}else{
					btn1.hide();
					btn2.show();
					submit.val('');
				}
			});
		}
	});

	var loadSiteMediaFolder;
	(function(){
		var status = false, folders = [], foldersByLabel = [], callbacks = [];
		loadSiteMediaFolder = function(label, callback){
			if(!callbacks[label]) callbacks[label] = [];
			if(callback) callbacks[label].push(callback);
			if(foldersByLabel[label]){
				if(callback) callback(foldersByLabel[label], folders);
			}else if(!status){
				status = true;
				SiteMediaApi.get('get_folders', null, function(records){
					if(records) $.each(records, function(i, record){
						var folder = new SiteMediaApi.Folder(record);
						foldersByLabel[record.label] = folder;
						folders.push(folder);
						if(callbacks[record.label]) $.each(callbacks[record.label], function(i, callback){
							callback(foldersByLabel[record.label], folders);
						});
					});
				}, defaultErrorPopup);
			}
		}
	})();

	function prepare(e){
		if(!e) e = $('.form-field');
		e.find('select:not(.select-autocomplete)').customSelect();
		e.find('.ckeditor').ckeditor();
		e.find('.datepicker').customDatePicker();
		e.find('.datetimepicker').customDateTimePicker();
		e.find('.timepicker').customTimePicker();

		function updateCheckbox(){
			$(this).parent()[$(this).is(':checked') ? 'addClass' : 'removeClass']('checked');
		}
		e.find('.input-checkname-holder label').each(function(){
			var input = $(this).find('input'), relative;
			if(input.is('[type=radio]')){
				relative = $(input[0].form).find('[name="'+input.attr('name')+'"]');
				input.change(function(){
					relative.each(updateCheckbox);
				});
			}else{
				input.change(updateCheckbox);
			}
			updateCheckbox.call(input[0]);
		});

		

		e.find('[data-site-media]').each(function(){

			(function(){
				if($('#jcrop-js').length) return;
				$('head').append(
					'<script type="text/javascript" id="jcrop-js" src="/fitch/resources/Jcrop/js/jquery.Jcrop.min.js"></script>',
					'<link rel="stylesheet" type="text/css" href="/fitch/resources/Jcrop/css/jquery.Jcrop.css" />'
				);
			})();

			var file = null;
			var target = $(this).hide();
			var options = target.attr('data-site-media').split(',');
			var container = $(
				'<div class="input-text">'
				+'<div class="site-media-input">'
				+'<a class="clear">Clear</a>'
				+'<a class="media">Media</a>'
				+'<a class="upload">Upload<input type="file" /></a>'
				+'<div class="file"><div></div></div>'
				+'<div class="crop show-on-pc"><div></div></div>'
				+'<div class="preview"><div><a href="#" target="_blank" data-lightbox="image-orig"><img src="/img/admin/media-file.png" alt="" /></a></div></div>'
				+'</div>'
				+'</div>'
			);

			if(options.length > 1) options = {folder: options[0], size: options[1]}
			else options = {folder: options[0], size: null}

			var title = target.attr('title');
			if(title) container.attr('title', title);

			container.find('.clear').click(function(){
				setFilename(null);
			});

			var crop = container.find('.crop').hide();
			crop.find('div').click(function(){
				cropSiteMedia(file);
			});

			loadSiteMediaFolder(options.folder);

			function uploadFile(folder){
				new SiteMediaApi.File(folder, container.find('input')[0].files[0], function(file){
					if(file.error) defaultErrorPopup(file.error);
					else setFilename(file);
				});
			}

			function showPopup(folder, files, folders){
				defaultPopup({
					title: 'Media',
					addClass: 'large',
					onbefore: function(popup){
						
						function displayFiles(d, fl){
							filesBox.empty();
							$.each(fl, function(){
								var file = new SiteMediaApi.File(d, this);
								file.container.find('.actions').empty();
								file.container.click(function(){
									if(d !== folder){
										popup.close();
										new SiteMediaApi.File(folder, file, function(copy){
											if(copy.error) defaultErrorPopup(copy.error);
											else setFilename(copy);
										});
									}else{
										setFilename(file);
										popup.close();
									}
								});
								filesBox.append(file.container);
							});
						}
						
						var span = popup.container.find('.popup-heading span');
						var select = $('<select></select>'), optTotal = 0;
						$.each(folders, function(){
							if(this.record.type == folder.record.type){
								select.append($('<option></option>').text(this.record.title).val(this.record.id).data('folder', this));
								optTotal++;
							}
						});
						if(optTotal > 1){
							var selectLoading = false;
							select.val(folder.record.id).data('folder', folder).appendTo(span).change(function(){
								var d = select.data('folder');
								if(selectLoading){
									select.val(d.record.id);
									return false;
								}
								selectLoading = true;
								select.prop('disabled', true);
								d = select.find(':selected').data('folder');
								select.data('folder', d);
								filesBox.html('<center>Loading...</center>');
								SiteMediaApi.get('view_folder', d.record.label, function(fl){
									selectLoading = false;
									select.prop('disabled', false);
									displayFiles(d, fl);
								}, defaultErrorPopup);
							}).wrap($('<div class="form-field"></div>').css({
								display: 'inline-block',
								marginLeft: 10,
								position: 'relative',
								background: '#fff',
								verticalAlign: 'middle',
								border: 0
							})).customSelect();
						}

						var filesBox = $('<div></div>').css({
							height: 400,
							overflowX: 'hidden',
							overflowY: 'scroll'
						}).appendTo(popup.container.find('.popup-text'));
						displayFiles(folder, files);

					}
				});
			}

			container.find('.media').click(function(){
				loadSiteMediaFolder(options.folder, function(folder, folders){
					SiteMediaApi.get('view_folder', options.folder, function(files){
						showPopup(folder, files, folders);
					}, defaultErrorPopup);
				});
			});

			container.find('input').change(function(){
				loadSiteMediaFolder(options.folder, uploadFile);
			});

			function getInput(){
				return target.val();
			}

			function setFilename(f){
				file = f;
				var val = '', preview = '', valOld = target.val(), valNew;
				if(file){
					val = file.record.name_orig;
					if(file.isImage()) preview = file.getPath('_thumbs');
					else if(file.isSvg()) preview = file.getPath();
					valNew = file.record.id;
				}else{
					valNew = '';
				}

				target.val(valNew);
				if(valOld != valNew) target.change();

				if(preview){
					container.find('img').attr('src', preview).parent().attr('href', file.getPath());
					container.find('.site-media-input').addClass('preview');
				}else{
					container.find('.site-media-input').removeClass('preview');
				}

				if(file && preview && file.folder.record.type == 'images') crop.show();
				else crop.hide();

				container.find('.file div').text((''+val).split('/').pop());
			}

			var fileId = getInput();
			if(fileId){
				loadSiteMediaFolder(options.folder, function(folder){
					SiteMediaApi.get('get_file', fileId, function(record){
						setFilename(new SiteMediaApi.File(folder, record));
					}, function(){
						setFilename(null);
					});
				});
			}

			target.after(container);

		});

	}
	prepare();

	function destroy(e){
		if(!e) e = $('.form-field');
		e.find('.ckeditor').ckeditorDestroy();
	}

	$('body').on('click', '.form-field-group-label', function(e){
		var group = $(e.target).closest('.form-field-group'), content = group.find('>.form-field-group-content');
		if(group.is('.opened')){
			group.removeClass('opened');
			content.slideUp();
		}else{
			$('.form-field-group.opened').each(function(){
				if(!$.contains(this, group[0])) $('.form-field-group-label', this).click();
			});
			group.addClass('opened');
			content.slideDown().find('.ckeditor').ckeditorRefresh();
		}
	});
	
	$('body').on('click', '.form-field-repeating-item-header .open,.form-field-repeating-item-title', function(e){
		var group = $(e.target).closest('.form-field-repeating-item'), content = group.find('.form-field-repeating-item-content');
		if(group.is('.opened')){
			group.removeClass('opened');
			content.slideUp();
		}else{
			group.closest('.form-field-repeating-content').find('.form-field-repeating-item.opened .form-field-repeating-item-title').click();
			group.addClass('opened');
			content.slideDown().find('.ckeditor').ckeditorRefresh();
		}
		return false;
	});

	$('.form-field-repeating').each(function(){
		var
			wrap = $(this),
			records = wrap.attr('data-records'),
			defaultRecord = wrap.attr('data-default'),
			prepareRecord = wrap.attr('data-prepare'),
			removeRecord = wrap.attr('data-remove'),
			updateRecords = wrap.attr('data-update'),
			content = wrap.find('.form-field-repeating-content'),
			tpl = tmpl(wrap.find('script[type="text/html"]').text()),
			index = 0;

		content.sortable({
			handle: ".action-move",
			appendTo: document.body,
			scroll: false,
			helper: function(event, item){
				var clone = item.clone();
				$('.ckeditor', item).ckeditorDestroy();
				return clone[0];
			},
			forceHelperSize: true,
			forcePlaceholderSize: true,
			stop: function(event, ui){
				$('.ckeditor', ui.item).ckeditor();
			},
			update: updatePositions
		});

		records = records ? $.parseJSON(records) : [];
		defaultRecord = defaultRecord ? $.parseJSON(defaultRecord) : {};
		if(!records.length) records = [defaultRecord];

		function updatePositions(){
			content.find('.form-field-repeating-item-position').each(function(i){
				$(this).text(i + 1);
			});
		}
		
		function checkLimit(){
			var recordsMax = wrap.data('max-records');
			if(recordsMax === undefined) return;
			wrap.find('> .form-field-repeating-footer').toggle(
				content.find('> .form-field-repeating-item').length < parseInt(recordsMax)
			);
		}

		function update(){
			updatePositions();
			content.sortable("refresh");
			if(updateRecords) window[updateRecords](wrap);
			checkLimit();
		}
		
		function newItem(record){
			var item = $(tpl({
				index: index++,
				record: record
			}));

			content.append(item);
			if(prepareRecord) window[prepareRecord](item);
			prepare(item);
			update();

			if(item.find('.form-field-repeating-item-title .custom[rel]').length) (function(){
				var
					title = item.find('.form-field-repeating-item-title'),
					custom = title.find('.custom'),
					inpt = item.find(custom.attr('rel')).eq(0);
				function updateTitle(){
					if (inpt[0].nodeName == "SELECT") var val = inpt[0].options[inpt[0].selectedIndex].text;
					else var val = inpt.val();
					if(val === null || val === undefined) val = '';
					custom.text(val);
					if(val != '') title.addClass('custom');
					else title.removeClass('custom');
				};
				inpt.on('keyup change blur', updateTitle);
				updateTitle();
			})();

			item.find('.form-field-repeating-delete').click(function(e){
				defaultConfirmPopup('Are you sure you want to remove this item?', function(){
					destroy(item);
					item.remove();
					if(removeRecord) window[removeRecord](wrap);
					update();
				});
				return false;
			});
		}

		$.each(records, function(){
			newItem(this);
		});

		wrap.find('.form-field-repeating-add').click(function(){
			newItem(defaultRecord);
			return false;
		});

	});
	
});

function form_submit(action, method, data){
	var frm = $('<form class="invisible" action="'+action+'" method="'+method+'"></form>').css({position: 'absolute', visibility: 'hidden'});
	foreach_recursive(data, function(k, v){
		for(var i = 1; i < k.length; i++) k[i] = '['+k[i]+']';
		frm.append($('<textarea name="'+k.join('')+'"></textarea>').val(v));
	});
	$('body').append(frm);
	frm.submit();
}//form_submit
function form_post(action, data){form_submit(action, 'post', data);}
function form_get(action, data){form_submit(action, 'get', data);}
function foreach(o, f){for(var k in o) if(o.hasOwnProperty(k) && f(k,o[k],o)) return;}
function foreach_recursive(o, f, keys){
	if(!keys) var keys = [];
	for(var k in o) if(o.hasOwnProperty(k)){
		if(typeof o[k] == 'object' || typeof o[k] == 'array'){
			foreach_recursive(o[k], f, array_merge(keys, [k]));
		}else if(f(array_merge(keys, [k]),o[k],o)) return;
	}
}//foreach_recursive
function array_merge(){
	var r = [];
	for(var i = 0; i < array_merge.arguments.length; i++){
		for(var j = 0; j < array_merge.arguments[i].length; j++){
			r.push(array_merge.arguments[i][j]);
		}
	}
	return r;
}//array_merge

function htmlentities(str){
	if(str === undefined || str === null) str = '';
	return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}//htmlentities

function parse_mysql_date(d){
	d = d.split(/[- :]/);
	return new Date(d[0], d[0] - 1, d[2], d[3], d[4], d[5], 0);
}//parse_mysql_date


$(function(){

	$('.popup-wrap').each(function(){
		defaultPopup({container: this});
	});

});

function defaultPopup(options){
	var popup = {
		close: function(){
			var container = this.container;
			$(window).unbind('resize orientationchange', fixPosition);
			container.removeClass('show');
			setTimeout(function(){container.remove();}, 300);
			if(options.onclose) options.onclose(popup);
		}
	};
	if(options.container){

		popup.container = $(options.container);
		if(popup.container.data('defaultPopup')) return;

	}else{

		if(!options) options = {type: '', title: ''};
		if(!options.type) options.type = 'info';
		if(!options.title) options.title = options.type;

		popup.container = $(
			'<div class="popup-wrap fixed">'
				+'<div class="popup-overlay"></div>'
				+'<div class="popup-box"><div class="popup-content">'
					+'<div class="popup-heading"><span></span><a class="popup-close" href="#"></a></div>'
					+'<div class="popup-text"></div>'
				+'</div></div>'
			+'</div>'
		);

		if(options.message) popup.container.find('.popup-text').html(options.message);
		popup.container.find('.popup-heading span').text(options.title);

		var cpopup = popup.container.find('.popup-box');
		if(options.addClass) cpopup.addClass(options.addClass);
		if(options.type == 'error') cpopup.addClass('red');
		else if(options.type == 'success') cpopup.addClass('green');
		else if(options.type == 'info') cpopup.addClass('blue');

		if(options.onbefore) options.onbefore(popup);

	}

	popup.container.find('.popup-close,.popup-overlay').click(function(){
		popup.close();
		return false;
	});

	popup.center = function(){
		var box = popup.container.find('.popup-box');
		box.css({
			marginLeft: -box.width()/2,
			marginTop: -box.height()/2
		});
	}
	function fixPosition(){
		popup.center();
	}

	popup.container.data('defaultPopup', true);

	if(popup.container.is('.fixed')){
		popup.container.appendTo('body');
		setTimeout(function(){
			popup.container.addClass('show');
			$(window).bind('resize orientationchange', fixPosition);
			popup.center();
			if(options.onafter) options.onafter(popup);
			if(options.autoclose > 0){
				setTimeout(function(){
					popup.close();
				}, options.autoclose * 1000);
			}
		}, 0);
	}else{
		popup.close = function(){
			popup.container.find('.popup-box').slideUp().fadeOut(function(){
				popup.container.remove();
			});
		}
	}
	return popup;
}//defaultPopup
function defaultErrorPopup(message, autoclose){return defaultPopup({message: '<p><b>'+message.replace(/\n/g, "<br />")+'</b></p>', type: 'error', autoclose: autoclose});}
function defaultSuccessPopup(message, autoclose){return defaultPopup({message: '<p><b>'+message.replace(/\n/g, "<br />")+'</b></p>', type: 'success', autoclose: autoclose});}
function defaultInfoPopup(message, autoclose){return defaultPopup({message: '<p><b>'+message.replace(/\n/g, "<br />")+'</b></p>', autoclose: autoclose});}
function defaultConfirmPopup(message, yes, no){
	var state = false;
	return defaultPopup({message: '<p><b>'+message.replace(/\n/g, "<br />")+'</b></p>', title: 'confirm', onbefore: function(popup){
		var block = $('<div class="block"><a class="button1" href="#">YES</a><a class="button1" href="#">NO</a></div>');
		block.find('a').click(function(){
			state = !$(this).index();
			popup.close();
			return false;
		});
		popup.container.find('.popup-text').append(block);
	},
	onclose: function(){
		if(state){
			if(yes) yes();
		}else if(no) no();
	}});
}//defaultConfirmPopup

function formValidator(frm, options, custom){
	frm = $(frm);
	frm.submit(function(){
		var messages = [], customResponse = null;
		frm.find('.ckeditor').ckeditorUpdateElement();
		formValidator.validateForm(frm, options, messages);
		if(custom) custom(messages);
		if(custom){
						customResponse = custom(messages);
						if(typeof customResponse === 'string' && customResponse.length)
							messages.push(customResponse);
		}
		if(messages.length){
			defaultErrorPopup(messages.join("\n"));
			return false;
		}
	});
}//formValidator
formValidator.matchFormat = function(val, format){
		if(format == 'email') format = new RegExp("^.+\\@.+\\..+$");
		else if(format == 'zip') format = new RegExp("^\\d{5}$");
		else if(format == 'phone') format = new RegExp("^\\(\\d{3}\\) \\d{3}\\-\\d{4}$");
		else if(format == 'url') format = new RegExp("^([a-z\\d]+:\\/\\/[a-z\\d\\-\\.]+[a-z])?(\\/.*|)$", "i");
		else if(format == 'int') format = new RegExp("^\\-?\\d+$");
		else if(format == 'float') format = new RegExp("^\\-?\\d+(\\.\\d+)?$");
		else if(format == 'usint') format = new RegExp("^\\d+$");
		else if(format == 'usfloat') format = new RegExp("^\\d+(\\.\\d+)?$");
		else if(!(format instanceof RegExp)) format = new RegExp(format);
		return !!val.match(format);
	}
formValidator.formatHint = function(label, opt){
		var hint, format;
		if(opt.format_hint) hint = opt.format_hint;
		else{
			if(opt.format == 'url') hint = label + ' should be valid URL (ex. http://domain.com/page).';
			else{
				if(opt.format == 'phone') format = "(XXX) XXX-XXXX";
				if(format) hint = 'Valid format is "'+format+'".';
			}
		}
		return hint ? ' ' + hint : '';
	}
formValidator.getLabel = function(opt){
		var label;
		if(opt.label) label = opt.label;
		if(!label){
			label = opt.name.replace(/\_/g, ' ');
			label = label.charAt(0).toUpperCase() + label.slice(1);
		}
		return '`'+label+'`';
	}
formValidator.validateForm = function(container, options, messages){
		$.each(options, function(){
		formValidator.validateInput(container.find(this.selector || '[name="'+this.name+'"]'), this, messages);
	});
}
formValidator.validateInput = function(inpt, opt, messages){
	var val, label = formValidator.getLabel(opt);
	if(inpt instanceof jQuery) val = inpt.val();
	else{
		val = inpt;
		inpt = null;
	}
			if(val){
				if(opt.min && val.length < opt.min) messages.push(label + ' must contain at minimum ' + opt.min + ' characters.');
				else if(opt.max && val.length > opt.max) messages.push(label + ' must contain at maximum ' + opt.max + ' characters.');
		else if(opt.format && !formValidator.matchFormat(val, opt.format)) messages.push('Invalid ' + label + ' format.'+formValidator.formatHint(label, opt));
	}else if(opt.required) messages.push(label+' is ' + (inpt && inpt.is('select,[type=radio],[type=checkbox]') ? 'not chosen' : 'missing') + '.');
		}

var SiteMediaApi = {
	show_progress: "upload" in new XMLHttpRequest,
	show_preview: typeof FileReader != 'undefined',
	base_path: '/media',
	default_thumb: '/img/admin/media-file.png',
	files_sort: null,
	files_order: null,
	onerror: null,
	call: function(action, parameters, success, erorr, extend){
		return $.ajax($.extend({
			url: '/admin/site_media/api/'+action+'/',
			type: 'get',
			data: {parameters: parameters || ''},
			dataType: 'json',
			success: function(response){
				if(response.has_error){
					if(erorr) erorr(response.status);
				}else{
					if(response.status) defaultSuccessPopup(response.status);
					if(success) success(response.data);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				var status;
				if(erorr){
					switch(textStatus){
						case 'timeout': status = 'Timeout error.'; break;
						case 'error': status = 'HTTP error.'; break;
						case 'abort': status = 'Request aborted.'; break;
						case 'parsererror': status = 'Parser error.'; break;
						default: status = 'Unknown error.';
					}
					erorr(status);
				}
			}
		}, extend || {}));
	},
	get: function(action, parameters, success, erorr){
		this.call(action, parameters, success, erorr);
	},
	post: function(action, parameters, success, erorr){
		this.call(action, parameters, success, erorr, {type: 'post'});
	},
	upload: function(file, folder, success, error, progress){

		var This = this, formData = new FormData();
		formData.append('file', file);
		formData.append('parameters', folder);

		if(!progress) progress = function(){};

		progress(0);
		This.call('upload_file', null, function(file){
			progress(100);
			if(success) success(file);
		}, function(message){
			progress(0);
			if(error) error(message);
		}, {
			type: 'post', data: formData, processData: false, contentType: false, xhr: function(){
			var xhr = jQuery.ajaxSettings.xhr();
			if(This.show_progress && xhr instanceof window.XMLHttpRequest){
				xhr.upload.onprogress = function(e){
					if(e.lengthComputable) progress(Math.round(e.loaded / e.total * 100) || 0);
				}
			}else progress(50);
			return xhr;
		}});

	}
};

SiteMediaApi.File = function(folder, record, onload){
	var This = this;
	This.record = {id: '', name_orig: '', name_new: '', extension: '', datetime_create: '', size: 0};
	This.folder = folder;
	This.error = false;
	This.onload = function(){
		if(onload) onload.call(This, This);
	};
	This.container = $(
		'<div class="media-box-file">'
		+'<div class="date"></div>'
		+'<div class="process">Upload</div>'
		+'<div class="thumb">'
		+'<img src="'+SiteMediaApi.default_thumb+'" alt="" />'
		+'</div>'
		+'<div class="name"></div>'
		+'<div class="actions"><a class="view"></a><a class="download"></a><a class="remove"></a></div>'
		+'<div class="progress"><div class="value"></div><div class="bar"><div></div></div></div>'
		+'</div>'
	);

	This.container.find('.remove').click(function(){
		This.folder.removeFile(This);
		return false;
	});

	if(record instanceof File) This.upload(record);
	else if(record instanceof SiteMediaApi.File) This.copy(record);
	else{
		This.setData(record);
		This.onload();
	}
	return This;
}
SiteMediaApi.File.prototype.setData = function(record){
	var This = this;
	$.each(record, function(name, val){
		switch(name){
			case 'name_orig':
				This.record.name_orig = val || '';
				This.container.find('.name').text(This.record.name_orig);
				This.record.extension = This.record.name_orig.split('.').pop().toLowerCase();
				break;
			case 'name_new':
				This.record.name_new = val || '';
				if(This.record.name_new){
					var path = This.getPath('_orig');
					This.container.find('.view').attr('href', path).attr('target', '_blank');
					This.setThumb();
					This.container.find('.download').attr('data-clipboard-text', path)
				}
				break;
			case 'size':
				This.record.size = parseInt(val, 10) || 0;
				This.folder.updateSize();
				break;
			case 'datetime_create':
				if(val instanceof Date){
					val = [val.getFullYear(), val.getMonth() + 1, val.getDate(), val.getHours(), val.getMinutes(), val.getSeconds()];
					for(var i = 1; i < 6; i++){
						if(val[i] < 10) val[i] = '0'+val[i];
					}
					val = val[0] + '-' + val[1] + '-' + val[2] + ' ' + val[3] + ':' + val[4] + ':' + val[5];
				}
				This.record.datetime_create = val;
				val = This.record.datetime_create.split(/[- :]/);
				This.container.find('.date').text(
					val[1] + '.' + val[2] + '.' + val[0]
				+ '-' + (parseInt(val[3], 10) % 12 || 12) + ':' + val[4] + (parseInt(val[3], 10) < 12 ? 'AM' : 'PM')
				);
				break;
			default:
				This.record[name] = val;
		}
	})
};
SiteMediaApi.File.prototype.isImage = function(){
	return {'png': true, 'jpg': true, 'jpeg': true, 'gif': true}[this.record.extension] === true;
};
SiteMediaApi.File.prototype.isSvg = function(){
	return this.record.extension === 'svg';
};
SiteMediaApi.File.prototype.setThumb = function(val){
	var src;
	if(this.isImage()){
		src = this.getPath('_thumbs');
	}else if(this.isSvg()){
		src = this.getPath();
	}else{
		src = SiteMediaApi.default_thumb;
	}
	this.container.find('img').attr('src', val || src);
};
SiteMediaApi.File.prototype.getPath = function(dir){
	return this.folder.getPath() + '/' + (dir || '_orig') + '/' + this.record.name_new;
};
SiteMediaApi.File.prototype.setProgress = function(val){
	this.container.find('.progress .value').text(val + '%');
	this.container.find('.progress .bar div').css('width', val + '%');
};
SiteMediaApi.File.prototype.showProcess = function(name){
	this.setProgress(0);
	this.container.find('.process').text(name);
	this.container.addClass('in-progress');
};
SiteMediaApi.File.prototype.hideProcess = function(){
	this.container.find('.process').text('');
	this.container.removeClass('in-progress');
};
SiteMediaApi.File.prototype.copy = function(file){
	var This = this;

	This.showProcess('Upload');

	This.setData({
		size: file.record.size,
		name_orig: file.record.name_orig,
		datetime_create: new Date()
	});
	
	var isImage = This.isImage(), error;
	
	if(This.folder.record.type == 'images'){
		if(!isImage){
			error = 'Forbidden file type, only images allowed for this folder.';
		}
	}else if(This.folder.record.type == 'svg'){
		if(!This.isSvg()){
			error = 'Forbidden file type, only SVG allowed for this folder.';
		}
	}
	
	if(error){
		This.error = error;
		This.folder.removeFile(This, true);
		This.onload();
		return false;
	}
	
	if(isImage){
		This.setThumb(file.getPath('_thumbs'));
	}

	SiteMediaApi.post('copy_file', [file.record.id, This.folder.record.id], function(file){
		This.setData(file);
		This.hideProcess();
		This.onload();
	}, function(message){
		This.error = message;
		This.folder.removeFile(This, true);
		This.onload();
	});
	
};
SiteMediaApi.File.prototype.upload = function(file){
	var This = this;

	This.showProcess('Upload');

	This.setData({
		size: file.size,
		name_orig: file.name,
		datetime_create: new Date()
	});
	
	var isImage = This.isImage(), error;
	
	if(This.folder.record.type == 'images'){
		if(!isImage){
			error = 'Forbidden file type, only images allowed for this folder.';
		}
	}else if(This.folder.record.type == 'svg'){
		if(!This.isSvg()){
			error = 'Forbidden file type, only SVG allowed for this folder.';
		}
	}
	
	if(error){
		This.error = error;
		This.folder.removeFile(This, true);
		This.onload();
		return false;
	}

	if(SiteMediaApi.show_preview){
		if(isImage || This.isSvg()){
			var reader = new FileReader();
			reader.onload = function(event){
				This.setThumb(event.target.result);
			};
			reader.readAsDataURL(file);
		}
	}

	SiteMediaApi.upload(
		file,
		This.folder.record.id,
		function(file){
			This.setData(file);
			This.hideProcess();
			This.onload();
		}, function(message){
			This.error = message;
			This.folder.removeFile(This, true);
			This.onload();
		}, function(process){
			This.setProgress(process);
		}
	);

}

SiteMediaApi.Folder = function(record){
	var This = this;
	This.files = [];
	This.size = 0;
	This.record = record;
	This.onsizeupdate = null;
	This.onupdate = null;
	This.container = $(
		'<div class="media-box-folder">'
		+htmlentities(This.record.title)
		+'<a class="action '+(This.record.readonly == 1 ? 'readonly' : 'remove')+'"></a>'
		+'</div>'
	);
	This.option = $('<option value="'+This.record.id+'">'+htmlentities(This.record.title)+'</option>');
}
SiteMediaApi.Folder.prototype.updateSize = function(){
	var This = this, oldSize = This.size;
	This.size = 0;
	$.each(This.files, function(){
		This.size += this.record.size || 0;
	});
	if(This.size != oldSize && This.onsizeupdate) This.onsizeupdate();
};
SiteMediaApi.Folder.prototype.sortFiles = function(sort, order){
	SiteMediaApi.files_sort = sort;
	SiteMediaApi.files_order = order;
	var This = this;
	This.files.sort(function(a, b){
		if(a.record[SiteMediaApi.files_sort] < b.record[SiteMediaApi.files_sort]) return SiteMediaApi.files_order == 'asc' ? -1 : 1;
		else if(a.record[SiteMediaApi.files_sort] > b.record[SiteMediaApi.files_sort]) return SiteMediaApi.files_order == 'asc' ? 1 : -1;
		else return 0;
	});
	if(This.onupdate) This.onupdate();
};
SiteMediaApi.Folder.prototype.addFiles = function(records){
	var This = this;
	$.each(records, function(){
		This.files.push(new SiteMediaApi.File(This, this));
	});
	This.sortFiles(SiteMediaApi.files_sort, SiteMediaApi.files_order);
};
SiteMediaApi.Folder.prototype.removeFile = function(file, woconfirm){
	var This = this;
	function success(){
		file.container.remove();
		var files = [];
		$.each(This.files, function(){
			if(this !== file) files.push(this);
		});
		This.files = files;
		This.updateSize();
	}
	function remove(){
		if(file.record.id) SiteMediaApi.post('remove_file', file.record.id, success, defaultErrorPopup);
		else success();
	}
	if(woconfirm) remove();
	else defaultConfirmPopup('Are you sure you want to delete this file?', remove);
},
SiteMediaApi.Folder.prototype.view = function(){
	var This = this;
	This.files = [];
	This.size = 0;
	SiteMediaApi.get('view_folder', This.record.id, function(files){
		This.addFiles(files);
	}, defaultErrorPopup);
};
SiteMediaApi.Folder.prototype.getPath = function(){
	return SiteMediaApi.base_path + '/' + this.record.id;
};

function cropSiteMedia(file){
	if(!file) return;
	defaultPopup({
		title: 'Crop Image',
		addClass: 'large',
		onbefore: function(popup){

			var div = popup.container.find('.popup-text');
			div.html('<center>Loading...</center>');
			$.get('/admin/site_media/crop/'+file.record.id+'/', function(html){
				div.html(html);
				div.find('select').customSelect();

				var
					img = div.find('img').hide(),
					loading = $('<center>Loading...</center>'),
					select = div.find('select'),
					btn = div.find('[type=button]');

				img.parent().append(loading);
				popup.center();

				if(img.length){
					var tmp = $('<img />');
					tmp.on('load', function(){
						var origSize = {width: tmp.width(), height: tmp.height()};
						var scaledSize, scale;
						var css = {maxWidth: $(window).width() * 0.7, maxHeight: $(window).height() * 0.5};
						var ratio = 0, api, coords = size = null;

						function updateCoords(){
							var c = api.tellScaled();
							coords = {
								x: Math.round(c.x * scale.x),
								y: Math.round(c.y * scale.y)
							};
							size = {
								width: Math.round(c.w * scale.x),
								height: Math.round(c.h * scale.y)
							};
						}

						function release(){
							api.release();
							coords = size = null;
						}

						function optChange(){
							var val = select.val();
							if(val){
								val = val.split(/[^\d]/);
								val = val[0] / val[1];
								if(ratio > 0 && ratio != val) release();
								ratio = val;
								api.setOptions({aspectRatio: ratio});
								api.enable();
							}else{
								release();
								api.disable();
							}
						}

						tmp.remove();
						loading.remove();
						img.css(css).show();
						scaledSize = {width: img.width(), height: img.height()};
						scale = {x: origSize.width / scaledSize.width, y: origSize.height / scaledSize.height};
						popup.container.find('.popup-box').css('maxWidth', scaledSize.width + 22);
						popup.center();

						img.Jcrop({
							onSelect: updateCoords,
							onChange: updateCoords
						}, function(){
							api = this;
							api.disable();
						});
						select.change(optChange);
						optChange();

						btn.click(function(){
							var sizeId = select.val();
							if(!sizeId){
								defaultErrorPopup('Size is not chosen.');
							}else if(!size || !coords){
								defaultErrorPopup('Crop area is not chosen.');
							}else{
								SiteMediaApi.post('crop', [file.record.id, sizeId, coords, size], function(){
									defaultSuccessPopup('Image was cropped successfully.', 1);
								}, defaultErrorPopup);
							}
						});

					});
					tmp
						.css('maxWidth', 'none')
						.appendTo(
							$('<div />').css({position:'absolute', overflow: 'hidden', width:0, left:0}).appendTo('body')
						)
						.attr('src', img.attr('src'));
				}

			});

		}
	});
}//cropSiteMedia

(function($){

	var days = {
		full: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		abbr: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
	};

	var months = {
		full: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		abbr: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	};

	var hours = (function(){
		var arr = [], h, i;
		for(h = 0; h < 24; h++){
			i = h % 12;
			if(!i) i = 12;
			arr.push((i < 10 ? '0' : '') + i + ' ' + (h < 12 ? 'AM' : 'PM'));
		}
		return arr;
	})();

	var container = $(
		'<div class="input-calendar">'
			+'<div class="date-items items">'
				+'<div class="year item">'
					+'<div class="nav prev"></div><div class="curr"></div><div class="nav next"></div>'
				+'</div>'
				+'<div class="month item">'
					+'<div class="nav prev"></div><div class="curr"></div><div class="nav next"></div>'
				+'</div>'
				+'<div class="week item">'
				+(function(){
					var str = '', i;
					for(i = 0; i < 7; i++) str += '<div>'+days.abbr[i].toUpperCase()+'</div>';
					return str;
				})()
				+'</div>'
				+'<div class="dates item">'
				+(function(){
					var str = '', i;
					for(i = 0; i < 42; i++) str += '<div><span></span></div>';
					return str;
				})()
				+'</div>'
			+'</div>'
			+'<div class="sep"></div>'
			+'<div class="time-items items">'
				+'<div class="time item">'
					+'<input type="button" value="Now" />'
					+'<select>'
					+(function(){
						var str = '', i;
						for(i = 0; i < 24; i++) str += '<option value="'+i+'">'+hours[i]+'</option>';
						return str;
					})()
					+'</select>'
					+(function(){
						var str = '<select>', i;
						for(i = 0; i < 60; i++) str += '<option value="'+i+'">'+(i < 10 ? '0' : '')+i+'</option>';
						str += '</select>';
						return str + str;
					})()
					+'<input type="button" value="Done" />'
				+'</div>'
			+'</div>'
		+'</div>'
	);

	function dateFormat(date){
		if(!date) return null;
		return months.abbr[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
	}

	function timeFormat(date){
		if(!date) return null;
		var i = date.getHours(), m = date.getMinutes(), s = date.getSeconds(), p = i < 12 ? 'AM' : 'PM';
		i %= 12;
		if(!i) i = 12;
		return (i < 10 ? '0' : '') + i + ':' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s + ' ' + p;
	}

	function dateToStr(date){
		if(!date) return null;
		return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
	}

	function inputCalendar(target, options){
		var This = this;
		this.target = target;
		this.target.on('click focus', function(event){
			This.open();
		}).on('keydown', function(event){
			if(event.keyCode == 9) This.close();
		});
		this.options = {date: true, time: true};
		if(options) $.extend(this.options, options);
	}
	inputCalendar.prototype = {
		options: null,
		target: null,
		container: null,
		onoutclick: null,
		init: function(){
			var i, el, This = this;
			if(this.container) return false;

			this.onoutclick = function(event){
				if(!$(event.target).closest(This.container.add(This.target)).length){
					This.close();
				}
			};

			this.container = container.clone().data('inputCalendar', this).appendTo('body');

			if(this.options.date){
				this.container.find('.date-items').show();

				this.container.find('.dates div').click(function(){
					This.dateSet($(this).data('date'));
					if(!This.options.time) This.apply();
				});

				this.container.find('.year .prev').click(function(){
					This.display_date.setFullYear(This.display_date.getFullYear() - 1);
					This.goTo();
				});
				this.container.find('.year .next').click(function(){
					This.display_date.setFullYear(This.display_date.getFullYear() + 1);
					This.goTo();
				});
				this.container.find('.month .prev').click(function(){
					This.display_date.setMonth(This.display_date.getMonth() - 1);
					This.goTo();
				});
				this.container.find('.month .next').click(function(){
					This.display_date.setMonth(This.display_date.getMonth() + 1);
					This.goTo();
				});

				this.goTo(new Date());
			}

			if(this.options.time){
				this.container.find('.time-items').show();

				el = this.container.find('select');
				el.eq(0).change(function(){
					This.time.setHours($(this).val());
					This.timeSet(This.time);
				});
				el.eq(1).change(function(){
					This.time.setMinutes($(this).val());
					This.timeSet(This.time);
				});
				el.eq(2).change(function(){
					This.time.setSeconds($(this).val());
					This.timeSet(This.time);
				});

				el = this.container.find('input');
				el.eq(0).click(function(){
					This.timeSet(new Date());
					if(This.options.date){
						This.dateSet(new Date());
						displayDate = new Date();
						This.goTo(displayDate);
					}
				});
				el.eq(1).click(function(){
					This.apply();
				});

				var time = new Date();
				time.setHours(0);
				time.setMinutes(0);
				time.setSeconds(0);

				this.timeSet(time);
			}
		},
		time: null,
		timeSet: function(date){
			this.time = date ? new Date(date) : null;
			if(this.time){
				var el = this.container.find('.time select');
				el.eq(0).val(this.time.getHours());
				el.eq(1).val(this.time.getMinutes());
				el.eq(2).val(this.time.getSeconds());
			}
		},
		date: null,
		dateSet: function(date){
			this.date = date ? new Date(date) : null;
			var items = this.container.find('.dates div');
			items.filter('.selected').removeClass('selected');
			if(this.date) items.filter('.date-'+dateToStr(this.date)).addClass('selected');
		},
		parseValue: function(){
			var val = this.target.val(), format, offset = 0, date = null;
			val = val ? val.replace(/^\s+|\s+^/g, '') : '';
			if(val){
				format = [];
				if(this.options.date) format.push('([a-z]{3})\\s+(\\d{1,2}), (\\d{4})');
				if(this.options.time) format.push('(\\d{2}):(\\d{2}):(\\d{2}) (AM|PM)');
				val = val.match(new RegExp('^' + format.join(' ') + '$', 'i'));
				if(val){
					date = new Date();
					if(this.options.date){
						date.setFullYear(val[3]);
						date.setMonth(months.abbr.indexOf(val[1].charAt(0).toUpperCase() + val[1].slice(1).toLowerCase()));
						date.setDate(val[2]);
						offset = 3;
						this.dateSet(date);
						this.goTo(date);
					}
					if(this.options.time){
						date.setHours(parseInt(val[offset + 1] == 12 ? 0 : val[offset + 1], 10) + (val[offset + 4].toUpperCase() == 'PM' ? 12 : 0));
						date.setMinutes(parseInt(val[offset + 2], 10));
						date.setSeconds(parseInt(val[offset + 3], 10));
						this.timeSet(date);
					}
				}
			}
		},
		updateValue: function(){
			var val = '', old = this.target.val(), d = this.options.date && this.date, t = this.options.time && this.time;
			if(!this.options.date || !this.options.time || (d && t)){
				if(d) val += dateFormat(this.date);
				if(d && t) val += ' ';
				if(t) val += timeFormat(this.time);
			}
			if(val != old) this.target.val(val).change();
		},
		apply: function(){
			var This = this;
			this.updateValue();
			this.target.trigger('focus');
			setTimeout(function(){
				This.close();
			}, 0);
		},
		opened: false,
		open: function(){
			if(!this.opened){
				this.init();

				$('.input-calendar').each(function(){
					$(this).data('inputCalendar').close();
				});

				this.opened = true;
				$('body').bind('click', this.onoutclick);

				this.parseValue();

				var offset = this.target.offset();
				this.container.css({
					left: offset.left,
					top: offset.top + this.target.outerHeight()
				}).fadeIn();
			}
		},
		close: function(){
			if(this.opened){
				this.opened = false;
				$('body').unbind('click', this.onoutclick);
				this.container.fadeOut();
			}
		},
		display_date: null,
		goTo: function(date){
			if(typeof date != 'undefined') this.display_date = new Date(date);
			this.display_date.setDate(1);
			this.container.find('.year .curr').text(this.display_date.getFullYear());
			this.container.find('.month .curr').text(months.full[this.display_date.getMonth()]);

			var valueStr = dateToStr(this.date);
			var d = new Date(this.display_date), day = d.getDay(), month = d.getMonth(), date;

			if(day > 0) d.setDate(1 - day);
			var items = this.container.find('.dates div'), item, str;
			for(i = 0; i < 42; i++){
				date = d.getDate();
				item = items.eq(i);
				str = dateToStr(d);
				item.attr('class', 'date-'+str).data('date', new Date(d)).find('span').text(date);
				if(d.getMonth() != month) item.addClass('out');
				if(valueStr && valueStr == str) item.addClass('selected');
				d.setDate(date + 1);
			}

		}
	};

	$.fn.inputCalendar = function(options){
		return this.each(function(){
			var el = $(this);
			if(!el.data('inputCalendar')){
				el.data('inputCalendar', new inputCalendar(el, options));
			}
		});
	};

	$.fn.customDatePicker = function(){
		return this.inputCalendar({time: false});
	};

	$.fn.customDateTimePicker = function(){
		return this.inputCalendar();
	};

	$.fn.customTimePicker = function(){
		return this.inputCalendar({date: false});
	};

})(jQuery);

function flip(object){
	var res = {};
	for (var prop in object)
		if(object.hasOwnProperty(prop))
			res[object[prop]] = prop;
	return res;
}
 
function autoCompleteSelect(e)
{
	var selector = '.select-autocomplete';
	$(selector).select2();
}
(function($){
	$(function () {
		autoCompleteSelect();
	});
	})(jQuery);