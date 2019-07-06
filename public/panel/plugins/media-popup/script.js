(function($) {
//============================


// İLK AYARLAMALAR VE DEĞİŞKEN ATAMALARI
var $mediaBoxButton = $('.mediaBoxButton');
var $mediaBoxUrl = $('input#mediaBoxUrl').val();
var $imgUploadUrl = $('input#ajaxImageUploadUrl').val();
var $mediaBoxOut = $('<div id="mediaBoxOut"></div>');
var $mediaBox = $('<div id="mediaBox"></div>');
var $mediaItemOffset = 30;
var $keyDEL = 46;
var $keyCTRL = 17;
var $keyENTER = 13;
var $keyESC = 27;
$mediaBoxOut.html($mediaBox);
$opened = false;
$selectedImg = null;
//startMediaBox();

/*
    ...
    -> ÇALIŞACAK FONKSİYONLAR
    ...
*/
// POPUP KAPATMA
function resetMediaBox(){
    $mediaBox.html('');
    $mediaBoxOut.remove();
    $opened = false;
    $selectedImg = null;
    $mediaItemOffset = 30;
}//resetMediaBox

// SEÇİLİ RESMİ RESETLEME
function resetFocusImg(id){
    document.getElementById("focusImgForm").reset();
    $('#mediaBoxInfoSide figure span').text('');
    $('#mediaBoxInfoSide img').attr('src', '');
    $('#mediaBoxInfoSide section').hide(0);
    $('.mediapopupitem.item-'+id+' .mpitem').attr('style', 'border-color: red;').parent().fadeOut(100);
    $selectedImg = null;
    $('#useMediaImg').attr('disabled', '');
}//resetMediaBox

// POPUP AÇMA
function startMediaBox(){
    if($opened != true){
        $mediaBox.load($mediaBoxUrl, function(e){
            $('body').append($mediaBoxOut);
            if($('#mbitems').height() == $('#mbitems').prop('scrollHeight')){
                console.log('scroll çalışsın');
            }
        });

        $opened = true;
    }
}//startMediaBox

function loadMoreMediaBox(){
    var newDatas = $('<div/>').load($mediaBoxUrl+"?offset="+$mediaItemOffset, function(e){
        $mediaItemOffset += 30;
        $('#mbitems .row').append(e);
    });
}

// POPUPDA RESME ODAKLANMA
function focusImg(item){
    $selectedImg = {
        id: item.data('id'),
        src: item.data('src'),
        title: item.data('title'),
        alt: item.data('alt'),
        type: item.data('type')
    };
    $('.mpitem').removeClass('active');
    $('.mpitem[data-id="'+$selectedImg.id+'"]').addClass('active');
    fillSide(item);
}//focusImg


// POPUPDA RESİM SEÇME
function useImg(){
    if($selectedImg != null){
        var alt = $('#mediaBoxInfoSide input#alt').val();
        var src = $('.urlinputs input.selected').val();
        var img = $('<img src="'+src+'" class="img-responsive img-fluid" alt="'+alt+'"/>');
        $('.richeditor').summernote('insertNode', img[0]);
        resetMediaBox();
    }
}//useImg

// DOSYA BİLGİLERİNİ DOLDUR
function fillSide(item){
    $('#mediaBoxInfoSide > section').fadeIn(50);
    $('#mediaBoxInfoSide #id').val(item.data('id'));
    $('#mediaBoxInfoSide #img').attr('src', item.data('src'));
    $('#mediaBoxInfoSide #name span') .text( item.data('name') );
    $('#mediaBoxInfoSide #type span') .text( '['+item.data('type')+'] - (.'+item.data('ext')+')' );
    $('#mediaBoxInfoSide #date span') .text( item.data('date') );
    $('#mediaBoxInfoSide #size span') .text( item.data('size') );
    $('#mediaBoxInfoSide #scale span').text( item.data('width')+'x'+item.data('height')+' px' );
    $('#mediaBoxInfoSide #title').val( item.data('title') );
    $('#mediaBoxInfoSide #alt').val( item.data('alt') );
    $('#mediaBoxInfoSide #url_original').val( item.data('src') );
    $('#mediaBoxInfoSide #url_lg').val( item.data('lg') );
    $('#mediaBoxInfoSide #url_md').val( item.data('md') );
    $('#mediaBoxInfoSide #url_sm').val( item.data('sm') );
    $('#useMediaImg').removeAttr('disabled');
}//fillSide


// GÖRSELİ GÜNCELLEMEK
function updateImg(data, url){
    $.ajax({url: url,   type: 'post',   data: data,     dataType: 'json',
        success: function(result){
            if(result.status == true){
                $('#mediaBoxButtonUpdate').addClass('btn-success').text('Güncellendi...');
                setTimeout(function(){
                        $('#mediaBoxButtonUpdate').removeClass('btn-success').text('Güncelle');
                }, 2000);
            }else{
                $('#mediaBoxButtonUpdate').addClass('btn-danger').text('Tekrar Dene');
            }
        }
    });
}//updateImg


function deleteImg(id, url){
    var next = $('.mediapopupitem.item-'+id).next();
    $.ajax({url: url,   type: 'post',   data: {id:id},     dataType: 'json',
        success: function(result){
            if(result.status == true){
                resetFocusImg(id);
                next.find('.mpitem').trigger('click');
            }else{
                $('#mediaBoxButtonDestroy').addClass('btn-danger').text('Tekrar Dene');
            }
        }
    });
}

// Resim upload işlemleri
function uploadImg(data){
    var formData = new FormData();
    formData.append('image', data);
    $.ajax({
        url: $imgUploadUrl,
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        enctype: 'multipart/form-data',
        success: function(result){
            var item = $('.item-loading').last();
            if(result.status != true){
                item.addClass('sad');
            }else{
                item
                    .removeClass('item-loading')
                    .addClass('item-'+result.data.id)
                    .find('.mpitem')
                    .attr('data-id'      , result.data.id)
                    .attr('data-name'    , result.data.name)
                    .attr('data-src'     , result.data.src)
                    .attr('data-sm'      , result.data.sm)
                    .attr('data-md'      , result.data.md)
                    .attr('data-lg'      , result.data.lg)
                    .attr('data-alt'     , result.data.alt)
                    .attr('data-title'   , result.data.title)
                    .attr('data-date'    , result.data.date)
                    .attr('data-size'    , result.data.size)
                    .attr('data-width'   , result.data.width)
                    .attr('data-height'  , result.data.height)
                    .attr('data-type'    , result.data.type)
                    .attr('data-ext'     , result.data.ext)
                    .append('<img src="'+result.data.sm+'" class="img-responsive"/>')
                    .trigger('click');

            }

        }
    });
}//uploadImg





/*
    ...
    -> OLAY ATAMALARI
    ...
*/
$mediaBoxButton.on('click', function(){
    startMediaBox();
});

$(document).on('click', '.mpitem', function(){
    focusImg( $(this) );
});

$(document).on('click', '#useMediaImg', function(){
    useImg();
});

$(document).on('click', '#closeMediaBox', function(){
    resetMediaBox();
});

$(document).on('change', 'select#showInputUrl', function(){
    var id = $(this).val();
    $('.urlinputs input').removeClass('selected').hide(0);
    $('.urlinputs input#'+id).addClass('selected').fadeIn(61);
});

$(document).on('click', '#mediaBoxButtonUpdate', function(){
    var url = $('input#mediaBoxImageUpdateUrl').val();
    var data = $('form#focusImgForm').serialize();
    updateImg(data, url);
});

$(document).on('click', '#mediaBoxButtonDestroy', function(){
    if(confirm('Seçili görsel tamamen media dosyalarından tamamen silinecek. Kabul ediyor musunuz?')){
        var url = $('input#mediaBoxImageDestroyUrl').val();
        var id = $('form#focusImgForm input#id').val();
        deleteImg(id, url);
    }
});

$(document).on('click', '#imgUploadFromComputer', function(){
    $('input#mediaBoxFileInput').trigger("click");
});

$(document).on('change', 'input#mediaBoxFileInput', function(){
    $.each($(this)[0].files, function(k, v){
        var newItem = '<div class="col-xs-4 col-sm-3 col-md-2 mediapopupitem item-loading">'+
                      '<div class="mpitem"></div>'+
                      '</div>';
        $('#mbitems .row').prepend(newItem);
        uploadImg(v);
    });
});

$(document).on('keyup', function(e){
    if(e.which == $keyDEL && $selectedImg != null){
        $('#mediaBoxButtonDestroy').trigger('click');
    }
    if(e.which == $keyESC && $opened == true){
        resetMediaBox();
    }
});

document.addEventListener('scroll', function (event) {
    if (event.target.id === 'mbitems') { // apply any filtering condition
        var offset =  $('#mbitems .row').offset().top;
        var heightDiv = $('#mbitems').height();
        var heightRow = $('#mbitems .row').height();
        var scrollTop = $('#mbitems').scrollTop();
        var number = (Math.ceil(heightRow) - heightDiv) - 1;
        if(scrollTop > number){
            loadMoreMediaBox();
        }
        console.log(offset);
        console.log(heightDiv);
        console.log(heightRow);
        console.log(scrollTop);
        console.log(number);
        console.log("---------");

    }
}, true /*Capture event*/);

//============================
})(jQuery);
