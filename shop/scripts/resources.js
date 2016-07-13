//Load external resources
var CUSTOMER_IDENTIFIER = $.ajax("customer_identifier.json");
var LC_TITLES = $.ajax("field_titles.json");

//dummy data for cookie
//$.cookie('TOKEN', 'qwertyuiop1234567890');
//$.cookie('USERNAME', 'TESTER');
//$.cookie('IS_ADMIN', 0);
//$.cookie('DISCOUNT', 0.8);

//load cookie
var TOKEN = $.cookie('TOKEN');
var USERNAME = $.cookie('USERNAME');
var IS_ADMIN = $.cookie('IS_ADMIN');
var DISCOUNT = $.cookie('DISCOUNT');

validate_cookie();

function isAdmin() { return (IS_ADMIN == 0) ? false : true; }

function sizeof(x) {
    if (x === undefined) return 0;
    else return x.length;
}

function validate_cookie(forceReSign, showMessage) {
    var result = sizeof(TOKEN) * sizeof(USERNAME) * sizeof(IS_ADMIN) * sizeof(DISCOUNT);
    if (forceReSign || (result === 0)) {
        if (showMessage) alert(showMessage);
        window.location.href="login.html";
        //alert('redirected!');
		//window.location.href = "login.html";
    }
}


//server-interfaces
var serverRoot_1 = "http://10.250.94.124:8080/shop_src/shop_server/";
var serverRoot_2 = "http://218.70.106.50:9007";
var serverRoot_3 = "http://192.168.1.100:8080";

var serverRoot_4 = "http://localhost:8080/shop_src/shop_server/";

var serverRoot_5 = "http://10.249.130.70:8080/shop_src";

var serverRoot = serverRoot_1;

var SUBFIX_AUTH = "?TOKEN=" + TOKEN + "&USERNAME=" + USERNAME;
var SUBFIX_IMPORT = "?IS_IMPORT=1";
var SUBFIX_QUERY_SYNC = "&IS_EXCEL=1";
var SUBFIX_QUERY_EXCEL = "&IS_EXCEL=2";

var URL_POST_FORM_GOODS_ADD_IMPORT          = serverRoot + "bonded_goods_info.php";
var URL_POST_FORM_GOODS_ADD_NORMAL_MANUAL   = serverRoot + "ordinary_goods_info.php";
var URL_POST_FORM_GOODS_ADD_NORMAL_SYNC     = URL_POST_FORM_GOODS_ADD_NORMAL_MANUAL + SUBFIX_IMPORT;
var URL_POST_FORM_GOODS_ADD_NORMAL_EXCEL    = URL_POST_FORM_GOODS_ADD_NORMAL_MANUAL + SUBFIX_IMPORT;
var URL_POST_FORM_GOODS_PURCHASE            = serverRoot + "xiyong_purchase.php";
var URL_POST_FORM_ORDER_NEW_MANUAL          = serverRoot + "order_payment_info.php";
var URL_POST_FORM_ORDER_NEW_SYNC            = URL_POST_FORM_ORDER_NEW_MANUAL + SUBFIX_IMPORT;
var URL_POST_FORM_ORDER_NEW_EXCEL           = URL_POST_FORM_ORDER_NEW_MANUAL + SUBFIX_IMPORT;
var URL_GET_GOODS_QUERY_ALLGOODS_TABLE      = serverRoot + "all_goods_info_query.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_ALLGOODS_ACT_STOCK  = serverRoot + "modify_stock.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_PURCHASE_TABLE_HEAD = serverRoot + "xiyong_purchase_query.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_PURCHASE_TABLE_DETAIL = serverRoot + "xiyong_purchase_goods_query.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_PURCHASE_ACT_SYNC   = serverRoot + "xiyong_purchase_sync.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_PURCHASE_ACT_REFRESH = serverRoot + "xiyong_purchase_refresh.php" + SUBFIX_AUTH;
var URL_GET_GOODS_QUERY_RECORD_TABLE        = serverRoot + "bonded_goods_info_query.php" + SUBFIX_AUTH;
var URL_GET_ORDER_QUERY_TABLE_HEAD          = serverRoot + "order_payment_info_query.php" + SUBFIX_AUTH;
var URL_GET_ORDER_QUERY_TABLE_DETAIL        = serverRoot + "order_payment_goods_query.php" + SUBFIX_AUTH;
var URL_GET_ORDER_QUERY_ACT_OPERATE         = serverRoot + "order_payment_info_send.php" + SUBFIX_AUTH;
var URL_GET_ORDER_QUERY_ACT_CANCEL          = serverRoot + "order_payment_info_cancel.php" + SUBFIX_AUTH;
var URL_GET_ORDER_QUERY_ACT_DELETE          = serverRoot + "order_payment_info_delete.php" + SUBFIX_AUTH;
var URL_GET_GOODS_ADD_NORMAL_SYNC_TABLE     = serverRoot + "import_ordinary_goods_query.php" + SUBFIX_AUTH + SUBFIX_QUERY_SYNC;
var URL_GET_GOODS_ADD_NORMAL_EXCEL_TABLE    = serverRoot + "import_ordinary_goods_query.php" + SUBFIX_AUTH + SUBFIX_QUERY_EXCEL;
var URL_GET_GOODS_ORDER_NEW_SYNC_TABLE_HEAD = serverRoot + "import_order_query.php" + SUBFIX_AUTH + SUBFIX_QUERY_SYNC;
var URL_GET_GOODS_ORDER_NEW_EXCEL_TABLE_HEAD = serverRoot + "import_order_query.php" + SUBFIX_AUTH + SUBFIX_QUERY_EXCEL;
var URL_GET_GOODS_ORDER_NEW_SYNC_TABLE_DETAIL = serverRoot + "import_order_goods_query.php" + SUBFIX_AUTH;
var URL_GET_GOODS_ORDER_NEW_EXCEL_TABLE_DETAIL = URL_GET_GOODS_ORDER_NEW_SYNC_TABLE_DETAIL;
var URL_POST_LOGIN = serverRoot + "login.php";
