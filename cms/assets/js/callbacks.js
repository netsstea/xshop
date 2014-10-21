
$(document).ready(function(){
 CL.callbacks = $.extend (
        CL.callbacks,
        {
            xxx : function ($form, data, params)
            {
            	console.log(data);
            	console.log(params);
            }
        });
});