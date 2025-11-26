# 中国行政区域数据（省市区县镇乡村五级联动）

## 项目介绍

本项目提供了中国完整的行政区域数据，包括港澳台地区，实现了省、市、区/县、镇/街道、村/社区五级联动功能。数据来源于国家统计局官方发布的行政区划代码，确保了数据的准确性和权威性。

## 数据文件说明

### regions.json
- 包含中国所有【省/市/区/县/镇/村】的名称及行政代码
- 数据量较大（约37MB），建议仅在PC端使用
- 适用于需要一次性加载全部地区数据的场景

### province.json
- 包含中国所有省份的名称及行政代码
- 数据结构简洁，便于快速加载省份列表
- 格式示例：
```json
[
  {
    "url": "https://www.stats.gov.cn/sj/tjbz/tjyqhdmhcxhfdm/2023/11.html",
    "name": "北京市",
    "code": "11"
  },
  // 更多省份...
]
```

### China 文件夹
- 包含所有省份的切片文件，每个文件对应一个省份
- 每个文件包含该省份的【市/区/县/镇/村】完整层级数据
- 文件名格式：`省份名称.json`（如：`北京市.json`）
- 适用于移动端和性能要求较高的场景，可根据用户选择按需加载

### 特别行政区.json
- 包含港澳台地区的城市名称及代码
- 为特别行政区提供独立的数据文件

## 项目特点

- ✅ 完整的五级行政区划数据（省-市-区/县-镇/街道-村/社区）
- ✅ 包含港澳台地区数据
- ✅ 数据来源于国家统计局官方发布
- ✅ 支持按需加载，优化移动端性能
- ✅ 提供完整的演示示例
- ✅ 年度更新机制

## 使用方法

### 基本用法

1. 首先加载省份列表（使用 province.json）
2. 根据用户选择的省份，按需加载对应省份的详细数据（从 China 文件夹加载）
3. 实现五级联动功能

### 示例代码（JavaScript）

```javascript
// 获取省份数据
fetch('province.json')
  .then(res => res.json())
  .then(data => {
    // 填充省份下拉列表
    data.forEach(item => {
      provinceSelect.innerHTML += `<option value="${item.name}">${item.name}</option>`;
    });
  });

// 监听省份选择变化
provinceSelect.onchange = () => {
  // 清空下级选择框
  citySelect.innerHTML = `<option value="">--市--</option>`;
  districtSelect.innerHTML = `<option value="">--区县--</option>`;
  townSelect.innerHTML = `<option value="">--镇街道--</option>`;
  villageSelect.innerHTML = `<option value="">--村--</option>`;
  
  // 加载选中省份的数据
  fetch(`China/${provinceSelect.value}.json`)
    .then(res => res.json())
    .then(data => {
      // 填充城市列表
      data['children'].forEach(item => {
        citySelect.innerHTML += `<option value="${item.name}">${item.name}</option>`;
      });
    });
};

// 监听城市选择变化（类似实现区县、镇街道、村的联动）
citySelect.onchange = () => {
  // 实现城市到区县的联动
};
```

### 完整示例

查看项目中的 `index.html` 文件，包含了完整的五级联动实现代码。

## 在线演示

[点击查看在线演示](https://657258535.github.io/China-Area-Region-Administrative-Divisions)

## 数据更新

- 本项目数据每年年底更新（如行政区划无变化则不更新）
- 数据来源：[国家统计局行政区划代码](https://www.stats.gov.cn/sj/tjbz/qhdm)

## 项目结构

```
China-Area-Region-Administrative-Divisions/
├── China/                # 各省份的详细数据文件
│   ├── 北京市.json
│   ├── 天津市.json
│   ├── ...              # 其他省份文件
├── index.html           # 演示页面
├── province.json        # 省份列表数据
├── regions.json         # 完整行政区域数据
├── 特别行政区.json        # 港澳台地区数据
├── README.md           # 项目说明
└── LICENSE             # 开源协议
```

## 适用场景

- Web应用中的地区选择器
- 移动端App的地址选择功能
- 数据分析和可视化
- 地图应用的行政区划展示
- 身份证地址查询（精确到县级）

## 性能优化建议

1. **移动端应用**：建议使用切片数据（China文件夹下的省份文件），按需加载以提高性能
2. **PC端应用**：可根据需求选择完整数据（regions.json）或切片数据
3. **频繁查询场景**：建议将数据缓存到本地或数据库中
4. **仅需省市区三级**：可在加载后过滤数据，只保留需要的层级

## 注意事项

1. 请尊重数据来源，合理使用本项目数据
2. 行政区划可能会有调整，请及时更新数据文件
3. 如需用于商业项目，请确保符合相关法律法规
4. 数据量大，使用时请注意性能优化

## 贡献指南

欢迎提交Issue和Pull Request来改进本项目。

## 许可证

本项目采用MIT许可证。

## 更新日志

- 数据来源：国家统计局最新行政区划代码
- 年度更新：每年12月更新（如有变化）

---

如果本项目对您有帮助，请给个Star支持一下！ 😊

