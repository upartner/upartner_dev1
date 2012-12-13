function xml2Json(url) {
    var proxyUrl = "http://app.drk7.jp/xml2json/";
    var callUrl = proxyUrl + "var=callBackX2J&url=" + encodeURIComponent(url);
    var script = document.createElement('script');
    script.charset = 'UTF-8';
    script.src = callUrl;
    document.body.appendChild(script);
    return callUrl;
}

//JSONPコールバック関数

//コールバックオブジェクトを用意して，
var callBackX2J = {}

//そのオブジェクト内のonloadというメソッドに取得したデータを戻す
//メソッド内では受け取ったデータをマップに反映するためのsetMarkersを呼び出す
callBackX2J.onload = function(res) {
    return res;
}