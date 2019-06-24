define(function (require, exports, module) {
    var e = {};
    require('jquery.jsonp')($)
    e.getRegion = function getRegion(parent_id,ele){
        var region_id=arguments[2]?arguments[2]:'';
        $.jsonp({
            url: API_URL + "/openform/region",
            data: {parent_id:parent_id},
            callback:"jsonp",
            success: function (data) {
                var html='';
                for(var i=0; i<data.length; i++){
                    html += '<option value="'+data[i].id+'"';
                    if(region_id == data[i].id) html += ' selected="selected"';
                    html += '>'+data[i].name+'</option>';
                }
                $("."+ele).append(html);
            },
            error: function (xOptions, textStatus) {
                console.log(xOptions);
            }
        });

    }
    module.exports = e
});