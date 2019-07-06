@extends('panel/setup')
@section('content')
<form action="{{ route('setup.generalPost') }}" method="post">@csrf
<div class="box box-success">
    <div class="box-header text-center"><strong class="box-title">TEBRİKLER :)</strong></div>
    <div class="box-body">

    <p>Herşey bu kadar :)</p>
    <p>Site kurulumunuz başarılı bir şekilde tamamlandı. Şimdi gitmek istediğiniz yeri seçin.</p>


    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-xs-6"><a href="{{ route('frontpage') }}" class="btn btn-block btn-success">Siteye Git</a></div>
            <div class="col-xs-6"><a href="{{ route('panel.dashboard') }}" class="btn btn-block btn-primary">Panele Git</a></div>
        </div>
    </div>
</div>
</form>
@endsection
