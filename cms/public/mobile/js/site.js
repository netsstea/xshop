var get_news_list, get_news_item;
function render_youtube_video(vid)
{
    var ret = '\
        <iframe width="560px" height="420px"' +
                'src="http://www.youtube.com/embed/' + vid + '">' +
                '</iframe>';
        return ret;
    }
   

$(document).ready(function() {
    /*
    function htmlDecode(value){ 
        return $('<div/>').html(value).text(); 
    }
    */
    function format_item(item)
    {
        var re = new RegExp('�', 'g');
        item.name = $.trim(item.name);
        item.name = item.name.replace(re, '');
        if (typeof item.chapo != 'undefined')
            item.chapo = item.chapo.replace(re, '');
        else 
            item.chapo = item.name;
        if (typeof item.content !=='undefined' )
            item.content = item.content.replace(re, '');
        return item;
    }
    
    //get news list
    get_news_list = function(){
        //$("#load_more").html()
        $.mobile.loading( 'show', {
            text: 'Loading...',
            textVisible: true,
            theme: 'a',
            html: ""
        });
        
        $.cl_ajax({
            type: "POST",
            url: listUrl,
            data: { category : localStorage.getItem('cate'), page : page_nr},
            statusCode: {
                404: function() {
                    $("#response").html('Không kết nối được đến .');
                },
                500: function() {
                    $("#response").html('Có lỗi từ phía server.');
                }
            },
            error: function() {
                $.mobile.loading( 'hide');
                alert('A problem has occurred');
            },
            success: function(data) {
                var length = data.result.length;
                var html = '';
                //$("#load_more").html()
                $.mobile.loading( 'hide');

                if ( length > 0)
                {
                    for (var i = 0; i < length; i++) {
                        item = data.result[i];
                        item = format_item(item);
                        html = html + "<li data-url='" + item.url + "' data-theme='c' >" +
                            "<a><img alt='avatar' src='" + item.avatar + "' class='img-thumb'/>" +
                            "<h3 class='title'>" + item.name + "</h3>" +
                            "<p><b style='color:black;'> " + item.category_name + "</b> - " +
                            "<img style='width:15px;height:15px;' src='" + item.host.icon + "' />  " + item.host.name +
                            ", <span class='timeago' title='" + item.ago + "'></span>" + 
                            "</p>" +
                            "<p>" + item.chapo + "</p>" +
                            "</a>";
                        /*
                            "<div class='avatar'><img alt='avatar' src='" + item.avatar + "'/></div>" +
                            "<div class='title'>" + item.name + "</div>" +
                            "<div class='subtitle'>" + item.category_name + " - " + item.host.name + ", 3 giờ trước</div>" +
                            "<div class='chapo'>" + item.chapo + "</div>";
                         */
                            
                    }
                }
                else 
                {
                    html = '<li>-</li>';
                    $("#load_more").hide();
                }
                
                if (page_nr == 1)
                {
                    $("#news_list").find("li[id!='load_more']").remove();
                }

                $(html).insertBefore("#load_more");
                
                $("ul#news_list").listview('refresh');
                $("ul#news_list").show();
                $(".timeago").timeago();

            }
        });
    };
    
    get_news_item = function()
    {
        $.mobile.loading( 'show', {
            text: 'Loading...',
            textVisible: true,
            theme: 'a',
            html: ""
        });
        
        $.cl_ajax({
            type: "GET",
            url: localStorage.getItem('url'),
            data: {},
            error: function() {
                $.mobile.loading( 'hide');
                alert('A problem has occurred');
            },
            success: function(data)
            {
                var item = format_item(data.result);
                
                //html =  "<div class='avatar'><img alt='avatar' src='" + item.avatar + "'/></div>" +
                html = "<div class='title'>" + item.name + "</div>" +
                "<div class='subtitle'>" + item.category_name + " - " + 
                "<img style='width:15px;height:15px;' src='" + item.host.icon + "' />  " + item.host.name +
                //item.host.name + 
                ", <span class='timeago' title='" + item.ago + "'></span></div>" +
                "<div class='chapo2'>" + item.chapo + "</div>";
                html = html + "<div class='content'>" + item.content + "</div>";
                
                $("#header-text, #header-text2").html(item.category_name);
                
                $("#item_content").html(html);//.trigger('create');
                $("#item_content").find('table').removeAttr('width').removeAttr('cellpadding').removeAttr('align');
                $.mobile.loading( 'hide');
                $("#gotopage2").trigger('click');
                current_page = 'view';
                $(".timeago").timeago();
            }
        });
    };
    
    //console.log(window.location.hash);
    if (window.location.hash == '#viewPage')
        get_news_item();
    else
        get_news_list();
      
    
    $('#news_list ').on('click', 'li', function(e) {
        var url = $(this).attr("data-url");
        if (url == '#load')
        {
            page_nr ++;
            
            $("#page_nr").html(page_nr);
            get_news_list();
        }
        else 
        {
            localStorage.setItem('url', url);
            show_page(2);
        }
    });
    
    
    function show_page(i)
    {
        if (i == 2)
        {
            get_news_item();
            //current_page = 'view';
            //$("#viewPage").show().page('create');
        }
        else
        {
            current_page = 'list';        
            $("#gotopage1").trigger('click');
        }
    }
    
    //on menu item click
    $(".category-menu").click(function(e){
        $( "#nav-panel" ).panel( "close" );
        //reset page_nr
        if (localStorage.getItem('cate') !=$(this).attr('data-cate-slug') )
        {
            page_nr = 1;
            $("#load_more").show();
        }
        
        localStorage.setItem('cate',  $(this).attr('data-cate-slug'));
        
        localStorage.setItem('cate-name',  $(this).html());
        if (current_page == 'list')
        {
            get_news_list();
            $("#header-text, #header-text2").html(localStorage.getItem('cate-name'));        
        }
        else 
        {
            //window.location = 'index.html';
            show_page(1);
        }
        //$(this).parent().siblings().attr('data-theme', 'a');
        e.preventDefault();
        return false;
    });
    
    $("#refresh-btn").click(function(){
       page_nr = 1;
       $("#load_more").show();
       get_news_list();
    });
    
    $("#refresh-view-btn").click(function(){
        get_news_item();
    });
    
    $("#news_list_wrapper").on("swipeleft", function(){
        $("#nav-panel").panel("open");
    });

    $("#item_content").on( "swipeleft", function(){
        $("#back-btn").trigger('click');
    });
    $("#back-btn").click(function(e){
        show_page(1);
        e.preventDefault();
        return false;
    });

});
