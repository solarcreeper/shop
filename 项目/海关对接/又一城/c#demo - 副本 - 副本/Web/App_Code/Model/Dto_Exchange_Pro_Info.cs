using System;

/// <summary>
///售后商品信息
/// </summary>
[Serializable]
public class Dto_Exchange_Pro_Info
{
    /// <summary>
    /// SKU号
    /// </summary>
    public string SkuCode { set; get; }

    /// <summary>
    /// 商品数量
    /// </summary>
    public string ProductNumber { set; get; }

    /// <summary>
    /// 退款金额
    /// </summary>
    public string RefundAmount { set; get; }
}