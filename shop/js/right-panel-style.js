$(function(){
	jQuery("body").click(function(){			  
	var attrDisplay = jQuery('#a-1').css("display");
	if(attrDisplay == "block"){
		if(showFlag == 0){
			jQuery('#tab1').attr("style","height:140px; width:100%;background-color: 					#fff;z-index:100");
			jQuery('#opreate').attr("style","display:block");
			jQuery('.cover1-nav').attr("style","display:none");
		}else{
			jQuery('#opreate').attr("style","display:none");	
			jQuery('#tab1').attr("style","height:85px; width:100%");
			jQuery('.cover1-nav').attr("style","display:block");
		}
	}
	})
		   
	jQuery(".ui-tabs-anchor").click(function(){
		jQuery(".ui-corner-top").removeClass("ui-tabs-active ui-state-active");	
		jQuery(this).parent().addClass("ui-state-active");
		jQuery(".ui-tabs-panel").attr("style","display:none");
		var divName = jQuery(this).parent().find("a").attr("name");
		jQuery('#'+divName).attr("style","display:block;height:140px;");
		
		if(divName == "a-1"){
			jQuery('.cover1-nav').attr("style","display:block");
			jQuery('#'+divName).attr("style","display:block;");
		}else{
			jQuery('#'+divName).attr("style","display:block;height:140px;");
			jQuery('.cover1-nav').attr("style","display:none");
		}
	});
	
	
	jQuery("#a-1").hover(function(){
		showFlag = 	0;			  
	},function(){
		showFlag =1;
	}
	)
	
	jQuery(".btn-small").click(function(){
	jQuery(".reply").attr("style","display:none");
	jQuery(this).parent().parent().find(".reply").attr("style","display:block;height:35px");
	})
	
		/*
	* 	右侧用户操作
	*/
	
	jQuery(".dtoggle").hover(function(){
		jQuery('.userOperate').attr("style","display:block");	  
	},function(){
		jQuery('.userOperate').attr("style","display:none");
	}
	)
	
})

var showFlag;