define(function (require, exports, module) {
    var e = {};
    e.getRegion = function getRegion(parent_id,ele){
        var region_id=arguments[2]?arguments[2]:'';
        $.get("/region",{parent_id:parent_id},function(data){
            var html='';
            for(var i=0; i<data.length; i++){
                html += '<option value="'+data[i].id+'"';
                if(region_id == data[i].id) html += ' selected="selected"';
                html += '>'+data[i].region_name+'</option>';
            }
            $("."+ele).append(html);
        },'json');
    }
    module.exports = e
});