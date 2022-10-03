<table>
    <thead>
        <tr>
            <th style="text-align: center; vertical-align: center; font-weight: bold; background-color: #B5B5C3;">
                {{ strtoupper('No') }}
            </th>
            <th style="text-align: center; vertical-align: center; font-weight: bold; background-color: #B5B5C3; width: 10cm;">
                {{ strtoupper(__('Cabang Pembantu')) }}
            </th>
            <th style="text-align: center; vertical-align: center; font-weight: bold; background-color: #B5B5C3; width: 10cm; height: 1.5cm;">
                {{ strtoupper('Parent') }}
                <br>
                (<a href="{{ route('setting.org.branch.index') }}">Lihat Master {{ __('Cabang') }}</a>)
            </th>
            <th style="text-align: center; vertical-align: center; font-weight: bold; background-color: #B5B5C3; width: 10cm;">
                {{ strtoupper(__('Telepon')) }}
            </th>
            <th style="text-align: center; vertical-align: center; font-weight: bold; background-color: #B5B5C3; width: 10cm;">
                {{ strtoupper(__('Alamat')) }}
            </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>