<link rel="stylesheet" href="{{ url('panel/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<script src="{{ url('panel/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('panel/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#aswdatatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'order':      [[ 0, "desc" ]],
      'info'        : true,
      'autoWidth'   : false,
      'stateSave'   : true,
      'pagingType'  : "full_numbers", //https://datatables.net/examples/basic_init/alt_pagination.html
      'language': {
            //"lengthMenu": "Display _MENU_ records per page",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Hepsi"]],
            "sProcessing":   "İşleniyor...",
        	"sLengthMenu":   "Sayfada _MENU_ Kayıt Göster",
        	"sZeroRecords":  "Eşleşen Kayıt Bulunmadı",
        	"sInfo":         "  _TOTAL_ Kayıttan _START_ - _END_ Arası Kayıtlar",
        	"sInfoEmpty":    "Kayıt Yok",
        	"sInfoFiltered": "( _MAX_ Kayıt İçerisinden Bulunan)",
        	"sInfoPostFix":  "",
        	"sSearch":       "Bul:",
        	"sUrl":          "",
        	"oPaginate": {
        		"sFirst":    "İlk",
        		"sPrevious": "Önceki",
        		"sNext":     "Sonraki",
        		"sLast":     "Son"
        	}
        }
    })
  })
</script>
