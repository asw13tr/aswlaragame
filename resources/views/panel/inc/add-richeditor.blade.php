<link rel="stylesheet" href="{{ url('panel/plugins/summernote/summernote-lite.css') }}">
<script src="{{ url('panel/plugins/summernote/summernote.js') }}"></script>
<script src="{{ url('panel\plugins\summernote\lang\summernote-tr-TR.js') }}"></script>
<script src="{{ url('panel\plugins\summernote\plugin\specialchars\summernote-ext-specialchars.js') }}"></script>
<script>
	$(function(){

RichEditor = $('.richeditor');
RichEditor.summernote({

	minHeight: 400,
	maxHeight: 700,
	tabsize: 4,
	lang: 'tr-TR',
	airMode: false,
	shortcuts: true,
	disableDragAndDrop: false,
	dialogsFade: true,
	//focus: true,
	codemirror: {
		theme: 'monokai'
	},
	toolbar: [
		['style', ['style', ['fontsize']/*'fontname',*/]],
		['style', ['bold', 'italic', 'underline', 'clear', '|', 'strikethrough', 'superscript', 'subscript']],
		['font', ],
		['insert', ['link',/* 'aswupload',*/ 'picture', 'video', 'table', 'hr']],
		['color', [/*'color', */'forecolor', 'backcolor']],
		['para', ['ul', 'ol', 'paragraph']],
		//['height', ['height']],
		['misc', [/*'fullscreen',*/ 'codeview', /*'undo', 'redo',*/'specialchars']],
	],
	callbacks: {
		onImageUpload: function(files) {
	        summerImageUplaoad(files[0]);
	    }
	}





});

$('.note-popover').hide(0);

function summerImageUplaoad(file){
	var formData = new FormData();
	formData.append('image', file);
	$.ajax({
		url: '{{ route('panel.ajax.image.upload') }}',
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		dataType: 'json',
		enctype: 'multipart/form-data',
		success: function(result){
			if(result.status == true){
				var img = $('<img src="'+result.src+'" class="img-responsive img-fluid" alt="'+result.alt+'"/>');
				RichEditor.summernote('insertNode', img[0]);
			}
		}
	});
}//summerImageUplaoad



$('span#ortam').on('click', function(){
	var resim = $('<img src="http://www.mmsrn.com/wp-content/uploads/2015/10/Adana-Merkez-Patl%C4%B1yor-Herkes-%C5%9Eark%C4%B1-S%C3%B6zleri.jpg" alt="deneme" />');
	RichEditor.summernote('insertNode', resim[0]);
});

	});

</script>
