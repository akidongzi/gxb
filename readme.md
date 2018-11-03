# 接口文档

## 接口统一签名规则

接口数据签名只需要对JSON Payload进行签名，HTTP GET/POST参数不参与签名算法

PHP版本签名实例
```php
/**
 * 接口数据签名函数
 *
 * @param array     $params 参数列表
 * @param string    $secret 签名对称干扰密码
 * @return string
 */
public function sign($params, $secret = '')
{
    // 1. 去除参数中的空值
    $params = array_filter($params);
    unset($params['sign']);

    // 2. 将所有请求参数按字母先后顺序排序
    ksort($params);
	
    // 3. 拼接字符串 格式: a=xx&b=xx&c=xx
    $string = urldecode(http_build_query($params));

    // 4. md5 加密
    $sign = md5($string . md5($secret));

    return $sign; 
}
```

## 阿里云OSS图片上传文档  
https://help.aliyun.com/document_detail/32026.html?spm=a2c4g.11186623.6.743.5ffa2ba8oQ09aV


## 数据贡献接口

### 文章录入

测试地址：http://test.www.cicic.org.cn/api/v1/article?sign=xxxxxxxx&ts=42121133

参数：json格式请求
```
{
	"title":"中国传统文化亮相2018科灵文化节-测试", // 标题
	"covers":[ // 封面图
		"http://cici-images.oss-cn-beijing.aliyuncs.com/201810/03/L1VzZXJzL3poYW95b25nYmluL1RtcC96aHdoemNxL3N0b3JhZ2UvYmFubmVyLmpwZw.jpg",
		"http://cici-images.oss-cn-beijing.aliyuncs.com/201810/03/L1VzZXJzL3poYW95b25nYmluL1RtcC96aHdoemNxL3N0b3JhZ2UvYmFubmVyLmpwZw.jpg",
		], 
	"brief":"当地时间8月24日，丹麦国际商学院孔子课堂在科灵湖畔举办以中国传统文化为主题的推广活动。", // 摘要
	"url":"http://www.hanban.org/article/2018-09/06/content_743818.htm", // 文章地址
	"author":"中华文化走出去", // 作者
	"source":"丹麦国际商学院孔子课堂", // 来源
	"published_at":"2010-10-03 12:00:00", // 发布时间
	"content":"<p><img src=\"http://xxxx.com/jpg\"/></p>", // 内容
	"labels": [ // 文章标签, 可以为空
		"北海专题	",
		"教育"
	],
	"atlases": [ // 图集列表, 可以为空
		{
			"brief": "9月1日，中国国家主席习近平在北京人民大会堂同埃及总统塞西举行会谈。会谈前，习近平在大会堂北大厅为塞西举行欢迎仪式",
			"pic": "http://cici-images.oss-cn-beijing.aliyuncs.com/201810/03/L1VzZXJzL3poYW95b25nYmluL1RtcC96aHdoemNxL3N0b3JhZ2UvYmFubmVyLmpwZw.jpg",
		},
		{
			"brief": "9月1日，中国国家主席习近平在北京人民大会堂同埃及总统塞西举行会谈。会谈前，习近平在大会堂北大厅为塞西举行欢迎仪式",
			"pic": "http://cici-images.oss-cn-beijing.aliyuncs.com/201810/03/L1VzZXJzL3poYW95b25nYmluL1RtcC96aHdoemNxL3N0b3JhZ2UvYmFubmVyLmpwZw.jpg",
		}
	]
}
```

示例：  
```
// Json格式
curl --header "Content-Type: application/json" \
  --request POST \
  --data '{"title":"中国传统文化亮相2018科灵文化节-测试","covers":["https://cici-images.oss-cn-beijing.aliyuncs.com/201810/03/L1VzZXJzL3poYW95b25nYmluL1RtcC96aHdoemNxL3N0b3JhZ2UvYmFubmVyLmpwZw.jpg"], "brief":"当地时间8月24日，丹麦国际商学院孔子课堂在科灵湖畔举办以中国传统文化为主题的推广活动。","url":"http://www.hanban.org/article/2018-09/06/content_743818.htm","content":"<p><img src=\"http://xxxx.com/jpg\"/></p>","author":"中华文化走出去","source":"丹麦国际商学院孔子课堂","published_at":"2010-10-03 12:00:00","type":1}' \
  https://test.www.cicic.org.cn/api/v1/article?sign=xxxxxxxx&ts=42121133
```

返回：  
```

// 错误格式
- 403 签名错误
- 400 参数错误
{
	"errno"  : 400,
	"errors" :
		{
			"title" : ["title 不能空"],
			"covers" : ["covers 必须是数组"],
			"brief" : ["brief 不能大于255个字符"]
		}
}
// 正确
{
	"errno" : 0,
	"data"  : [],
}

```



## 前端接口



