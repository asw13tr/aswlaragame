<div id="mediaBoxIn">
<div id="mediaBoxHeader">
    <strong class="pull-left">Medya Dosyaları</strong>
    <button type="button" id="closeMediaBox" class="fa fa-close pull-right btn btn-default btn-md"></button>
    <div class="clearfix"></div>
</div>

<div id="mediaBoxBody">
    <div class="row">
        <div class="col-sm-9" id="mbitems">
        @if(isset($items))
        <div class="row">
             @foreach($items as $item)
             @include("panel/media/popup-item")
             @endforeach
        </div>
        @endif
        </div>



        <aside class="col-sm-3" id="mediaBoxInfoSide">
        <section>


            <figure>
                <img src="" id="img" class="img-responsive">
                <figcaption>
                    <div id="name"><strong>Dosya Adı:</strong>        <span></span> </div>
                    <div id="type"><strong>Tip / Uzantı:</strong>       <span></span> </div>
                    <div id="date"><strong>Yüklenme Tarihi</strong>   <span></span> </div>
                    <div id="size"><strong>Dosya Boyutu</strong>      <span></span> </div>
                    <div id="scale"><strong>Ölçüler</strong>           <span></span> </div>
                </figcaption>
            </figure>


            <form id="focusImgForm">
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label>Görsel Başlığı</label>
                    <input type="text" class="form-control input-sm" name="title" id="title">
                </div>

                <div class="form-group">
                    <label>Açıklama <cite>( alt="..." )</cite></label>
                    <input type="text" class="form-control input-sm" name="alt" id="alt">
                </div>

                <div class="form-group urlinputs">
                    <label>Görsel Adresi</label>
                    <select id="showInputUrl" class="form-control input-sm">
                        <option value="url_original">Orjinal boyut</option>
                        <option value="url_lg">Büyük</option>
                        <option value="url_md">Orta</option>
                        <option value="url_sm">Küçük</option>
                    </select>
                    <input type="text" readonly class="form-control input-sm selected" id="url_original">
                    <input type="text" readonly class="form-control input-sm" id="url_lg">
                    <input type="text" readonly class="form-control input-sm" id="url_md">
                    <input type="text" readonly class="form-control input-sm" id="url_sm">
                </div>

                <div class="form-group">
                    <input type="hidden" id="mediaBoxImageUpdateUrl" value="{{ route('panel.ajax.media.box.image.update') }}">
                    <input type="hidden" id="mediaBoxImageDestroyUrl" value="{{ route('panel.ajax.media.box.image.destroy') }}">
                    <button type="button" id="mediaBoxButtonUpdate" class="btn btn-primary btn-sm pull-right ml7">Güncelle</button>
                    <button type="button" id="mediaBoxButtonDestroy" class="btn btn-danger btn-sm pull-right">Sil</button>
                </div>
            </form>

        </section>
        </aside>
    </div><!-- row -->
</div><!-- mediaBoxBody -->

<div id="mediaBoxFooter">
    <button class="btn btn-primary btn-md pull-right ml5" disabled id="useMediaImg">Görseli Kullan</button>
    <input type="file" id="mediaBoxFileInput" multiple/>
    <button class="btn btn-success btn-md pull-right ml5" id="imgUploadFromComputer">Bilgisayardan Seç</button>
    <button class="btn btn-danger btn-md pull-right" id="closeMediaBox">Vazgeç</button>
    <div class="clearfix"></div>
</div>
</div><!-- mediaBoxIn -->
