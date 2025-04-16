<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} | {{$settings['site_name']->value??config('app.name')}}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            padding: 20px;
            border: 2px solid #000;
            background: #fff;
            page-break-inside: avoid;
            overflow: hidden;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header img {
            max-width: 100px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 22px;
        }
        .section {
            padding: 5px 0;
            border-bottom: 2px dashed #000;
            font-size: 16px;
            display: flex;
            flex-wrap: wrap;
            page-break-inside: avoid;
        }
        .col-6 {
            width: 50%;
            padding: 5px;
            box-sizing: border-box;
        }
        .col-12 {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 100%;
                border: none;
            }
            .section, .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img width="100px" src="{{ $settings['site_logo']->getProcessedValue()??'' }}" alt="{{$settings['site_name']->value??config('app.name')}}">
            <h2>{{$settings['site_name']->value??config('app.name')}}</h2>
            <p style="font-size: 18px;">{{$title}}</p>
        </div>

        <div class="section row">
            <h3 style="width: 100%;">{{__('Car Task')}}</h3>
            <div class="col-6"><strong>{{__('Car Type')}}:</strong> {{ $data->car_contract->car_type }} - {{ $data->car_contract->car_supplier->name }}</div>
            <div class="col-6"><strong>{{__('Date')}}:</strong> {{ $data->date }}</div>
        </div>

        <div class="section">
            <h3 style="width: 100%;">{{__('Task Details')}}</h3>
            <table>
                <thead>
                    <tr>
                        <th>{{__('Time')}}</th>
                        <th>{{__('From')}}</th>
                        <th>{{__('To')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->carTaskDetails as $detail)
                    <tr>
                        <td>{{ $detail->time }}</td>
                        <td>{{ $detail->from }}</td>
                        <td>{{ $detail->to }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($data->notes)
        <div class="section">
            <h3 style="width: 100%;">{{__('Notes')}}</h3>
            <div class="col-12">{{ $data->notes }}</div>
        </div>
        @endif

        <div class="footer">
            <div class="float-left">{{__('Print DateTime') .': '. date('Y-m-d H:i:s')}}</div>
            <div class="float-right">{{__('Print by') .': '. $username}}</div>
        </div>
    </div>

</body>
</html>