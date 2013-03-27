/**
 * リンクのURLにカテゴリ番号をクエリとして追加する
 */
function addCategoryToLink(link) {
    
    if (!link.href) {
        return;
    }
    
    var tempHref = link.href;
    link.href = "#";
    var query = location.search.replace("?", "").split("&");
    
    for (var i = 0; i < query.length; i++) {
        var param = query[i];
        
        if (param.indexOf("category") >= 0) {
            tempHref += "&" + param;
            break;
        }
    }
    
    document.location = tempHref;
}