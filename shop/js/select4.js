(function($){
    $.fn.extend({
        select4:function(options){
            var defaults = {
                ajax_url:true,
                func_type:true
            }
            var options = $.extend(defaults, options);
 
            return this.each(function(){
                $(".h2").remove();                
                var mythis = $(this);
 
                $(document).on("click",".select4_box li",function(){
                    mythis.val($(this).text());
                    var sku = $(this).attr("alt");
                    mythis.prop("name", sku);
                    $(".select4_box").remove();
                });
 
                $(document).click(function(event) {
                    $(".select4_box").remove();
                });
 
                $(".select4_box").click(function(event) {
                    event.stopPropagation();
                });
 
                mythis.click(function(event){
                    var val = $(this).val();
                    if(val.length > 0){
	                    var arg0 = options.func_type;
	                    var mythis = $(this);
	                    var width = $(this).width()+14+"px";
	                    var top = $(this).position().top+30;
	                    var left = $(this).position().left;
	                    $.ajax({
	                    	type:"post",
	                        url:options.ajax_url,
	                        dataType:"json",
	                        data:{"value":val, "func_type":arg0},
	                        success:function(json, status, xhr){
	                            if(json.data){
	                                var html = '<div class="select4_box"><ul>';
	                                $.each(json.data,function(k,v){
	                                    html += '<li alt="'+v.id+'">'+v.name+'</li>';
	                                });
	                                html+='</ul></div>'
	                                $(".select4_box").remove();
	                                mythis.after(html);
	                                $(".select4_box").css({top:top,left:left,width:width});
	                            }
	                        },
	                        error:function(xhr){
	                        	alert(xhr.responseText);
	                        }
	                    });
                    }
                });
 
                mythis.keyup(function(event) {
                    if(event.keyCode==40){
                        var index = $(".select4_box li.active").index()+1;
                        $(".select4_box li").eq(index).addClass('active').siblings().removeClass('active');
                        mythis.val($(".select4_box li.active").text());
                    }else if(event.keyCode==38){
                        var index = $(".select4_box li.active").index()-1;
                        if(index<0){
                            index = $(".select4_box li").length-1;
                        }
                        $(".select4_box li").eq(index).addClass('active').siblings().removeClass('active');
                        mythis.val($(".select4_box li.active").text());
                    }else if(event.keyCode==13){                        
                        event.stopPropagation();
                        mythis.val($(".select4_box li.active").text());
                    }else{
                        mythis.trigger("click");
                    }
                });
            });
        }
    });
})(jQuery);