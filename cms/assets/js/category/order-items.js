$(function(){
    $("#update-items-list").click(function(){
        var itemsArr = [];
        $("#concept-list .sortable-item").each(function(i, el){
                itemsArr.push($(el).attr('data-item-id'));
        });
        var url = $("#concept-list").attr('data-href');
        var rowId = $("#concept-list").attr('data-id');
        var postdata = {
                items_order: itemsArr, 
                '_cl_submit':1,
                item_id: rowId
        };
        
        postdata._cl_step = 'category_items_order';
                
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
    });
});