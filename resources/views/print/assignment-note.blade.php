<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Asignment Note</title>

    {{-- favicon --}}
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-si-panjul.png') }}">
</head>
<body class="padding:60px;">
    <div>
        <div style="float: left;">
            <img style="margin-right: 3rem; width: 150px;" src="{{ public_path('assets/img/UINSU.png') }}">
        </div>
        <div style="float:left;text-align:center;">
            <h3 style="margin: 0;"><strong>KEMENTRIAN AGAMA REPUBLIK INDONESIA</strong></h3>
            <h4 style="margin: 0;"><strong>UNIVERSITAS ISLAM NEGERI SUMATERA UTARA MEDAN</strong></h4>
            <h4 style="margin: 0;"><strong>FAKULTAS SAINS DAN TEKNOLOGI</strong></h4>
            <p style="margin: 0;">Jl. Lapangan Golf, Desa Durian Jangak, Kec. Pancur Batu</p>
            <p style="margin: 0;">Kabupaten Deli Serdang, Provinsi Sumatera Utara, Kode Pos 20353</p>
            <p style="margin: 0;">Website: saintek.uinsu.ac.id, E-mail: saintek@uinsu.ac.id</p>
        </div>
    </div>
    <hr style="clear:both;height:1px;margin:0;background-color:black;border-style:double;">
    <hr style="margin:1;">
    <h3 style="text-decoration:underline;text-align:center;margin-bottom:0;"><strong>SURAT TUGAS</strong></h3>
    <p style="text-align:center;margin:0;">Nomor: B.192/ST.IV.2/ST.V.2/HM.{{\Carbon\Carbon::now()->format('d/m/Y')}}</p>

    <p style="margin-left:50px;margin-bottom:0;">Dekan Fakultas Sains dan Teknologi Universitas Islam Negeri Sumatera Utara Medan dengan ini</p>
    <p style="margin-top:0">menugaskan :</p>

    @php $i=1 @endphp
    @foreach ($proposal_lecturers as $lecturer)
        <p style="margin-left:120px;margin-bottom:0px;margin-top:0;">
            Dosen Pembimbing {{$i++}}
            <span style="margin-left:50px">: {{$lecturer->user->name}}</span>
        </p>
    @endforeach

    <p>Untuk menjadi Pembimbing Proposal Skripsi dan Skripsi Mahasiswa di bawah ini :</p>

    <p style="margin-left:120px;margin-bottom:0px;">
        Nama 
        <span style="margin-left:150px">: {{$proposal->name}}</span>
    </p>
    <p style="margin-left:120px;margin-bottom:0px;margin-top:0;">
        Nim 
        <span style="margin-left:160px">: {{$proposal->nim}}</span>
    </p>
    <p style="margin-left:120px;margin-top:0;">
        Program Studi 
        <span style="margin-left:95px">: Sistem Informasi</span>
    </p>

    <p>Dengan judul skripsi "<strong style="text-decoration:bold;">{{strtoupper($proposal->title)}}</strong>".</p>

    <p>Demikian Surat Tugas ini disampaikan, untuk dilaksanakan dengan penuh tanggung jawab.</p>

    <p style="margin-left:350px;margin-bottom:0;margin-top:40;">Medan, {{ strftime('%d %B %Y', strtotime(\Carbon\Carbon::now())) }}</p>
    <p style="margin-left:350px;margin-top:0;margin-bottom:0px;">An. Dekan</p>
    <p style="margin-left:350px;margin-top:0;margin-bottom:0;">Ketua Program Studi Sistem Informasi</p>

    <img style="margin-left:350px;margin-top:5;margin-bottom:5px;width:130px;" src="{{ public_path('storage/barcodes/'.$kaprodi_barcode) }}"/>
    
    <p style="margin-left:350px;margin-top:0;margin-bottom:0;"><strong style="text-decoration:bold;">{{$kaprodi_name}}</strong></p>
    <p style="margin-left:350px;margin-top:0;">NIP : {{$kaprodi_nip}}</p>

    <p style="margin-bottom:0;margin-top:30;">Tembusan :</p>
    <p style="margin-left:30px;margin-top:0;margin-bottom:0">1. Dekan Fakultas Sains dan Teknologi</p>
    <p style="margin-left:30px;margin-top:0;margin-bottom:0">2. Kasubbag Akademik Fakultas Sains dan Teknologi</p>
    <p style="margin-left:30px;margin-top:0;margin-bottom:0">3. Dosen Pembimbing 1 dan 2 Fakultas Sains dan Teknologi</p>
    
</body>
</html>