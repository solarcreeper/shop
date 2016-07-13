using System;

/// <summary>
///订单商品
/// </summary>
[Serializable]
public class Dto_Order_Pro_Info
{
    /// <summary>
    /// 商品标题
    /// </summary>
    public string proTitle { set; get; }

    /// <summary>
    /// 商品货号
    /// </summary>
    public string proNo { set; get; }

    /// <summary>
    /// 商品SKU 
    /// </summary>
    public string proSku { set; get; }

    /// <summary>
    /// 商品价格
    /// </summary>
    public string proPrice { set; get; }

    /// <summary>
    /// 购买的数量。取值范围：大于零的整数
    /// </summary>
    public string proCount { set; get; }
}