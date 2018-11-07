(function (doc, win) {
    var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            docEl.style.fontSize = 100 * (clientWidth / 1080) + 'px';
//alert(clientWidth);
        };

    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);
function play_music(){
    if ($('#mc_play').hasClass('on')){
        $('#mc_play audio').get(0).pause();
        $('#mc_play').attr('class','stop');
    }else{
        $('#mc_play audio').get(0).play();
        $('#mc_play').attr('class','on');
    }
    $('#music_play_filter').hide();
    event.stopPropagation(); //阻止冒泡
}
function just_play(id){
    $('#mc_play audio').get(0).play();
    $('#mc_play').attr('class','on');
    if (typeof(id)!='undefined'){
        $('#music_play_filter').hide();
    }
    event.stopPropagation(); //阻止冒泡
}