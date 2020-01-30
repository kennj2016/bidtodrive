$(function(){
	var wrap = $('.revisions-wrapper');
	if(!wrap.length) return;
	(function(){
		
		var
			delay = (parseFloat(wrap.attr('data-delay') || 0) || 10) * 60, tid,
			url = (new URI).path().toString().replace(/\/$/, '') + '/',
			autosaveUrl = url+'autosave/',
			get = URI.parseQuery((new URI()).search()),
			revision_id = get.revision_id || null,
			mainTpl = tmpl("revision-main"),
			mobileTpl = tmpl("revision-mobile"),
			mainList = wrap.find('.revisions-main'),
			mobileList = wrap.find('.revisions-mobile'),
			frm = $('form.autosave'),
			popupAutosave = $('<div class="autosaveStatus"></div>').hide().appendTo('body'),
			popupAutosaveTid = null;
			
		function addRevision(revision, first){
			var method = first ? 'prepend' : 'append', opt = {
				id: revision.revision_id,
				date: revision.revision_datetime,
				name: htmlentities(revision.revision_author_name),
				href: url + (revision.revision_status == 1 ? '' : '?revision_id=' + revision.revision_id),
				status: revision_id && revision.revision_id == revision_id || !revision_id && revision.revision_status == 1 ? 'off' : 'on'
			};
			mainList[method](mainTpl(opt));
			mobileList[method](mobileTpl(opt));
		}
		
		$.get(autosaveUrl, function(response){
			if(response.has_error) defaultErrorPopup(response.status);
			else if(response.revisions) $.each(response.revisions, function(){
				addRevision(this);
			});
		}, 'json');
		
		function showAutosaveStatus(date){
			if(popupAutosaveTid){
				clearTimeout(popupAutosaveTid);
				popupAutosaveTid = null;
			}
			popupAutosave.html('Autosaved on '+date.substring(5,10)+'-'+date.substring(0,4)+' '+date.substring(10)).fadeIn();
			popupAutosaveTid = setTimeout(function(){
				popupAutosave.fadeOut();
			}, 4000);
		}
		
		function autosave(){
			timeout();
			
			frm.find('textarea').ckeditorUpdateElement();
			$.post(autosaveUrl, frm.serialize(), function(response){
				if(response.has_error){
					if(tid){
						clearTimeout(tid);
						tid = null;
					}
					defaultErrorPopup(response.status);
				}else{
					addRevision(response.revision, true);
					showAutosaveStatus(response.revision.revision_datetime);
				}
			}, 'json');
		}
		
		function timeout(){
			tid = setTimeout(autosave, delay * 1000);
		}
		
		if(frm.length) timeout();
	
	})();
});