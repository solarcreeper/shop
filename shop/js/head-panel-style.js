/*  配置head-panel的logo
    图片/文字
*/


$(function(){
	var headMenuStr = '';
	var USERNAME = $.cookie('USERNAME');

	headMenuStr += '<div style="height:100%; display:flex; position:relative; padding:10px;">'
                //+ '<h2 class="logo" style="position:absolute;top:-15px;left:30px;float:left;width:auto;color:white;">'
				+ 	'<img src="4.png">'
				+ 	'<img style="margin:auto 10px;" src="33.png">'
				+ 	'<div style="display:inline-block; position:absolute; float:right; bottom:5px; right:10px; color:white; font-size:20px; font-weight:normal">'
				+		'<span style="font-family:STZhongsong">欢迎 ' + USERNAME + ' </span>'
				+ 		'<span style="color:white" ><i class="fa fa-power-off" onclick=deleteCookies()></i></span>'
				+ 	'</div>'
			    + '</div>';
	jQuery('#header').html(headMenuStr);
})

function deleteCookies()
{
    layer.confirm('您确定要注销么？', {
        btn: ['确定','取消'] //按钮
        }, function(){
        	$.cookie('USERNAME', 'null', { path:'/', expires: -1 } );
	        $.cookie('DISCOUNT', 'null', { path:'/', expires: -1 });
	        $.cookie('IS_ADMIN', 'null', { path:'/', expires: -1 });
	        $.cookie('TOKEN', 'null', { path:'/', expires: -1 });
	        window.location.href="login.html";
        }, function(){
           return;
       });

}


