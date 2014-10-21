CL.tinymceIniter = function()
{
    var applicable = [
                      'syllabus/index/new',
                      'syllabus/index/update',
                      'course/index/new',
                      'course/index/update',
                      'lesson/index/view',
                      'lesson/index/exercise',
                      'lesson/index/new',
                      'lesson/index/update',
                      'exercise/index/new',
                      'exercise/index/update',
                      'question/index/new',
                      'question/index/update',
                      'concept/index/new',
                      'concept/index/update',
                      'story/index/new',
                      'story/index/update',
                      'category/index/new',
                      'category/index/update',
                      'take/index/view',
    ];
    
    if (applicable.length > 0 && applicable.indexOf(CL.page) == -1)
    {
        CL.utils.log("tinymceIniter not applicable");
        return;
    }

    CL.utils.log('tinymceIniter is applicable');

$(document).ready(function (){

    if (CL.APPLICATION_ENV == 'development')
        tinyMCE.baseURL = CL.SAND_ASSETS_CDN + '/js/tinymce/tinymce/';
    else 
        tinyMCE.baseURL = CL.ASSETS_CDN + '/js/tinymce/tinymce/';

    var commonConfigs = {
        selector: "textarea.isEditor",
        theme: "modern",
        resize : 'both',
        //outdent indent 
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        toolbar_items_size : 'small',
        menubar : false ,
        content_css : CL.ASSETS_CDN + "/css/tinymce.css",  //CL.ASSETS_CDN = "http://edxassets.local/";
        forced_root_block : 'div',
            invalid_elements : "strong,em,script"
    };
    
    var teacherConfigs = {
        plugins: [
                  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                  "searchreplace wordcount visualblocks visualchars code fullscreen",
                  "insertdatetime media nonbreaking save table contextmenu",
                  "emoticons template paste textcolor"
        ],
        toolbar1: "insertfile undo redo | styleselect removeformat | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons | v1 v2 | code",
        //contextmenu: "link image v1 v2",
        file_browser_callback: function(field_name, url, type, win) { 
            tinymce.activeEditor.windowManager.open({
                title: "File browser",
                url: "/media/browse?tinymce=1&_cl_ajax=1",
                width: 800,
                height: 600
            }, {
                oninsert: function(url) {
                    win.document.getElementById(field_name).value = url; 
                }
            });
        }            
    };
    
    var studentConfigs = {
        plugins: [
                  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                  "searchreplace wordcount visualblocks visualchars code fullscreen",
                  "insertdatetime media nonbreaking save table contextmenu",
                  "emoticons template paste textcolor"
        ],
        toolbar1: "insertfile undo redo | styleselect removeformat | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons"
    };
    
    var otherConfigs = {
        plugins: [
                  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                  "searchreplace wordcount visualblocks visualchars code fullscreen",
                  "insertdatetime media nonbreaking save table contextmenu directionality",
                  "emoticons template paste textcolor"
        ],
        toolbar1: "insertfile undo redo | styleselect removeformat | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
    };
    
    teacherConfigs = $.extend(teacherConfigs, commonConfigs);
    studentConfigs = $.extend(studentConfigs, commonConfigs);
    
    CL.editorConfigs = {
        'teacher' :     teacherConfigs,
        'student' :     studentConfigs,
        'common' : 		studentConfigs
    };
    
    tinymce.init(CL.editorConfigs['teacher']);
});

};
CL.tinymceIniter();