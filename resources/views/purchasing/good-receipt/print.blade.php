<html>

<head>
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        /** Define the margins of your page **/
        @page {
            margin: 1cm 1.5cm 1cm 1.5cm;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            /*margin-left: 10mm;*/
            /*margin-right: 5mm;*/
            /*line-height: 35px;*/
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0px;
            right: 0;
            height: 50px;
            line-height: 35px;
        }

        body {
            margin-top: 2cm;
            font-size: 12pt;
        }

        .pagenum:before {
            content: counter(page);
            content: counter(page, decimal);
        }

        table {
            width: 100%;
            border: 1pt solid black;
            border-collapse: collapse;
            /* table-layout: fixed; */
        }

        tr th,
        tr td {
            border-bottom: 1pt solid black;
            border: 1pt solid black;
            border-right: 1pt solid black;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        .table-data {
            height: 44px;
            background-repeat: no-repeat;
            /*background-position: center center;*/
            border: 1px solid;
            /*text-align: justify;*/
            /*background-color: #ffffff;*/
            font-weight: normal;
            /*color: #555555;*/
            /*padding: 11px 5px 11px 5px;*/
            vertical-align: middle;
        }

        .table-data tr th,
        .table-data tr td {
            padding: 5px 8px;
        }

        .table-data tr td {
            vertical-align: top;
        }

        .page-break: {
            page-break-inside: always;
        }

        .nowrap {
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
</head>

<body class="page">
    <header>
        <table style="border:none; width: 100%;">
            <tr>
                <td style="border:none;" width="150px">
                    <img src="{{ config('base.logo.print') }}" style="max-width: 150px; max-height: 60px">
                </td>
                <td style="border:none;  text-align: center; font-size: 14pt;" width="auto">
                    <b>{{ __('STP QHSE PERENCANAAN') }}</b>
                    <div><b>KPI {{ strtoupper($record->unitKerja->name) }}</b></div>
                </td>
                <td style="border:none; text-align: right; font-size: 12px;" width="150px">
                    <b></b>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <footer>
        <table width="100%" border="0" style="border: none;">
            <tr>
                <td style="width: 10%;border: none;" align="right"><span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>
    <main>
        <table style="border:none; width:100%; margin-top: 0.5rem;">
            <tr>
                <td style="border:none; width:48%;">
                    <table style="border:none; width:100%;">
                        <tr>
                            <td style="border: none; width: 100px;">{{ __('Tahun') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->tahun }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 100px;">{{ __('Unit Kerja') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->unitKerja->name }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 100px;">{{ __('Bidang') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->bidang->name }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; width: 100px;">{{ __('Target') }}</td>
                            <td style="border: none; width: 10px; text-align: left;">:</td>
                            <td style="border: none; text-align: left;">{{ $record->target->name }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <div style="page-break-inside: avoid;">
            <div style="text-align:left;">Rangkuman :</div>
            <br>
            <table class="table-data" width="100%" border="1" style="table-layout: fixed">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th class="text-center">{{ __('Bulan') }}</th>
                        <th class="text-center">{{ __('Prosentase') }}</th>
                        <th class="text-center">{{ __('Rangkuman') }}</th>
                        <th class="text-center" style="width: 50%;">{{ __('Lampiran') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->detail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->bulan }}</td>
                        <td>{{ $detail->prosentase }}</td>
                        <td>{{ str_word_count($detail->rangkuman) }} Words</td>
                        <td>
                            <ul>
                                @foreach ($detail->files($module)->where('flag', 'attachments')->get() as $file)
                                <li>
                                    <a href="{{ $file->file_url }}" target="_blank" class="text-primary">
                                        {{ $file->file_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        @if ($record->approval($module)->exists())
        <div style="page-break-inside: avoid;">
            <div style="text-align: center;">
                {{ $record->unitKerja->name .", ".now()->translatedFormat('d F Y') }}<br>
                {{ __('Menyetujui') }},
            </div>
            <table style="border:none;">
                <tbody>
                    @php
                    $ids = $record->approval($module)->pluck('id')->toArray();
                    $length = count($ids);
                    @endphp
                    @for ($i = 0; $i < $length; $i +=4) <tr>
                        @if (!empty($ids[$i]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+1]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+1]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+2]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+2]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        @if (!empty($ids[$i+3]))
                        <td style="border: none; text-align: center; width: 33%; vertical-align: bottom;">
                            @if ($approval = $record->approval($module)->find($ids[$i+3]))
                            @if ($approval->status == 'approved')
                            <div style="height: 110px; padding-top: 15px;">
                                {!! \Base::getQrcode('Approved by: '.$approval->user->name.',
                                '.$approval->approved_at)
                                !!}
                            </div>

                            <div><b><u>{{ $approval->user->name }}</u></b></div>
                            <div>{{ $approval->user->position->name }}</div>
                            @else
                            <div style="height: 110px; padding-top: 15px;; color: #ffffff;">#</div>
                            <div><b><u>(............................)</u></b></div>
                            <div>{{ $approval->role->name }}</div>
                            @endif
                            @endif
                        </td>
                        @endif
                        </tr>
                        @endfor
                </tbody>
            </table>
            <footer>
                <table table width="100%" border="0" style="border: none;">
                    <tr>
                        <td style="width: 10%;border: none;">
                            <small>
                                <i>***Dokumen ini sudah ditandatangani secara elektronik oleh KPI {{
                                    strtoupper($record->unitKerja->name) }}.</i>
                                <br><i>Tanggal Cetak: {{now()->translatedFormat('d F Y H:i:s')}}</i>
                            </small>
                        </td>
                    </tr>
                </table>
            </footer>
        </div>
        @endif
    </main>
</body>

</html>