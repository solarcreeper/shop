using System;

/// <summary>
///商品类别
/// </summary>
[Serializable]
public class Dto_Pro_Class
{
    /// <summary>
    /// 类别编号
    /// </summary>
    public string ClassId { set; get; }

    /// <summary>
    /// 类别名称
    /// </summary>
    public string ClassName { set; get; }

    /// <summary>
    /// 1：大类 2：小类
    /// </summary>
    public string Class_N { set; get; }

    /// <summary>
    /// 大类ID，与<ClassId>对应，如果是大类Class_N_Id=ClassId
    /// </summary>
    public string Class_N_Id { set; get; }
}