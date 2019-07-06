@if(isset($data))
<div class="col-xs-12 p2">
    @if($data->status=="published")
        <p class="text-success">Bu içerik web sitesinde <b>Yayımlanıyor.</b></p>
    @elseif($data->status=="draft")
        <p class="text-warning">Bu içerik <b>Taslak</b> olarak kayıtlı ve web sitesinde <b>Yayımlanmıyor.</b>.</p>
    @elseif($data->status=="trash")
        <p class="text-danger">Bu içerik şuan <b>Çöp kutusunda</b> ve <b>Yayımlanmıyor.</b> <br/> <b>Dikkat edin:</b> <u>Sil</u> butonuna bastığınızda tekrar sorulmadan silinecektir.</p>
    @endif
</div>
@endif

<div class="col-xs-4 p3">
    @if( isset($data) && $data->status=="published" )
        <button class="btn btn-success btn-block p2 pt7 pb7 balon" name="status" value="published" title="İçeriği Güncelle"><span class="fa fa-eye"></span> Güncelle</button>
    @else
        <button class="btn btn-primary btn-block p2 pt7 pb7 balon" name="status" value="published" title="İçeriği Yayımla"><span class="fa fa-eye"></span> Yayımla</button>
    @endif
</div>

<div class="col-xs-4 p3">
    @if( isset($data) && $data->status=="draft" )
        <button class="btn bg-orange btn-block p2 pt7 pb7 balon" name="status" value="draft" title="Taslağı Güncelle"><span class="fa fa-save"></span> Kaydet</button>
    @else
        <button class="btn btn-warning btn-block p2 pt7 pb7 balon" name="status" value="draft" title="Taslak Olarak Kaydet"><span class="fa fa-save"></span> Taslak</button>
    @endif
</div>

@if( isset($data) )
<div class="col-xs-4 p3">
    @if( $data->status=="trash" )
        <button class="btn btn-danger btn-block p2 pt7 pb7 balon" name="status" value="trash" title="Tamamen Sil"><span class="fa fa-trash-o"></span> Sil</button>
    @else
        <button class="btn bg-purple btn-block p2 pt7 pb7 balon" name="status" value="trash" title="Çöpe Taşı"><span class="fa fa-trash-o"></span> Çöp</button>
    @endif
</div>
@endif
