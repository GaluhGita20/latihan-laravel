<html>
    <head>
        <title>{{ $title }}</title>
        <style>
            * {
                box-sizing: border-box;
            }
            /** Define the margins of your page **/
            @page { margin: 1cm 1.5cm 1cm 1.5cm;}

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
                bottom: -5px; 
                left: 0px; 
                right: 0;
                height: 50px; 
                line-height: 35px;
            }

            body {
                margin-top: 3cm;
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
            }

            tr th,
            tr td {
              border-bottom:1pt solid black;
              border:1pt solid black;
              border-right:1pt solid black;
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
    <body class="page">
        <header>
            <table style="border:none; width: 100%;">
                <tr>
                    <td style="border:none;" width="150px" >
                        <img src="{{ config('base.logo.print') }}" style="max-width: 150px; max-height: 60px">
                    </td>
                    <td style="border:none;  text-align: center; font-size: 14pt;" width="auto">
                        <b>{{ 'WORK REQUEST' }}</b>
                        <div><b>{{ strtoupper(config('base.company.name')) }}</b></div>
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
            <table style="border:none; width:100%;">
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">ID Work Request</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{{ $record->no_request }}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Judul</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{{ $record->title }}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Deskripsi</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{!! $record->description !!}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Aset</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{{ $record->aset->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Lokasi</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{{ $record->subLocation->lokasi->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Sub Lokasi</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">{{ $record->subLocation->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: none; vertical-align: top; width: 150px;">Lampiran</td>
                    <td style="border: none; vertical-align: top; width: 10px; text-align: left;">:</td>
                    <td style="border: none; vertical-align: top; text-align: left;">
                        <ul>
                            @foreach ($record->files($module)->where('flag', 'attachments')->get() as $file)
                                <li>
                                    <a href="{{ $file->file_url }}" target="_blank">
                                        {{ $file->file_name }}
                                    </a>
                                </li>    
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </main>
    </body>
</html>