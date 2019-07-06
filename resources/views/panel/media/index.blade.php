@extends('panel/master')
@section('content')
<div id="mediabox">
    @include("panel/media/popup")
</div>
@endsection

@section('end')
<style>
#mediabox{
    height: 100% !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
}
#closeMediaBox,
#useMediaImg{
    display: none;
}
</style>
@endsection
