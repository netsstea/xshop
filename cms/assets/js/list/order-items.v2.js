$(function(){
$(document).on('click', ".add-concept-to-group", function(){
        
        $div = $(this).closest('.item-bank');
        if ($div.hasClass('item-exists'))
        {
            alert("Already added");
            return false;
        }
        
        var item = $div.data('item');
        
        //search for current items and see if it already exists
        var alreadyExists = false;
        $("#concept-list .sortable-item").each(function(){
            if ($(this).attr('data-item-id') == item.id)
            {
                alreadyExists = true;
            } 
        });     
        if (!alreadyExists)
        {
            var tpl = $("#item-template").text();
            var hoganTemplate = Hogan.compile(tpl);
            var html = hoganTemplate.render(item);
            $("#concept-list").append(html);
            $(this).closest('.item-bank').addClass('item-exists');    
        }
        else 
        {
            alert("Item already exists in the list");
        }
    });


    $("#checkboxlist").on('click', "input[name='checklist']", function() {
        //hide one or multiples category template for 
        //better visual adding news 
        var $this = $(this);
        var $parent = $this.parent();
        var $checked = $this.prop('checked');
        $id = $parent.attr('data-id');
        if($checked){
            $('#'+$id).hide();    
        }
        else
            $('#'+$id).show();
    }); 
    
    $(document).on('click', ".remove-from-list", function(){
        var id = $(this).attr('data-id');
        $(this).closest('.sortable-item').remove();
        $(".item-bank[data-item-id='" + id + "']").removeClass('item-exists');
    });
    
    var update_list_data = function ($step, $el){
        var itemsArr = [];
        var stickyItemsArr = [];
        var $conceptlist = $el.closest('div.connectedSortable');
        var url = $conceptlist.attr('data-href');
        var rowId = $conceptlist.attr('data-id');
        $conceptlist.find('div.card').each(function(i, el){
            if($(this).attr('data-sticked') === 'yes')
                stickyItemsArr.push($(this).attr('data-item-id'));               
            itemsArr.push($(this).attr('data-item-id'));
        });
        console.log(itemsArr);
        console.log(stickyItemsArr);
        
        var postdata = {
                items_order: itemsArr, 
                items_sticky: stickyItemsArr,
                '_cl_submit':1,
                item_id: rowId
        };
        postdata._cl_step = $step;
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: postdata,
            success: function(data){
                if (!data.success)
                {
                    alert_error(data.err);
                }
                else 
                {
                    var msg = 'Update Successful';
                    alert_success(msg);
                }
                
            }
        });
    }
    
    $(".update-items-list").click(function(e){
        update_list_data('list_items_order',$(this)); 
        //initialize 
    });
    
    $(document).on('click', 'a.sticky', function(e){
        $this = $(this);
       //create new data-sticky add to parent.
       //and create object when press update button
       $parent = $this.closest('div.card');
       var $sticky = $parent.attr('data-sticked');
       if($sticky == 'yes'){
           $parent.attr('data-sticked','no');
           $this.find('i').attr('style','');    
       }
       if($sticky == 'no'){
           $parent.attr('data-sticked','yes');
           $this.find('i').attr('style','color: red');           
       }
       update_list_data('list_items_sticky',$(this)); 
    });

    CL['callbacks']['list-items-order-search-items'] = function ($form, data, params){
        var gen_pagination_html = function(page, per_page, page_count)
        {
             var tpl = $("#search-result-pagination-tpl").text();
             var data = [];
             var pages = [1,2,3, page -1 , page , page + 1, page_count];
             
             pages.sort().filter(function(el,i,a) {
                 if(i == a.indexOf(el))
                     return 1;
                 return 0
             });
             pages = remove_dupes(pages);
             
             for (i in pages)
             {
                 p = pages[i];
                 if (p > 0 && p <= page_count)
                 {
                     var item = {
                             page : p
                     };
                     if (p == page)
                         item.active = "active";
                     else 
                         item.active = "";
                     
                     if (p == 1 && page != 1)
                         item.page_display = 'First';
                     else if (p == page_count && page != page_count)
                         item.page_display = 'Last';
                     else 
                         item.page_display = p;
                     data.push(item);
                 
                 }
             }

             
             var hoganTemplate = Hogan.compile(tpl);
             var html = hoganTemplate.render({list : data});
             return html;
             
        };
        
        if (data.success)
        {
            var total = parseInt(data.total);
            var page = $("#page").val() || 1;
            var page = parseInt(page);
            var per_page = parseInt($("#items_per_page").val());
            
            
            var currentIdList = [];
            $("#concept-list .sortable-item").each(function(){
                currentIdList.push($(this).attr('id'));
            });
            var tpl = $("#search-result-item-tpl").text();
            l = []; // list of items 
            for (i in data.result)
            {
                var item = data.result[i];
                if (currentIdList.indexOf(item['id']) != -1)
                    item['item-exists'] = 'item-exists';
                else 
                    item['item-exists'] = '';
                
                item.title = item['name'];
                //item.name = 
                item.idx = parseInt((page - 1) * per_page + parseInt(i) + 1);
                l.push(item);
            }
            
            var hoganTemplate = Hogan.compile(tpl);
            var html = hoganTemplate.render({result : l});
            
            
            $("#search-results").html(html);
            
            //populate item data back
            $("#search-results .item-bank").each(function(){
                var id = $(this).data('item-id');
                var item = {};
                
                for (i in l)
                {
                    if (l[i]['id'] == id)
                    {
                        item = l[i];
                        break;
                    }
                }
                $(this).data('item', item);
            });
            //now pagination
            
            var pageCount = Math.ceil((total + 1) / per_page);
            $("#search-results-pagination").html(gen_pagination_html(page, per_page, pageCount));
            populate_sortable_items();
        }
    };    
    function populate_sortable_items(){
        $(".connectedSortable").on('click', 'div', function (e) {
            if (e.ctrlKey || e.metaKey) {
                $(this).toggleClass("selected");
            } else {
                $(this).addClass("selected").siblings().removeClass('selected');
            }
        }).sortable({
            connectWith: ".connectedSortable",
            delay: 150, //Needed to prevent accidental drag when trying to select
            revert: 0,
            helper: function (e, item) {
                //Basically, if you grab an unhighlighted item to drag, it will deselect (unhighlight) everything else
                if (!item.hasClass('selected')) {
                    item.addClass('selected').siblings().removeClass('selected');
                }
                
                //////////////////////////////////////////////////////////////////////
                //HERE'S HOW TO PASS THE SELECTED ITEMS TO THE `stop()` FUNCTION:
                
                //Clone the selected items into an array
                var elements = item.parent().children('.selected').clone();
                
                //Add a property to `item` called 'multidrag` that contains the 
                //  selected items, then remove the selected items from the source list
                item.data('multidrag', elements).siblings('.selected').remove();
                
                //Now the selected items exist in memory, attached to the `item`,
                //  so we can access them later when we get to the `stop()` callback
                
                //Create the helper
                var helper = $('<div/>');
                return helper.append(elements);
            },
            stop: function (e, ui) {
                //Now we access those items that we stored in `item`s data!
                var elements = ui.item.data('multidrag');
                
                //`elements` now contains the originally selected items from the source list (the dragged items)!!
                
                //Finally I insert the selected items after the `item`, then remove the `item`, since 
                //  item is a duplicate of one of the selected items.
                ui.item.after(elements).remove();
            }
        });
    }
    $("#_cl_submit").trigger('click');
    populate_sortable_items();

});