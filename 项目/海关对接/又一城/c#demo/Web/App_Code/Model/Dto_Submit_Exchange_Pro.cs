using System;

/// <summary>
///售后提交商品信息
/// </summary>
 [Serializable]
public class Dto_Submit_Exchange_Pro
{
    /// <summary>
    /// SKU号
    /// </summary>
    public string SkuNo { set; get; }
    /// <summary>
    /// 商品数量
    /// </summary>
    public string TProNum { set; get; }
}