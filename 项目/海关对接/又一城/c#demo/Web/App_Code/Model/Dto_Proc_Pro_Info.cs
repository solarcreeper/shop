using System;

/// <summary>
///Dto_Proc_Pro_Info 的摘要说明
/// </summary>
[Serializable]
public class Dto_Proc_Pro_Info
{
    /// <summary>
    /// 编号
    /// </summary>
    public string id { get; set; }
    /// <summary>
    /// 商品名称
    /// </summary>
    public string Pro_Title { get; set; }
    /// <summary>
    /// 商品货号
    /// </summary>
    public string Pro_No { get; set; }
    /// <summary>
    /// 商品SKU
    /// </summary>
    public string Sku_No { get; set; }
    /// <summary>
    /// 商品颜色与规格
    /// </summary>
    public string Pro_Color_Sizes { get; set; }
    /// <summary>
    /// 实际数量
    /// </summary>
    public string Pro_Count { get; set; }
    /// <summary>
    /// 预计数量
    /// </summary>
    public string Cg_Pro_Count { get; set; }
}