<?php $info = json_decode($item->info, false); ?>
<div class="col-xs-4 col-sm-3 col-md-2 mediapopupitem item-{{ $item->id }}">
   <div class="mpitem"
   data-id="{{ $item->id }}"
   data-name="{{ $item->src }}"
   data-src="{{ getImageSrc($item->src, null, asw('path_media_upload')) }}"
   data-sm="{{  getImageSrc($item->src, 'sm', asw('path_media_upload')) }}"
   data-md="{{  getImageSrc($item->src, 'md', asw('path_media_upload')) }}"
   data-lg="{{  getImageSrc($item->src, 'lg', asw('path_media_upload')) }}"
   data-alt="{{ $item->alt }}"
   data-title="{{ $item->title }}"
   data-date="{{ timestampToString($item->created_at) }}"
   data-size="{{ byteToStr($info->size) }}"
   data-width="{{ $info->width }}"
   data-height="{{ $info->height }}"
   data-type="{{ $info->mime }}"
   data-ext="{{ $info->ext }}"
   >
       <img src="{{ getImageSrc($item->src, 'sm', asw('path_media_upload')) }}" class="img-responsive"/>
   </div>
</div>
