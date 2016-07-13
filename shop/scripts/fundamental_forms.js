var LC_SOURCE;
var FLAG_HIDE_FORM;
//option of form submitting
var options = {
    target: '#output1',
    beforeSubmit: validate,
    success: showResponse,
    data: {
        TOKEN: TOKEN,
        USERNAME: USERNAME
    }
};


//validate
function validate(formData, jqForm, options) {
    var data = jqForm[0];
    console.log(formData)
    var pass = true;
    //Mandatory
    $('#myForm :input').each(function () {
        if ($(this).hasClass('mandatory') && !($(this)[0].value)) {
            alert('请填写所有必填项目: '+ $(this).prev('div').text());
            pass = false;
            return false;
        }
    });
    //custom_validation
    if (pass)
        pass = custom_validation();
    return pass;
}

function formSuccessCallback() {
    alert("ORIGINAL");
}


//callback
function showResponse(responseData, statusData, xhr, $form) {
    var data = JSON.parse(responseData);
    switch (data.error_code) {
        case '1000':
            alert("操作成功");
            $('#myForm').resetForm();
            formSuccessCallback();
            break;
        case '9997':
            validate_cookie(true, "身份认证失败, 请重新登录");
            break;
        default:
            alert('状态：' + data.error_code + '\n内容：' + data.error_msg);
    }
}


$(document).ready(function () {

    //init form
    formatForm('#myForm');
    initForm();
    $('#myForm').ajaxForm(options);

});

function formatForm(selector, source){
    if (!source) source = LC_SOURCE;


    //imit & format form
    $.getJSON("field_titles.json", function (titles) {
        var offset = 0;
        $(selector+' :input:not(.noFormat)').each(function (index, value) {

            //set index offset in case <hr> or img-input element exists.
            var prevNode = $(this).prev()[0];
            if (prevNode && (prevNode.nodeName == "HR"))
                if (index % 2 !== 0)
                    offset = 1;
                else offset =0;

            //insert break before img upload area begin
            var nextNode = $(this).next();
            if (nextNode && (nextNode.hasClass("image")) && !$(this).hasClass("image"))
                $(this).after('<br/>');

            //skip noFormat item
            if ($(this).hasClass('noFormat')) return true;

            //submit button
            if ($(this).hasClass('button')) {
                $(this).before("<br/><hr>");
                return true;
            }

            //generate & translate titles
            //extract_original
            var name;
            if ($(this).attr('altname')) name = $(this).attr('altname');
            else if ($(this).hasClass('image')) name = $(this).attr("target");
            else name = $(this).attr("name");
            if ($(this).hasClass('button')) name = '提交表单';
            //translate
            if ('undefined' != typeof eval("titles." + source + '.' + name))
                disp_title = eval("titles." + source + '.' + name);
            else disp_title = name;
            //Add splash after mandatory items
            if ($(this).hasClass("mandatory"))
                disp_title += ('<span class="error">&nbsp* </span>');
            else disp_title += ('<span class="error">&nbsp&nbsp </span>');
            //wrap & insert
            $(this).before('<div class="form_item_title form_item">' + disp_title + '</div>');


            //extend image
            if ($(this).hasClass('image')) {
                var target = $(this).attr('target');
                //bind event
                $(this).attr('onchange', "loadImg(this, '" + target + "')");
                //create input field
                $('<input />', {
                    type: "text",
                    name: target,
                    id: target + '_input',
                    style: "display: none;"
                }).insertAfter($(this));
                //create preview img tag
                $('<img />', {
                    id: target + '_preview',
                    class: "img_preview"
                }).insertAfter($(this)).wrap('<div class="form_item">');
                //wrap self
                $(this).wrap('<div class="form_item">');

            }

            //break after each line
            if (!$(this).hasClass("image") && ((index+offset) % 2 !== 0))
                $(this).after('<br/>');
            else $('#' + target + '_preview').parent().after('<br/>');
        });

        //init chosen
        if ($('select').length !== 0) $('select').chosen();
        //add exceptions for possible input elements generated by chosen
        $('.chosen-search>input').addClass('noFormat');

        //init datepicker
        var datepickers = $( ".datepicker" );
        if (datepickers.length !== 0) {
            datepickers.datepicker();
            datepickers.datepicker( "option", "showAnim", "slideDown" );
            datepickers.datepicker( "option", "dateFormat", "yy-mm-dd" );
        }

        if (FLAG_HIDE_FORM){
            $('#myForm').css('display','none');
            FLAG_HIDE_FORM = false;
        }


    });

    fixClientInfo(selector);

    //translate options of special selections (general)
    $(selector+' select.special_selection').each(function(index, item) {
        var options = $(item).children();
        var selection = $(item).attr('name');
        $.getJSON("special_selection_translation.json", function(LC_SELECTION) {
            options.each(function(index, item) {
                var val = $(item).attr('value');
                if (val) $(item).text(LC_SELECTION[selection][val]);
            });
            $('select').trigger('chosen:updated');
        });
    });

    //solve country_selector with region_list.json
    $.getJSON("region_list.json", function (data) {
        var selection = $(selector+' select[name=DESC_ARRI_COUNTRY_CODE]');
        selection.empty();
        $("<option hidden='hidden'>请选择</option>").appendTo(selection);
        for (var code in data) {
            var name = data[code];
            $("<option />", {
                "value": code,
                text: name
            }).appendTo(selection);
        }
        $('select').trigger('chosen:updated');
    });

    //solve currency_selector with currency_list.json
    $.getJSON("currency_list.json", function (data) {
        var selection = $(selector+' select[altname=CURRENCY_CODE]');
        selection.empty();
        $("<option hidden='hidden'>请选择</option>").appendTo(selection);
        for (var code in data) {
            var name = data[code];
            $("<option />", {
                "value": code,
                text: name
            }).appendTo(selection);
        }
        $('select').trigger('chosen:updated');
    });

    //solve tax_rate_selector with tax_rate_list.json
    $.getJSON("tax_rate_list.json", function (data) {
        var selection = $(selector+' select[name=POST_TAX_NO]');
        selection.empty();
        $("<option hidden='hidden'>请选择</option>").appendTo(selection);
        for (var code in data) {
            var name = data[code].name;
            var rate = data[code].rate;
            $("<option />", {
                "value": code,
                "tax_rate": rate,
                text: name
            }).appendTo(selection);
        }
        selection.change(function () {
            $(selector+' input[name=TAX_RATE]').val($(selection[0].selectedOptions).attr("tax_rate"));
        });
        $('select').trigger('chosen:updated');
    });

    //solve address selector with china_list.json
    $.getJSON("china_list.json", function(data) {
        var sl_province = $(selector+' select.addr_selection.province');
        var sl_city = $(selector+' select.addr_selection.city');
        var sl_country = $(selector+' select.addr_selection.country');
        var code_province = $(selector+' input.addr_selection.province');
        var code_city = $(selector+' input.addr_selection.city');
        var code_country = $(selector+' input.addr_selection.country');
        $("<option hidden='hidden'>请选择</option>").appendTo(sl_province);
        data.forEach(function(item, index) {
            $('<option />', {
                "value": item.name,
                "code": item.code,
                "index": index,
                text: item.name
            }).appendTo(sl_province);
        });
        $('select').trigger('chosen:updated');
        sl_province.change(function () {
            var selection = $(this.selectedOptions);
            var province_index = selection.attr("index");
            code_province.val(selection.attr("code"));
            code_city.val("");
            code_country.val("");
            sl_city.empty();
            sl_country.empty();
            $("<option hidden='hidden'>请选择</option>").appendTo(sl_city);
            data[province_index].cell.forEach(function(item, index) {
                $('<option />', {
                    "value": item.name,
                    "code": item.code,
                    "index": index,
                    text: item.name
                }).appendTo(sl_city);
            });
            $('select').trigger('chosen:updated');
            sl_city.change(function () {
                var selection = $(this.selectedOptions);
                var province_index = $(sl_province[0].selectedOptions).attr("index");
                var city_index = selection.attr("index");
                code_city.val(selection.attr("code"));
                code_country.val("");
                sl_country.empty();
                $("<option hidden='hidden'>请选择</option>").appendTo(sl_country);
                data[province_index].cell[city_index].cell.forEach(function(item, index) {
                    $('<option />', {
                        "value": item.name,
                        "code": item.code,
                        "index": index,
                        text: item.name
                    }).appendTo(sl_country);
                });
                $('select').trigger('chosen:updated');
                sl_country.change(function () {
                    var selection = $(this.selectedOptions);
                    code_country.val(selection.attr("code"));
                });
            });
        });
    });

}

//Fix client info
function fixClientInfo(selector) {
    if (!selector) selector = "";
    $.getJSON("customer_identifier.json", function (cus_id) {
        $(selector+' :input').each(function () {
            var name;
            if ($(this).attr('altname')) name = $(this).attr('altname');
            else name = $(this).attr('name');
            if ('undefined' != typeof eval('cus_id.' + name)) {
                $(this).attr('readonly', "true");
                $(this).val(eval('cus_id.' + name));
            }
        });
    });
}

//load img, preview and convert into base64
function loadImg(img, target_name) {
    if (img.files && img.files[0]) {
        var FR = new FileReader();
        FR.onload = function (e) {
            //e.target.result = base64 format picture
            $('#' + target_name + '_preview').attr("src", e.target.result);
            $('#' + target_name + '_input').val(e.target.result);
        };
        FR.readAsDataURL(img.files[0]);
    }
}