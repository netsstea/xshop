var jcrop_api;
$(document).ready(function (){
    init_crop_avatar = function(){
        //==========================AVATAR===================================
        coords = false;
        var file_id, avatar, cropped_avatar;

        $('#crop_avatar').click(function(e){
            var coords = $(this).data('coords');
            if(!coords){
                var widht, height, coords = {};
                widht = $('#uploaded_avatar').width();
                height = $('#uploaded_avatar').height();

                coords = {h:height, w:widht, x:0, y:0, x2:widht, y2:height};
            }
            
            data = {coords: coords, file : avatar };
            $.ajax(
                {
                    url : '/file/index/crop-avatar',
                    data:data,
                    dataType: 'json',
                    success: function(jsonData){
                        if (jsonData.success)
                        {
                            cropped_avatar = jsonData.result;
                            $("#cropped_avatar").attr('src', cropped_avatar);
                            $("#crop_div_wrapper").show();
                        }
                    }
                }
            );
            e.preventDefault();
            return false;
        });
        
        $('#use-cropped-avatar').click(function(e){
            if(typeof CL.is_avatar !== 'undefined' && CL.is_avatar == 'concept'){
                $("#old-avatar").attr('src',cropped_avatar);
            }else if (CL.avatar_type == 'user'){
                $("#user-avatar, .member-avatar").attr('src',cropped_avatar);
            }
            $("#old-avatar").attr('src',cropped_avatar);
            
            $("#avatar").val(cropped_avatar);
            $("#_cl_submit").trigger('click');
            //change data-oavatar
            $("#old-avatar").attr('data-oavatar', $("#uploaded_avatar").attr('src'));
            e.preventDefault();
            return false;
        });


        var edx_avatar_upload_cb = function(data, $input) {//, $obj) {
            if(data.success) {
                uploaded = data.result.attachments;
                avatar = uploaded[0];
                $("#uploaded_avatar").attr('src', avatar.link);
                $("#oavatar").val(avatar.link);
                file_id = avatar.id;
                
                setupJcrop(avatar.link);
                
                $("#avatar_actions").show();
                $("#avatar").val(avatar.link);
                //make sure user cannot upload aggain. due to jcrop bugs loading different images
                $("#re-upload-image").show();
                $("form.cl_ajax").hide();
            }
            else
            {
                alert_error('Error: ' +  data.err);
            }
        };
        

        $(".edx_avatar").cl_upload({
            url : '/file/index/upload',
            callback : edx_avatar_upload_cb,
            params : {
                access : 'public',
                type : 'attachment',
                folder : 'avatar'
            }
        });
        
        var setupJcrop = function(imgLink)
        {
            CL.utils.log(imgLink);
            if (jcrop_api)
            {
                jcrop_api.setImage(imgLink);
            }
            else
            {
                $('#uploaded_avatar').Jcrop({
                    /*boxWidth : 600,*/
                    onSelect : function (c){
                        coords = c;
                        $("#crop_avatar").data('coords', coords);
                    }
                }, function(){
                    jcrop_api = this;
                    
                }); 
            }
        }
        
        $("#edit-current-avatar").click(function(e){
            var current_avatar = $("#old-avatar").attr('data-oavatar');
            avatar = {link : current_avatar};
            $("#uploaded_avatar").attr('src', current_avatar);
            setupJcrop(current_avatar);
            $("#avatar_actions").show();
            e.preventDefault();
        });
    };
    init_crop_avatar ();
});    