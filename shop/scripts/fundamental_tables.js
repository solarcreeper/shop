//translation data
var LC_TITLES;
var LC_SOURCE;
var pre_translate;

function translate_titles(source ,target) {
    if (!source) source = LC_SOURCE;
    if (!target) target = "";
    //translate title
    $(target + ' .title:not(.translated)').each(function () {
        var original = $(this).text();
        var translation = eval('LC_TITLES.' + source + '.' + original);
        if (translation !== '') $(this).addClass('translated').text(translation);
    });
}


//callback - normal
function showResponseInGET(responseData) {
    switch (responseData.error_code) {
        case '1000':
            alert("操作成功");
            break;
        case '9997':
            validate_cookie(true, "身份认证失败, 请重新登录");
            break;
        default:
            alert('状态：' + responseData.error_code + '\n内容：' + responseData.error_msg);
    }
}

//callback - table
function showResponseInTable(json) {
    if (json.error_code) {
        var error_code = json.error_code;
        var error_msg = json.error_msg;
        switch (error_code) {
            case '9997':
                validate_cookie(true, "身份认证失败, 请重新登录");
                break;
            default:
                alert('状态：' + error_code + '\n内容：' + error_msg);
        }
    }
    return json.data;
}

function disp_format(val, type, souce) {
    // this function convert image and boolean data
    // to show them correctly in detail panel
    // Types : text, bool, img, select.
    // - text: the normal type, display raw data.
    // - bool: the boolean type, display 是／否 instead of 1/0.
    // - img: the image type, display img preview of the base64 data.
    // - sp_sel: the special_selection type, display item text instead of val.
    //   convert data stored in special_selection_translation.json
    // Source: the souce name should be specify if the Type is "sp_sel".
    if (!val) return val;
    switch (type) {
        case "bool":
            if (val == "0") return "否 ";
            if (val == "1") return "是";
            return "数据格式不正确 ("+val+")";
        case "img":
            var img = $('<img />', {
                src: val,
                class: "img_preview_in_detail"
            });
            return img;
        case "price":
            return (val * 1).toFixed(2);
        case "sp_sel":
            //translate options of special selections
            var LC_SELECTION = JSON.parse($.ajax({
                url: "special_selection_translation.json",
                async: false,
                dataType: "json"
            }).responseText);
            return (eval('LC_SELECTION.' + souce + '.' + val));

        default:
            return val;
    }
}


$(document).ready(function () {

    $.getJSON("field_titles.json", function (data) {
        LC_TITLES = data;

        if (pre_translate) pre_translate_callback();

        translate_titles();

        //create tfoot
        $('table thead tr').each(function(index,item) {
            $(this).clone().insertAfter($(this).closest('thead')).wrapAll('<tfoot></tfoot>');
        });
        //init dataTable plugin
        initTable();
    });




});
