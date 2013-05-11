function tooltip(target_items, name){
	 $(target_items).each(function(i){
	 	
                  $("body").append("<div class='"+name+"' id='"+name+i+"'><p>"+$(this).attr('img')+"</p></div>");
                  
                  var file_hover = $("#"+name+i);
                  
                  $(this).mouseover(function(){
                                  file_hover.text($("img:hover").attr('id')).css({opacity:0.875, display:"none"}).fadeIn(40);
                  }).mousemove(function(kmouse){
                                  file_hover.css({left:kmouse.pageX+15, top:kmouse.pageY+15});
                  }).mouseout(function(){
                                  file_hover.fadeOut(40);
                  });
			
			
	 });
}
	
$(document).ready(function(){
		
	
		tooltip("#target","tooltip");
		
});