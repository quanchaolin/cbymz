function serializeForm(a) {// 参数为form标签
    var resultJson = {};// 要传递给后台的对象数据
    var array = a.serializeArray();// 序列化表单内容
    $(array).each(function() {
        resultJson[this.name] = this.value.trim();
    });
    return resultJson;
}
$(function () {
    /*$('#form').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });*/
});