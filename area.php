<?php
ini_set('memory_limit', '512M');
ignore_user_abort(true);
set_time_limit(0);
// 全国地区数据
$urls = "https://www.stats.gov.cn/sj/tjbz/tjyqhdmhcxhfdm/2023/";

// 获取数据
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    usleep(100000); // 100毫秒的延迟
    return $data;
}

// 递归获取地区数据
function getRegionData($url) {
    $data = fetchData($url);

    // 匹配省级数据
    $provincePattern = '/<a href="(.*?)">(.*?)<br \/>/';
    preg_match_all($provincePattern, $data, $provinceMatches);

    $regions = [];

    // 遍历省级数据
    for ($i = 0; $i < count($provinceMatches[1]); $i++) {
        $province = [
            "url" => $provinceMatches[1][$i],
            "name" => $provinceMatches[2][$i],
            "code" => str_ireplace(".html", "", $provinceMatches[1][$i]),
            "children" => getCityData($GLOBALS['urls'] . $provinceMatches[1][$i])
        ];
        echo $provinceMatches[2][$i]."\n";
        // 保存省级数据到文件
        file_put_contents("China/" . $province['name'] . ".json", json_encode($province, JSON_UNESCAPED_UNICODE));

        $regions[] = $province;
    }

    return $regions;
}

// 获取市级数据
function getCityData($url) {
    $data = fetchData($url);

    $cityPattern = '/<a href="(.*?)">(.*?)<\/a><\/td><td><a href="(.*?)">(.*?)<\/a>/';
    preg_match_all($cityPattern, $data, $cityMatches);

    $cities = [];

    // 遍历市级数据
    for ($j = 0; $j < count($cityMatches[2]); $j++) {
        $city = [
            "url" => $cityMatches[3][$j],
            "name" => $cityMatches[4][$j],
            "code" => $cityMatches[2][$j],
            "children" => getCountyData($GLOBALS['urls'] . $cityMatches[3][$j])
        ];
        echo $cityMatches[4][$j]."\n";
        $cities[] = $city;
    }

    return $cities;
}

// 获取县级数据
function getCountyData($url) {
    $data = fetchData($url);
    $temurl = explode("/",$url);
    array_pop($temurl);
    $temurl = implode("/", $temurl)."/";
    $countyPattern = '/<a href="(.*?)">(.*?)<\/a><\/td><td><a href="(.*?)">(.*?)<\/a>/';
    preg_match_all($countyPattern, $data, $countyMatches);
    
    $counties = [];

    // 遍历县级数据
    for ($k = 0; $k < count($countyMatches[2]); $k++) {
        $county = [
            "url" => $countyMatches[3][$k],
            "name" => $countyMatches[4][$k],
            "code" => $countyMatches[2][$k],
            "children" => getTownData($temurl . $countyMatches[3][$k])
        ];
        echo $countyMatches[4][$k]."\n";
        $counties[] = $county;
    }

    return $counties;
}

// 获取镇级数据
function getTownData($url) {
    $data = fetchData($url);
    $temurl = explode("/",$url);
    array_pop($temurl);
    $temurl = implode("/", $temurl)."/";
    $townPattern = '/<a href="(.*?)">(.*?)<\/a><\/td><td><a href="(.*?)">(.*?)<\/a>/';
    preg_match_all($townPattern, $data, $townMatches);

    $towns = [];

    // 遍历镇级数据
    for ($m = 0; $m < count($townMatches[2]); $m++) {
        $town = [
            "url" => $townMatches[3][$m],
            "name" => $townMatches[4][$m],
            "code" => $townMatches[2][$m],
            "children" => getVillageData($temurl . $townMatches[3][$m])
        ];
        // echo $townMatches[4][$m]."\n";
        $towns[] = $town;
    }

    return $towns;
}

// 获取村级数据
function getVillageData($url) {
    $data = fetchData($url);

    $villagePattern = '/villagetr"><td>(.*?)<\/td><td>(.*?)<\/td><td>(.*?)<\/td>/';
    preg_match_all($villagePattern, $data, $villageMatches);

    $villages = [];

    // 遍历村级数据
    for ($n = 0; $n < count($villageMatches[1]); $n++) {
        $village = [
            "name" => $villageMatches[3][$n],
            "code" => $villageMatches[1][$n]
        ];
        // echo $villageMatches[3][$n]."\n";
        $villages[] = $village;
    }

    return $villages;
}

// 生成全国地区数据
$regions = getRegionData($urls);
file_put_contents("China/regions.json", json_encode($regions, JSON_UNESCAPED_UNICODE));
?>
