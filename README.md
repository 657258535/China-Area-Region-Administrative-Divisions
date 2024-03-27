### 获取全中国行政区域含港澳台【省市区县镇乡村】五级联动精确地址json数据

#### regions.json 包含了：中国所有【省/市/(区)县/镇/(乡)村】名称及行政代码

- 建议PC端引用，手机端请引用单独分离出来的切片部分，否则低端手机可能导致性能故障

- 如果用于查询身份证地址是精确到县的，建议引用切片部分，否则低端服务器可能导致性能故障

#### 省.json 包含了：中国所有省名称及行政代码

#### 中国文件夹包含了：所有省份的切片文件，含各省【省/市/县/镇/村】名称及行政代码

> Demo：https://657258535.github.io/China-Area-Region-Administrative-Divisions

> 引用方法：

-  根据用户选择的省份，调用相对应的省区切片Json文件，即可完美实现地区城市五级联动精确到村的效果，且不会性能故障，低端手机也可流畅选择

- 用到的文件：省.json 及 中国文件夹里面地区切片文件


#### 特别行政区.json 包含了：港澳台的城市名称及代码

> 关于更新：

- #### 本库每年年底更新，地区无变化不更新

- 本库地址引用数据来自：www.stats.gov.cn/sj/tjbz/qhdm

- 本库适用于：App Web 等终端，相关引用代码请自行编码

