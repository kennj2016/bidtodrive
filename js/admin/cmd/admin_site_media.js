$(function(){
	
	var mediaBox = $('.media-box');
	var foldersWrap = mediaBox.find('.media-box-folders-wrap');
	var foldersBox = foldersWrap.find('.media-box-folders');
	var foldersSelect = foldersBox.find('select');
	var filesWrap = mediaBox.find('.media-box-files-wrap');
	var filesBox = filesWrap.find('.media-box-files');
	var sizeBox = mediaBox.find('.media-box-size');
	var sortBtns = mediaBox.find('.media-box-options .sort a');
	
	filesWrap.mCustomScrollbar({
		autoHideScrollbar: false,
		theme: "dark-thick",
		scrollInertia: 150
	});
	
	foldersWrap.mCustomScrollbar({
		autoHideScrollbar: false,
		theme: "dark-thick",
		scrollInertia: 150
	});
	
	sortBtns.click(function(){
		var This = $(this), order;
		SiteMedia.sortFiles(This.attr('rel'), !This.is('.active') || This.is('.desc') ? 'asc' : 'desc');
		return false;
	});
	
	foldersSelect.change(function(){
		foldersBox.find('.media-box-folder').eq($(this).find('option:selected').index()).click();
	});
	
	if(!!window.FormData){
		
		if('draggable' in document.createElement('span')){
			
			filesBox.on('dragover', function(){
				filesBox.addClass('dnd');
				return false;
			});
			
			filesBox.on('dragleave', function(){
				filesBox.removeClass('dnd');
				return false;
			});
			
			filesBox.on('drop', function(event){
				filesBox.removeClass('dnd');
				SiteMedia.uploadFiles(event.originalEvent.dataTransfer.files);
				return false;
			});
			
		}
		
		$('.media-box-input-file').on('change', function(){
	    SiteMedia.uploadFiles(this.files);
	  });
	  
	}
  
	var SiteMedia = {
		folders: [],
		files: [],
		currentFolder: null,
		sortFiles: function(sort, order){
			sortBtns.removeClass('active desc asc');
			sortBtns.filter('[rel='+sort+']').addClass(order + ' active');
			if(this.currentFolder) this.currentFolder.sortFiles(sort, order);
		},
		addFolder: function(folder){
			var This = this;
			
			folder.onsizeupdate = function(){
				This.updateSize();
			};
			folder.onupdate = function(){
				$.each(folder.files, function(){
					var file = this, btn = file.container.find('.download');
					filesBox.append(file.container);
					if(!btn.is('.ZeroClipboard')){
						var clip = new ZeroClipboard(btn.addClass('ZeroClipboard'));
						clip.on('mouseover', function(){$(this).closest('.media-box-file').addClass('hover');});
						clip.on('mouseout', function(){$(this).closest('.media-box-file').removeClass('hover');});
					}
				});
				filesWrap.mCustomScrollbar("update");
			};
			
			folder.container.click(function(){
				This.setCurrentFolder(folder);
			});
			
			folder.container.find('.action').click(function(){
				if($(this).is('.remove')) This.removeFolder(folder);
				return false;
			});
			
			foldersBox.append(folder.container);
			foldersSelect.append(folder.option);
			
			foldersWrap.mCustomScrollbar("update");
			
			This.folders.push(folder);
			if(This.folders.length == 1) This.setCurrentFolder();
		},
		uploadFiles: function(files){
			if(this.currentFolder) this.currentFolder.addFiles(files);
		},
		removeFolder: function(folder){
			var This = this;
			defaultConfirmPopup('Are you sure you want to delete this folder?', function(){
				SiteMediaApi.post('remove_folder', folder.record.id, function(){
					folder.container.remove();
					folder.option.remove();
					var folders = [];
					$.each(This.folders, function(){
						if(this !== folder) folders.push(this);
					});
					This.folders = folders;
					if(This.currentFolder === folder) This.setCurrentFolder();
				}, defaultErrorPopup);
			});
		},
		setCurrentFolder: function(folder){
			folder = folder || null;
			if(!folder && this.folders.length) folder = this.folders[0];
			if(folder !== this.currentFolder){
				filesBox.empty();
				filesWrap.mCustomScrollbar("update");
				this.currentFolder = folder;
				if(this.currentFolder){
					$.each(this.folders, function(){this.container.removeClass('active');});
					this.currentFolder.container.addClass('active');
					this.currentFolder.view();
				}
			}
		},
		updateSize: function(){
			var val = '';
			if(this.currentFolder){
				var bytes = this.currentFolder.size, thresh = 1024, u = -1;
		    if(bytes < thresh) val = bytes + ' B';
		    else{
			    do{
			      bytes /= thresh;
			      ++u;
			    }while(bytes >= thresh);
			    val = bytes.toFixed(1)+' '+['KB','MB','GB'][u];
			  }
		  }
			sizeBox.text(val);
		}
	};
	
	
	
	
	
	$.each($.parseJSON(mediaBox.attr('data-folders')), function(){
		SiteMedia.addFolder(new SiteMediaApi.Folder(this));
	});
	
});