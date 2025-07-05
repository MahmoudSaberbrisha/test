<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1)?'rtl':'ltr' }}">
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
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            page-break-inside: avoid;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
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
            .section, .table, .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img width="100px" src="{{ url('seed_images/logo.png')}}" alt="{{$settings['site_name']->value??config('app.name')}}">
            <h2>{{$settings['site_name']->value??config('app.name')}}</h2>
            <p style="font-size: 18px;">{{$title}}</p>
        </div>

        <div class="section row">
            <h3 style="width: 100%;">{{__('Cruise Data')}}</h3>
            <div class="col-12"><strong>{{__('Serial No.')}}:</strong> {{ $data->booking_group_num }}</div>
            <div class="col-12"><strong>{{__('Booking Date Time')}}:</strong> {{ $data->booking->booking_date->format('Y-m-d') }} ( {{$data->booking->start_time->format('H:i A')}} )</div>
            <div class="col-12"><strong>{{__('Cruise Type')}}:</strong> {{__(BOOKING_TYPES[$data->booking->booking_type])}}</div>
            <div class="col-12"><strong>{{__('Boat Name')}}:</strong>{{$data->booking->sailing_boat->name}}</div>
        </div>

        <div class="section">
            <h3 style="width: 100%;">{{__('Client Data')}}</h3>
            <div class="col-12"><strong>{{__('Client Name')}}:</strong> {{ $data->client->name }}</div>
            <div class="col-12"><strong>{{__("Phone No.")}}:</strong> {{ $data->client->phone }}</div>
            <div class="col-12"><strong>{{__('Sales Representative')}}:</strong> {{$data->client_supplier->name}}</div>
        </div>

        <div class="section">
            <h3 style="width: 100%;">{{__('Members Details')}}</h3>
            <table class="table">
                <tr>
                    <th>{{__('Member Type')}}</th>
                    <th>{{__('Number')}}</th>
                    @if($data->booking->booking_type == 'group')
                    <th>{{__('Member Total')}}</th>
                    @endif
                </tr>
                @foreach ($data->booking_group_members as $member)
                    <tr>
                        <td>{{$member->client_type->name}}</td>
                        <td>{{$member->members_count}}</td>
                        @if($data->booking->booking_type == 'group')
                        <td>{{$data->currency_symbol}} {{$member->member_total_price}}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="section">
            <h3 style="width: 100%;">{{__('Payment Details')}}</h3>
            <div class="col-12"><strong>{{__('Total')}}:</strong> {{ $data->currency_symbol.' '.$data->price}} </div>
            <div class="col-12"><strong>{{__('Discounted')}}:</strong> {{ $data->currency_symbol.' '.$data->discounted }} </div>
            <div class="col-12"><strong>{{__('Total After Discount')}}:</strong> {{ $data->currency_symbol.' '.$data->total_after_discount }} </div>

            @if ($data->is_taxed)
                <div class="col-12"><strong>{{__("Tax 14%")}}:</strong> {{ $data->currency_symbol.' '.$data->tax }}</div>
            @endif
            <div class="col-12"><strong>{{__('Final Total')}}:</strong> {{ $data->currency_symbol.' '.$data->total }}</div>
        </div>

        <div class="section">
            <h3 style="width: 100%;">{{__('Payment Methods')}}</h3>
            @if($data->credit_sales == 0)
            <table class="table">
                <tr>
                    <th>{{__('Payment Method')}}</th>
                    <th>{{__('Amount Paid')}}</th>
                </tr>
                @foreach ($data->booking_group_payments as $payment)
                    <tr>
                        <td>{{$payment->payment_method->name}}</td>
                        <td>{{$data->currency_symbol}} {{$payment->paid}}</td>
                    </tr>
                @endforeach
            </table>
            @else
            <div class="col-6"><strong>{{__('Credit Sales')}}</strong></div>
            @endif
            <div class="col-6"><strong>{{__('Remain')}}:</strong> {{$data->currency_symbol}} {{$data->remain}}</div>
        </div>

        <div class="footer">
            @if($data->notes)
            <p><strong>{{__('Notes')}}:</strong> {{$data->notes}}</p>
            @endif
            <p>{{$data->out_marina?__('Out Marina'):''}}</p>
        </div>
        <div class="footer">
            
            <p> لا يسمح بشرب المشروبات الكحوليه </p>
            <p>ممنوع تبادل الادوار الالعاب</p>
            <p>المبلغ المدفوع لا يسترد</p>
            <P>لا يسمح بجلب مكبرات الصوت والسماعات الا بتصريح </p>
        </div>
        <div class="footer">
            <p>{{__('Thank you for choosing our services. We wish you a pleasant journey!')}}</p>
            <div class="float-left">{{__('Print DateTime') .': '. date('Y-m-d H:i:s')}}</div>
            <div class="float-right">{{__('Print by') .': '. $username}}</div>
        </div>
    </div>

</body>
</html>
