<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1)?'rtl':'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} | {{$settings['site_name']->value??config('app.name')}}</title>
    <style>
        body {
            font-family: 'dejavusans';
            direction: rtl;
            text-align: right;
            font-size: 12px;
        }
        .header, .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header .company-name {
            font-size: 16px;
            font-weight: bold;
        }
        .header img {
            width: 80px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            font-size: 10px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <img width="100px" src="{{ url('seed_images/logo.png')}}" alt="{{$settings['site_name']->value??config('app.name')}}">
        </div>
        <div class="company-info">
            <h2>{{$settings['site_name']->value??config('app.name')}}</h2>
        </div>
    </div>
    
    <div class="title">{{$title}}</div>
    