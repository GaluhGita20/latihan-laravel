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
                        <b>{{ __('EXAMPLE CRUD') }}</b>
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
                    <td style="border:none; width:45%;">
                        <table style="border:none; width:100%;">
                            <tr>
                                <td style="border: none; width: 100px;">{{ __('Tahun') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->year }}</td>
                            </tr>
                            <tr>
                                <td style="border: none; width: 100px;">{{ __('Tanggal') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->show_date }}</td>
                            </tr>
                            <tr>
                                <td style="border: none; width: 100px;">{{ __('Rentang') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->show_range_start.' - '.$record->show_range_end }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="border:none; width:55%;">
                        <table style="border:none; width:100%;">
                            <tr>
                                <td style="border: none; width: 150px;">{{ __('Input') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->input }}</td>
                            </tr>
                            <tr>
                                <td style="border: none; width: 150px;">{{ __('Option') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->getOption($record->option) }}</td>
                            </tr>
                            <tr>
                                <td style="border: none; width: 150px;">{{ __('Textarea') }}</td>
                                <td style="border: none; width: 10px; text-align: left;">:</td>
                                <td style="border: none; text-align: left;">{{ $record->textarea }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <hr>
            <br>
            <div style="page-break-inside: avoid; width: 100%;">
                <div  style="text-align:left;">Detail</div>
                <table class="table-data" border="1" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">No</th>
                            <th class="text-center" style="width: 150px;">Example</th>
                            <th class="text-center" style="width: 150px;">User</th>
                            <th class="text-center">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($record->details as $detail)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left" style="width: 150px;">
                                    {{ $detail->example->name }}
                                </td>
                                <td class="text-left" style="width: 150px;">
                                    {{ $detail->user->name }}
                                </td>
                                <td class="text-left">
                                    <div style="white-space: pre-wrap;">{!! $detail->description !!}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">Data tidak tersedia!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>