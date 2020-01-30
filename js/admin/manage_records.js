(function($){

	var html = ''
	+'<div class="input-popup-wrap">'
		+'<div class="input-popup-value"></div>'
		+'<div class="input-popup">'
			+'<div class="input-popup-action apply">Apply</div>'
			+'<div class="input-popup-action clear">Clear</div>'
			+'<div class="input-popup-input"></div>'
			+'<div class="input-popup-orig"></div>'
		+'</div>'
	+'</div>';

  $.fn.inputPopup = function(options){return this.each(function(){
  	var target = $(this);

		if(target.data('input-popup')) return true;

		var popup = $(html);
		var input = target.clone();
  	popup.find('.input-popup-input').append(input);
  	popup.find('.input-popup-input :input').each(function(){
  		var This = $(this);
  		This.attr('name', 'input-popup-' + This.attr('name'));
  	});

  	function clear(){
  		popup.find('.input-popup-input :input').each(function(){
  			var This = $(this);
  			if(This.is('select')) This.val([]);
  			else if(This.is('[type=radio],[type=checkbox]')) This.prop('checked', false);
  			else This.val('');
  		});
  	}

  	function apply(){
  		var copy = popup.find('.input-popup-input :input');
  		var orig = popup.find('.input-popup-orig :input');
  		copy.each(function(index){
  			var This = $(this);
  			if(This.is('[type=radio],[type=checkbox]')) orig.eq(index).prop('checked', This.prop('checked'));
  			else orig.eq(index).val(This.val());
  		});
			value();
			orig.change();
  	}

  	function value(){
  		var arr = [], text = '';
			function push(t){
				t = t.replace(/^\s+|\s$/, '');
				if(t != '') arr.push(t);
			}
			popup.find('.input-popup-input :input').each(function(){
				var t, input = $(this);
				if(input.is('select')){
					var selected = input.find(':selected');
					if(!selected.length && !input.prop('multiple')) selected = input.find(':first');
					selected.each(function(){
						var opt = $(this);
						if(opt.val() != '') push(opt.text() || opt.val());
					});
				}else if(input.is('[type=radio],[type=checkbox]')){
					if(input.is(':checked')) push(input.parent().text() || input.val());
				}else push(input.val());
			});
			if(popup.find('.date-filter').length){
				if(arr.length == 3) text = (popup.find('[name*=from_date]').val() > 0 ? 'from' : 'to') + ' ' + arr.join('.');
				else if(arr.length == 6) text = 'from ' + arr.slice(0, 3).join('.') + ' to ' + arr.slice(3).join('.');
			}else{
				text = arr.join(', ');
			}
			popup.find('.input-popup-value').text(text);
		}
		value();

		function applyPopup(){
			apply();
			close();
		}
		
		function removeCookie(){
			document.cookie = "admin_list_state["+$("body").attr("class").match(/cmd\-([a-z\d\_]+)/)[1]+"]=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=" + location.pathname;
		}

		function close(){
			$('body').unbind('click', click);
			popup.removeClass('focus').find('.input-popup').hide();
		}

		function open(){
			$('.input-popup-wrap').each(function(){
				$(this).data('api').close();
			});
			popup.addClass('focus').find('.input-popup').show().find(':input:first').focus();
			popup.find('select').customSelect();

			popup.find('.range-bar').slider({
				range: true,
				create: function(event, ui){
					$(this).slider('option', 'min', $(this).data('min'));
					$(this).slider('option', 'max', $(this).data('max'));
					var rangeFilter = $(this).closest('.range-filter');
					var fromVal = rangeFilter.find('[name*="[from]"]').val() ? rangeFilter.find('[name*="[from]"]').val() : $(this).data('min');
					var toVal = rangeFilter.find('[name*="[to]"]').val() ? rangeFilter.find('[name*="[to]"]').val() : $(this).data('max');
					$(this).slider('option', 'values', [fromVal, toVal]);
					rangeFilter.find('[name*="[from]"]').val(fromVal);
					rangeFilter.find('[name*="[to]"]').val(toVal);
				},
				slide: function(event, ui){
					var rangeFilter = $(this).closest('.range-filter');
					rangeFilter.find('[name*="[from]"]').val(ui.values[0]);
					rangeFilter.find('[name*="[to]"]').val(ui.values[1]);
				}
			});

  		$('body').bind('click', click);
		}

		function click(e){
			if(!$(e.target).closest(openLink).length) close();
		}

		var openLink = popup.find('.input-popup-value');
		if(options && options.link) openLink = openLink.add(options.link);

  	openLink.click(function(e){
  		if(!$(e.target).closest('.input-popup').length){
  			open();
  			return false;
  		}
  	});
  	popup.find('.input-popup-action.apply').click(function(){
  		applyPopup();
  		return false;
  	});
  	popup.find('.input-popup-action.clear').click(function(){
  		clear();
  		removeCookie();
  		applyPopup();
  		return false;
  	});

		target.data('input-popup', true).before(popup);
  	popup.data('api', {close: close}).find('.input-popup-orig').append(target);

  });};

})(jQuery);

$(function(){

	function getIds(target){
		var ids = [], id = $(target).attr('data-id');
		if(id){
			if(id == 'batch') $('[name="batch_ids[]"]:checked').each(function(){ids.push($(this).val());});
			else ids.push(id);
		}
		return ids;
	}

	$('[data-batch-ids]').change(function(){
		var This = $(this);
		This.closest(This.attr('data-batch-ids')).find('[name="batch_ids[]"]').prop('checked', This.is(':checked'));
	});

	$('body').on('click', '[data-post-action]', function(event){
		var This = $(event.target), action = This.attr('data-post-action'), ids = getIds(event.target);
		if(ids.length){
			var post = function(){
				form_post('', {action: action, ids: ids});
			};
			if(action == 'delete') defaultConfirmPopup("Are you sure you want to delete this record(s)?", post);
			else if(action == 'approvex'){

			}
			else post();
		}
		return false;
	})
		.on('click', '[data-row-action]', function(event){
		var
			This = $(event.target).closest('[data-row-action]'),
			val = This.attr('data-row-action').split(','),
			target = This.closest('tr').find(val[0]);
		switch(val.length > 1 ? val[1] : null){
			case 'href': location.assign(target.attr('href')); break;
			default: target.click();
		}
	});

	$('[data-load-more]').each(function(){
		var container = $(this), win = $(window), busy = false, errors = 0, retry = 3, page = 1, view = container.attr('data-load-more');

		function error(){
			errors++;
			if(errors >= retry) unbind();
		}

		function unbind(){
			win.unbind('scroll resize orientationchange', check);
		}

		function check(){
			if(busy) return;
			if(!container.is(':visible')) return;
			if(container.offset().top + container.height() > win.scrollTop() + win.height()) return;
			$.ajax({
				url: window.location.href,
				data: {page: page + 1, view: view},
				dataType: 'json',
				success: function(response){
					if(response.html){
						container.append(response.html);
						container.find('.ui-sortable').sortable("refresh");
						applyTruncate();
						page++;
					}else error();

					if(response.has_more) check();
					else unbind();
				},
				error: error,
				complete: function(){
					busy = false;
				}
			});
			busy = true;
		}

		win.bind('scroll resize orientationchange', check);
		check();

	});

	function goTo(u){
		if(!URI().equals(u)) location.assign(u);
	}
	
	function removeCookie(){
		document.cookie = "admin_list_state["+$("body").attr("class").match(/cmd\-([a-z\d\_]+)/)[1]+"]=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=" + location.pathname;
	}

	var sortableColumn = $('.records-list [data-sort-by]');
	sortableColumn.click(function(){

		var sorted = sortableColumn.filter('[data-sorted]');

		var
			u = URI(),
			csort = sorted.attr('data-sort-by'),
			corder = sorted.attr('data-sorted'),
			sort = $(this).attr('data-sort-by'),
			order = 'asc';

		u.removeSearch(['sort', 'order']).addSearch('sort', sort);

		if(csort == sort) order = corder == 'asc' ? 'desc' : 'asc';
		if(order != 'asc') u.addSearch('order', order);

		goTo(u);

		return false;
	});

	var filters = $('.section-filter');

	filters.each(function(){
		var
			filterDiv = $(this),
			titleDiv = filterDiv.find('.section-filter-title'),
			inputs = filterDiv.find(':input'),
			names = [],
			u = URI();

		inputs.each(function(){
			names.push(this.name);
		});

		var inputPopupTarget = inputs.length == 1 ? inputs : inputs.closest('.section-filter-input');
		inputPopupTarget.inputPopup({link: filterDiv.find('.section-filter-text')});

		function updateStatus(){
			if(filterDiv.find('.input-popup-value').text() != ''){
				filterDiv.addClass('active');
				titleDiv.text(titleDiv.text().replace(':', '') + ':');
			}else{
				filterDiv.removeClass('active');
				titleDiv.text(titleDiv.text().replace(':', ''));
			}
		}
		updateStatus();

		inputs.change(function(){
			updateStatus();
			u.removeSearch(names);
			inputs.each(function(){
				var This = $(this), val = This.val();
				if(This.is('[type=radio],[type=checkbox]') && !This.is(':checked')) val = null;
				if(val) u.addSearch(this.name, val);
			});
			goTo(u);
			return false;
		});

	});

	$('.section-filters-actions .clear').click(function(){
		$('body').click();

		var names = [], u = URI();

		filters.each(function(){
			$(this).find(':input').each(function(){
				names.push(this.name);
			});
		});
		
		removeCookie();
		u.removeSearch(names);
		goTo(u);
		
		return false;
	});

	$('[data-action-move]').closest('.sortable-containment').each(function(){
		var containment = $(this);
		var from_index = null;
		var url = (new URI).path().toString().replace(/\/$/, '') + '/';

		function getIndex(item){
			return containment.find('> tr:not(.ui-sortable-placeholder)').index(item);
		}

		function getPosition(item){
			return parseInt(item.find('[data-action-move]').attr('data-action-move'), 10);
		}

		function setPosition(item, pos){
			return item.find('[data-action-move]').attr('data-action-move', pos);
		}

		if(containment.find('[data-action-move="none"]').length){
			containment.find('[data-action-move]').on('mousedown', function(){
				var pr = $('[data-positions-relations]');
				if(pr.length){
					defaultInfoPopup(
						'To order this content you need to filter items by single ' + pr.attr('data-positions-relations') + ' and order by position ascending (default sorting).'
					);
				}else defaultConfirmPopup(
					'You cannot re-order content when a sort or filter is applied. Display content in default setting?',
					function(){
						removeCookie();
						goTo(url);
					}
				);
			});
		}else{

			containment.sortable({
				handle: ".action-move",
				appendTo: document.body,
				scroll: false,
				forceHelperSize: true,
				forcePlaceholderSize: true,
				helper: function(event, item){
					return $('<table class="records-list">').append(item.clone()).css('margin', 0)[0];
				},
				start: function(event, ui){
					from_index = getIndex(ui.item);
				},
				update: function(event, ui){
					var to_index = getIndex(ui.item);
					var from = getPosition(ui.item);
					var to = to_index - from_index + from;
					var from_id = $('[data-action-move='+from+']').attr('data-id');
					var to_id = $('[data-action-move='+to+']').attr('data-id');

					if(from != to){
						containment.sortable('disable');
						$.post(url + 'positions/', {from: from, to: to, from_id: from_id, to_id: to_id}, function(response){
							if(response.has_error) defaultErrorPopup(response.status);
							else{
								containment.find('> tr').each(function(){
									var item = $(this), p = getPosition(item);
									if(from < to){
					          if(p > from && p <= to) setPosition(item, p - 1);
					        }else if(from > to){
					          if(p >= to && p < from) setPosition(item, p + 1);
					        }
								});
								setPosition(ui.item, to);
								containment.sortable('enable');
							}
						}, 'json');
					}

				}
			});

		}

	});

	function applyTruncate(){
		$('.records-list .truncate').hide().each(function(){
			var div = $(this);
			div.css('width', div.parent().width());
		}).show();
	}//applyTruncate
	applyTruncate();

	$(window).bind('resize orientationchange', applyTruncate);

});