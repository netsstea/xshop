//Custom js files for site
/** Author: Chungth ; email: huychungtran@gmail.com**/
$(function(){ // document ready
	
	$("a.preview_story").each(function(i, el){
	    $el = $(this);
	    var opts = {
	        html : true,
	        content : $el.closest('td').find('.chapo').html(),
	        trigger : 'hover',
//	        title : "<b>" + $el.html() + "</b>",
	        placement : 'bottom'
	        
	    }
	    $el.popover(opts);
	});

	    
    $("#login").click(function(e){
        e.preventDefault();
        $("#login_form").show();
        $("#remind_password_form").hide();
    });
   
    $("#remind_password").click(function(e){
        e.preventDefault();
        $("#login_form").hide();
        $("#remind_password_form").show();
    });
});
/** End * */
/*
<!-- Place this tag after the last +1 button tag. -->
*/
/*
window.___gcfg = {lang: 'vi'};

(function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=216059938523158";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
*/
