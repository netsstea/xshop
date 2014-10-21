$(document).ready(function (){
    $.fn.liveDraggable = function (opts) {
        this.on("mouseover", function() {
           if (!$(this).data("init")) {
              $(this).data("init", true).draggable(opts);
           }
        });
        return $();
     };
     $.fn.liveDroppable = function (opts) {
        this.on("mouseenter", function() {
           if (!$(this).data("init")) {
              $(this).data("init", true).droppable(opts);
           }
        });
        return $();
     };
    /**
     * Draggable & Droppable & Sortable
     */
    var receive_new_item = function(event,item)
    {
        //var item = ui.item;
        if(item.attr('question-id')) {//new question from question bank
            // change href
            //convert the item from question bank to exercise format
            var updateLink = item.find("a:first").attr('href');
            var questionUpdateLink = updateLink.replace('update-question-bank', 'update');
            item.find("a:first").attr('href', questionUpdateLink);
            
            var delLink = item.find("a:last").attr('href');
            var questionDelLink = "/exercise/remove-question-from-exercise?id=" + exerciseId + "&qid=" + item.attr('question-id');
            item.find("a.delete").attr('href', questionDelLink);
            item.find(".concept-wrap, .level").hide();
            
            // clone question bank to question if not existed
            var exercise = item.attr('exercise'); 
            $.ajax({
                url : "/exercise/add-question-from-bank",
                data : {id:exercise, qid : item.attr('item-id')},
                success: function(json) {
                    alert_success(t('operation_successful'));
                }
            });
        }
    };
    
    var update_callback = function($el, event, ui) {
        var itemId;
        var indexOrder = [];//$(this).sortable('toArray
            $.each($el.children(), function(i, li){
                indexOrder.push($(li).attr('item-id'));
            });
        
        if ($(ui.item).hasClass('other-item')) {
            itemId = ui.item.attr('item-id');
            indexOrder[ui.item.index()] = itemId;
        }
        
        url = $el.attr('href');
        
        postdata = {
                items_order: indexOrder, 
                '_cl_submit':1,
                item_id: itemId
        };
        
        step = $el.attr('step');
        if (step)
        {
            postdata._cl_step = step;
        }
        //console.log('posting');
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: postdata,
            success: function(data){
                //$("ul.other-lessons-wrapper li#" + itemId).remove();
                if (!data.success)
                {
                    alert_success(data.err);
                }
                else if (data.success && typeof data.callback != 'undefined' && data.callback == 'alert')
                {
                    var msg = data.data.message ? data.data.message : 'Successful';
                    alert_success(msg);
                }
                
            }
        });
    };
    orderItemOptions = {
        connectWith: ".connectedSortable",
        receive: function(event, ui) {
        	//console.log(ui.item);
            receive_new_item(event, ui.item);
        },
        update: function(event,ui){
        	//update_callback($(this), event,ui);
        }
        
    };
    
    $(".order-item-list").sortable(orderItemOptions).disableSelection();
    /*
    $(".order-item-list").bind('sortupdate', function(event,ui){
    	update_callback($(this), event,ui);
    })
    */
    
    var dropped_callback = function (item, $target)
    {
        //console.log('dropped_callback');
        // check element exists?
        ui = {
            draggable : item    
        };
        var counter = 0;
        $.each($target.children(), function(i, it){
            if($(it).attr('data-item-id') == ui.draggable.attr('data-item-id'))
            {
                counter++;
            }
        });
        
        if(counter > 1) {
            alert_error('This item already exists.');
            ui.draggable.remove();
        }
        else {
            ui.draggable.show();
        }
    };
    
    $(".order-item-list").liveDroppable({
        drop: function( event, ui ) {
            dropped_callback(ui.draggable,$(this));
        }
    });
    
    $(document).on('mouseover', ".droppable-item-list", function(){
            if(!$(this).hasClass('question_existed'))
                $(this).find('.add_question_to_exercise').show();
        }).on('mouseout' ,  ".droppable-item-list",  function() {
            $(this).find('.add_question_to_exercise').hide();
        });
    

    //add question by faking a drag & drop event
    $(document).on('click', ".add_question_to_exercise", function(e){
        $(this).closest('.droppable-item-list').addClass("question_existed");
        var clone = $(this).closest('.droppable-item-list').clone();
        $(".order-item-list").append(clone).find('.add_question_to_exercise').remove();
        dropped_callback(clone, $(".order-item-list"));
        receive_new_item (e, clone);
    });
});