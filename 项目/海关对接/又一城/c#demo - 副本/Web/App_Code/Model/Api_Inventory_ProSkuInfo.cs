using System;

[Serializable]
public class Api_Inventory_ProSkuInfo
{
    /// <summary>
    /// 类型[0：增加(默认) 1：减少]
    /// </summary>
    public string OType { set; get; }
    /// <summary>
    /// 商品Sku
    /// </summary>
    public string SkuNo { set; get; }
    /// <summary>
    /// 商品数量
    /// </summary>
    public string ProNum { set; get; }
}