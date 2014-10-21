<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/upload/css/styles.css" />
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/ui.all.css" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jstree/jquery.tree.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script src="view/javascript/jquery/upload/jquery.filedrop.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.zclip.js"></script>
</head>
<body>
<div id="container">
  <div id="menu"><a id="create" class="button" style="background-image: url('view/image/filemanager/folder.png');">New Folder</a><?php if($user_group_id == 1) { ?><a id="delete" class="button" style="background-image: url('view/image/filemanager/edit-delete.png');">Delete</a><a id="move" class="button" style="background-image: url('view/image/filemanager/edit-cut.png');">Move</a><a id="copy" class="button" style="background-image: url('view/image/filemanager/edit-copy.png');">Copy</a><a id="rename" class="button" style="background-image: url('view/image/filemanager/edit-rename.png');">Rename</a><?php } ?><a id="upload" class="button" style="background-image: url('view/image/filemanager/upload.png');">Upload</a><a id="refresh" class="button" style="background-image: url('view/image/filemanager/refresh.png');">Refresh</a></div>
  <div id="column_left"></div>
  <div id="column_right"></div>
</div>
		<!-- Including the HTML5 Uploader plugin -->
<script type="text/javascript"><!--
$(document).ready(function () {
	$('#column_left').tree({
		data : { 
			type : 'json',
			async : true, 
			opts : { 
				method : 'POST', 
				url : 'index.php?route=common/upload/directory'
			} 
		},
		selected : 'top',
		ui : {		
			theme_name : 'classic',
			animation  : 300
		},	
		types : { 
			'default' : {
				clickable      : true,
				renameable     : false,
				deletable      : false,
				creatable      : false,
				draggable      : false,
				max_children   : -1,
				max_depth	   : -1,
				valid_children : 'all',
			}
		},
		callback : {
			beforedata : function(NODE, TREE_OBJ) { 
				if (NODE == false) {
					TREE_OBJ.settings.data.opts.static = [ 
						{
							data : 'image',
							attributes : { 
								'id' : 'top',
								'directory' : ''
							}, 
							state : 'closed'
						}
					];
					
					return { 'directory' : '' } 
				} else {
					TREE_OBJ.settings.data.opts.static = false;  
					
					return { 'directory' : $(NODE).attr('directory') } 
				}
				

			},		
			onselect : function (NODE, TREE_OBJ) {
				if (NODE == false) {
					directory = '';
				} else {
					directory = $(NODE).attr('directory') + '/';
				}
				
				$.ajax({
					url: 'index.php?route=common/upload/files',
					type: 'POST',
					data: 'directory=' + encodeURIComponent($(NODE).attr('directory')),
					dataType: 'json',
					success: function(json) {
						html = '<div>';
						
						if (json) {
							for (i = 0; i < json.length; i++) {
								
								filename = json[i]['filename'];
								
								name += json[i]['size'];
								
								html += '<a id="imager'+i+'" file="' + json[i]['file'] + '"><span class="preview"><img src="' + json[i]['thumb'] + '" title="' + json[i]['filename'] + '" /><input onclick="this.select();" class="imagename" id="ipimager'+i+'" value="' + '<?php echo $http_image; ?>' + directory + json[i]['filename'] +'" /></span></a>';
							}
						}
						html += '</div>';
						$('#column_right').html(html);
					}
				});				
			}
		}
	});	
	
	$('#column_right a').live('click', function () {
		if ($(this).attr('class') == 'selected') {
			$(this).removeAttr('class');
		} else {
			$('#column_right a').removeAttr('class');
			
			$(this).attr('class', 'selected');
		}
	});
	
						
	$('#create').bind('click', function () {
		var tree = $.tree.focused();
		
		if (tree.selected) {
			$('#dialog').remove();
			
			html  = '<div id="dialog">';
			html += 'Folder Name: <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
			html += '</div>';
			
			$('#column_right').prepend(html);
			
			$('#dialog').dialog({
				title: 'New Folder',
				resizable: false
			});	
			
			$('#dialog input[type=\'button\']').bind('click', function () {
				$.ajax({
					url: 'index.php?route=common/upload/create',
					type: 'POST',
					data: 'directory=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} else {
							alert(json.error);
						}
					}
				});
			});
		} else {
			alert('<?php echo $error_directory; ?>');	
		}
	});
<?php if($user_group_id == 1) { ?>	
	$('#delete').bind('click', function () {
		path = $('#column_right a.selected').attr('file');
							 
		if (path) {
			$.ajax({
				url: 'index.php?route=common/upload/delete',
				type: 'POST',
				data: 'path=' + path,
				dataType: 'json',
				success: function(json) {
					if (json.success) {
						var tree = $.tree.focused();
					
						tree.select_branch(tree.selected);
						
						alert(json.success);
					}
					
					if (json.error) {
						alert(json.error);
					}
				}
			});				
		} else {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				$.ajax({
					url: 'index.php?route=common/upload/delete',
					type: 'POST',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});			
			} else {
				alert('<?php echo $error_select; ?>');
			}			
		}
	});

	
	$('#move').bind('click', function () {
		$('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += 'Move: <select name="to"></select> <input type="button" value="Submit" />';
		html += '</div>';

		$('#column_right').prepend(html);
		
		$('#dialog').dialog({
			title: 'Move',
			resizable: false
		});

		$('#dialog select[name=\'to\']').load('index.php?route=common/upload/folders');
		
		$('#dialog input[type=\'button\']').bind('click', function () {
			path = $('#column_right a.selected').attr('file');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=common/upload/move',
					type: 'POST',
					data: 'from=' + encodeURIComponent(path) + '&to=' + encodeURIComponent($('#dialog select[name=\'to\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
							alert(json.success);
						}
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=common/upload/move',
					type: 'POST',
					data: 'from=' + encodeURIComponent($(tree.selected).attr('directory')) + '&to=' + encodeURIComponent($('#dialog select[name=\'to\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.select_branch('#top');
								
							tree.refresh(tree.selected);
							
							alert(json.success);
						}						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});				
			}
		});
	});

	$('#copy').bind('click', function () {
		$('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += 'Name: <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
		html += '</div>';

		$('#column_right').prepend(html);
		
		$('#dialog').dialog({
			title: 'Copy',
			resizable: false
		});
		
		$('#dialog select[name=\'to\']').load('index.php?route=common/upload/folders');
		
		$('#dialog input[type=\'button\']').bind('click', function () {
			path = $('#column_right a.selected').attr('file');
							 
			if (path) {																
				$.ajax({
					url: 'index.php?route=common/upload/copy',
					type: 'POST',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
							
							tree.select_branch(tree.selected);
							
							alert(json.success);
						}						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			} else {
				var tree = $.tree.focused();
				
				$.ajax({
					url: 'index.php?route=common/upload/copy',
					type: 'POST',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 						
						
						if (json.error) {
							alert(json.error);
						}
					}
				});				
			}
		});	
	});
	
	$('#rename').bind('click', function () {
		$('#dialog').remove();
		
		html  = '<div id="dialog">';
		html += 'Name: <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
		html += '</div>';

		$('#column_right').prepend(html);
		
		$('#dialog').dialog({
			title: 'Rename',
			resizable: false
		});
		
		$('#dialog input[type=\'button\']').bind('click', function () {
			path = $('#column_right a.selected').attr('file');
							 
			if (path) {		
				$.ajax({
					url: 'index.php?route=common/upload/rename',
					type: 'POST',
					data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
							
							var tree = $.tree.focused();
					
							tree.select_branch(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});			
			} else {
				var tree = $.tree.focused();
				
				$.ajax({ 
					url: 'index.php?route=common/upload/rename',
					type: 'POST',
					data: 'path=' + encodeURIComponent($(tree.selected).attr('directory')) + '&name=' + encodeURIComponent($('#dialog input[name=\'name\']').val()),
					dataType: 'json',
					success: function(json) {
						if (json.success) {
							$('#dialog').remove();
								
							tree.select_branch(tree.parent(tree.selected));
							
							tree.refresh(tree.selected);
							
							alert(json.success);
						} 
						
						if (json.error) {
							alert(json.error);
						}
					}
				});
			}
		});		
	});
<?php } ?>

	new AjaxUpload('#upload', {
		action : 'index.php?route=common/upload/upload',
		name : 'image',
		autoSubmit : false,
		responseType: 'json',
		onChange: function(file, extension) {
			var tree = $.tree.focused();
			
			if (tree.selected) {
				this.setData({'directory' : $(tree.selected).attr('directory')});
			} else {
				this.setData({'directory' : ''});
			}
			
			this.submit();
		},
		onSubmit: function(file, extension) {
			$('#upload').append('<img src="view/image/loading.gif" id="loading" style="padding-left: 5px;" />');
		},
		onComplete: function(file, json) {
			if (json.success) {
				var tree = $.tree.focused();
					
				tree.select_branch(tree.selected);
				
				alert(json.success);
			}
			
			if (json.error) {
				alert(json.error);
			}
			
			$('#loading').remove();	
		}
	});
	
	$('#refresh').bind('click', function () {
		var tree = $.tree.focused();
		
		tree.refresh(tree.selected);
	});

$(function(){
	
	var dropbox = $('#column_right'),
		message = $('.message', dropbox);
		
	var tree = $.tree.focused();
	
			if (tree.selected) {
				directory = $(tree.selected).attr('directory');
			} else {
				directory = '';
			}
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'image',
		
		maxfiles: 50,
    	maxfilesize: 2,
		url: 'index.php?route=common/upload/uploaddragdrop',
		uploadFinished:function(i,file,response){
			$.data(file).addClass('done');
			
			if (response.success) {
				filesname = response.success;
			} else {
				filesname = file.name;
			}
			
			$.data(file).find('input[id="imagename'+i+'"]').attr('value','<?php echo $http_image; ?>' + directory + filesname);
			// response is the JSON object that post_file.php returns
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');
				
				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			createImage(file,i);
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		}
    	 
	});
	

	
	
	function createImage(file,i){
	var template = '<a id="file" file="'+file.name+'">'+
						'<span class="preview">'+
							'<img />'+
							'<input type="hidden" id="copypath" />'+
							'<span class="uploaded"></span>'+
							'<input onclick="this.select();" class="imagename" id="imagename'+i+'" />'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
						'</div>'+
					'</a>';
		var preview = $(template), 
			image = $('img', preview);
			i = $('input[id="imagename'+i+'"]', preview);
			
			
		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			
			// e.target.result holds the DataURL which
			// can be used as a source of the image:
			
			image.attr('src',e.target.result);
		
			
		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);
		
		message.hide();
		dropbox.prepend(preview);
		
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}

});

	
});
//--></script>
</body>
</html>