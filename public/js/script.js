$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function continuousWork(){
    var headerHeight = $('header#header').height();
    $('body').attr('style', 'margin-top: '+(headerHeight+30)+'px');
    $('#tags a').each(function(){ $(this).attr('style', 'color:'+getRandomColor()); });

    if( $('#objGame').width() > $('#game-obj').width() ){
        var gw = $('#objGame').width();
        var ow = $('#game-obj').width()
        var gp = ( ow / gw ) * 100;
        $('#objGame').width( $('#game-obj').width() ).height( calcPercent($('#objGame').height(), gp) );
    }

    $('#game-fullscreen-single #game-obj').height( $(window).height()-(headerHeight+40) );
}
continuousWork();

$(window).resize(function(){
    continuousWork();
});

function getRandomColor(){
    var colours = [
        '#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', '#8BC34A',
        '#CDDC39', '#FFEB3B', '#FFC107', '#FF5722', '#795548', '#9E9E9E', '#607D8B',

        '#e57373', '#F06292', '#BA68C8', '#9575CD', '#7986CB', '#64B5F6', '#4FC3F7', '#4DD0E1', '#4DB6AC', '#81C784', '#AED581',
        '#DCE775', '#FFF176', '#FFD54F', '#FFB74D', '#FF8A65', '#A1887F', '#90A4AE',

        '#c62828', '#AD1457', '#6A1B9A', '#4527A0', '#283593', '#1565C0', '#0277BD', '#00838F', '#00695C', '#424242', '#558B2F',
        '#9E9D24', '#F9A825', '#FF8F00', '#EF6C00', '#D84315', '#4E342E', '#37474F'
    ];
    var key = Math.floor( Math.random() * colours.length );
    return colours[key];
}

function jsFocus(){
    $('body').prepend('<div class="jsFocus"></div><span class="jsFocusClose glyphicon glyphicon-remove"></span>');
    $('#game-obj').addClass('focus');
    $('.jsFocus').fadeIn(250);
}

function jsShowScaleBar(){  $('#scaleToObjGame').fadeIn(250);   }

$(document).on('click', 'span.jsFocusClose', function(){
    $('.jsFocus').fadeOut(250).remove();
    $('.jsFocusClose').remove();
    $('#game-obj').removeClass('focus');
});


function calcPercent(sayi, miktar){
    return (sayi / 100) * miktar;
}
var objGameWidth, objGameHeight;
$('#scaleToObjGame input').on('input', function(){
    if(objGameWidth==undefined || objGameHeight==undefined){
        objGameWidth = $('#objGame').width();
        objGameHeight = $('#objGame').height();
        $('#game-obj').addClass('no-overflow');
        $('#game-obj').removeClass('scaleto');
    }
    var yuzde = $(this).val();
    $('#objGame').width( calcPercent(objGameWidth, yuzde) ).height( calcPercent(objGameHeight, yuzde) );
    $('#scaleToObjGame label').text('Ölçek: %'+yuzde);
});
