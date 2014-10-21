$(document).ready(function(){
   CL.utils = $.extend(CL.utils, {
       change_icon : function(sel, i)
       {
           $(sel).removeClass().addClass(CL.utils.get_icon(i));
       },
       change_icon_color : function($i, color)
       {
           //$i.css
       },
       user_avatar : function(iid){
           var uiid;
           if (typeof iid == 'undefined')
               uiid = CL.localStorage.getItem('uiid', true);
           else 
               uiid = iid;
           return CL.STATIC_CDN + '/avatar/small/' + uiid + '.jpg'; 
       },
       user_link : function(){
           return '/user/' + CL.localStorage.getItem('uiid', true);
       },
       is_editor : function(){
           return true;
       },
       populate_dynamic_info : function(){
           //Populate user info at top user menu
           if (CL.utils.is_editor())
           {
               $("#admin-menu").show();
           }
       }
   }); 
   
   CL.utils.populate_dynamic_info();
   
});
