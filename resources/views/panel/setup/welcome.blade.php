@extends('panel/setup')
@section('content')

<div class="box box-success">
    <div class="box-header text-center"><strong class="box-title">ASWEB KURULUM</strong></div>
    <div class="box-body">
        <p><strong>ASWEB</strong> website yazılım kurulumuna hoş geldiniz.<br>
            Sadece 3 adım sonra web siteniz kurulmuş olacak.</p>
        <h4>Kurulum Adımları</h4>
        <ol>
            <li>Veritabanı (Database) ayarlamaları</li>
            <li>Website genel bilgi ayarlamaları</li>
            <li>Yönetici hesabı tanımlamak</li>
        </ol>
    </div>
    <div class="box-footer">
        <a href="{{ route('setup.database') }}" class="btn btn-info btn-block btn-md">Hazırsanız Başlayalım</a>
    </div>
</div>


@endsection
