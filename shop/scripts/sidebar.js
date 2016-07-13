function setMenuBehavier() {
    $(".dropdown").click(function () {
        $("#leftmenuOperate").find(".dropdown:not(.active)").find("ul").slideUp("fast");
    });
    $(".selectOne").click(function () {
        if ($(this).attr("status") != "selected") {
            $("#leftmenuOperate").find(".dropdown").removeClass("active");
            $(this).parents(".dropdown").addClass("active");
            $("#leftmenuOperate").find(".selectOne").removeAttr("style", "background-color:#282828");
            $("#leftmenuOperate").find(".selectOne").attr("status", "");
            $("#leftmenuOperate").find(".dropdown:not(.active)").find("ul:visible").slideDown("fast");
            $(this).attr("style", "background-color:#2176CC");
            $(this).attr("status", "selected");
            $(this).attr("style", "color:#cc9999");
            var keyword = $(this).attr('href');

            $.ajaxSetup({ cache: false }); //禁止load方法缓存页面

            switch (keyword) {
				default:
					$('.maincontentinner').load(this.hash.replace("#", "") +".html", function(){ clean(); });
				break;
            }
        }
    });
    function clean() {
        $('#ui-datepicker-div').remove();
    }
}

//toggle menu items visibility
$(document).ready(function() {
    if (!isAdmin()) {
        $('a[href=#goods-add]').closest('li').remove();
        $('a[href=#goods-purchase]').closest('li').remove();
        $('a[href=#goods-query-record]').closest('li').remove();
        $('a[href=#goods-query-purchase]').closest('li').remove();
        $('a[href=#retailer]').closest('li').remove();
    }
});
