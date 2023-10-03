<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 2.5em;
            max-height: 100vh;
        }

        /*  HEADER  */
        .invoice-header {
            width: 100%;
            height: 230px;
        }
        .invoice-header .invoice-header__section1, .invoice-header__section2{
            height: 230px;
            width: 50%;
        }

        .invoice-header .invoice-header__section1{
            float:left;
        }
        .invoice-header .invoice-header__section2{
            float:right;
        }

        /* SECTION1 */
        .invoice-header .invoice-header__section1 .hotel-logo {
            width: 150px;
            height: 130px;
        }

        .invoice-header .invoice-header__section1 .hotel-logo > img{
            width: 100%;
            height: 100%;
        }

        .invoice-header .invoice-header__section1 .hotel-description{
            margin-top: 15px;
        }

        /*SECTION 2*/
        .invoice-header .invoice-header__section2 .content{
            width: 300px;
            box-sizing: border-box;
        }
        .invoice-header .invoice-header__section2 .content .title{
            font-size: 35px;
            letter-spacing: 4px;
            margin-bottom: 10px;
        }
        .invoice-header .invoice-header__section2 .content .invoce-details table{
            width: 100%;
        }

        .invoice-header .invoice-header__section2 .content .invoice-total{
            margin-top: 30px;
        }

        .invoice-header .invoice-header__section2 .content .invoice-total .text{
            margin-bottom: 5px;
        }


        /* CONTENT */
        .invoice-content{
            margin:50px 0 10px 0;
            max-width: 100%;
        }

        .invoice-content .invoice-content--table{
            border-spacing: 0;
            border-collapse: collapse;
            border: 0;
            width: 100%;
        }

        .invoice-content .invoice-content--table .invoice-content--thead, .invoice-content--tbody{
            border-bottom: solid 3px black;
        }

        .invoice-content .invoice-content--table .invoice-content--tr .invoice-content--td{
            padding: 0.5em;
        }

        /*FOOTER*/
        .invoice-footer {
            width: 100%;
            height: 300px;
        }
        .invoice-footer .invoice-footer--about{
            width: 60%;
        }
        .invoice-footer .invoice-footer--total{
            width: 40%;
        }
        .invoice-footer .invoice-footer--about{
            padding-top: 100px;
            float: left;
        }
        .invoice-footer .invoice-footer--about .section-1{
            margin-bottom: 2em;
        }
        .invoice-footer .invoice-footer--total{
            float: right;
        }
        .invoice-footer .invoice-footer--total .table-total {
            margin-bottom: 60px;
        }
        .invoice-footer .invoice-footer--total .table-total .invoice-footer--table{
            width: 100%;
        }
        .invoice-footer .invoice-footer--total .table-total .invoice-footer--td{
            padding: 0.2em;
        }
        .invoice-footer .invoice-footer--total .firm {
            width: 100%;
            height: 150px;
        }
        .invoice-footer .invoice-footer--total .firm > img{
            width: 100%;
            height: 100%;
        }

        .border-r{
            border-right: 2px solid #000;
        }
        .border-b{
            border-bottom: solid 3px black;
        }
        .font-size-1 {
            font-size: 1em;
        }
        .font-weight-1 {
            font-weight: lighter;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .text-uppercase{
            text-transform: uppercase;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            <div class="invoice-header__section1">
                <div class="hotel-logo" {{-- style="background-image: url('{{ asset('without-image.png') }}'" --}}>
                    {{-- <img src="{{public_path('without-image.png') }}" alt="logo"> --}}
                    <img src="{{asset('without-image.png') }}" alt="logo">
                </div>
                <div class="hotel-description">
                    <h5 class="text-uppercase" style="padding-bottom: 10px">COBRAR A:</h5>
                    <h5 class=" text-uppercase">{{$data->name_guest.' '. $data->last_name}}</h5>
                    <h4 class="font-weight-1">{{$data->origin}}</h4>
                    <h4 class="font-weight-1">{{$data->phone_guest}}</h4>
                </div>
            </div>
            <div class="invoice-header__section2">
                <div class="content">
                    <h1 class="title text-uppercase">{{$hotel->name}}</h1>
                    <div class="invoce-details">
                        <table>
                            <tbody>
                            <tr>
                                <td><b>N° de Factura:</b></td>
                                <td>#34856</td>
                            </tr>
                            <tr>
                                <td><b>Fecha Entrada:</b></td>
                                <td>{{ Carbon\Carbon::parse($data->entry_date)->toFormattedDateString()}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha Salida:</b></td>
                                <td>{{ Carbon\Carbon::parse($data->departure_date)->toFormattedDateString()}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="invoice-total">
                        <h3 class="text">Total a pagar:</h3>
                        <h3 class="total">S/ {{$total}}</h3>
                    </div>
                </div>
            </div>
        </div>
            <?php
                $dateOfIssue = Carbon\Carbon::parse($data->entry_date);
                 $dateOfExpiry = Carbon\Carbon::parse($data->departure_date);
                 $days = $dateOfExpiry->diffInDays($dateOfIssue);
            ?>
            <div class="invoice-content">
                <table class="invoice-content--table">
                    <thead class="invoice-content--thead">
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td text-uppercase"><b>descripción</b></td>
                            <td class="invoice-content--td text-center text-uppercase"><b>Precio</b></td>
                            <td class="invoice-content--td text-center text-uppercase"><b>Dias</b></td>
                            <td class="invoice-content--td text-right text-uppercase"><b>Total</b></td>
                        </tr>
                    </thead>
                    <tbody class="invoice-content--tbody">
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td border-r">
                                <h5 class="text-uppercase">{{$data->name_category}}</h5>
                                <small>{{$data->details}}</small>
                                {{--<ul>
                                    <?php $details = explode(",", $data->details)?>
                                    @foreach($details as $detail)
                                    <li>{{$detail}}</li>
                                    @endforeach
                                </ul>--}}

                            </td>
                            <td class="invoice-content--td text-center border-r">{{$data->price}}</td>
                            <td class="invoice-content--td text-center border-r">{{$days}}</td>
                            <td class="invoice-content--td text-right">{{$total}}</td>
                        </tr>
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td border-r">Habitacion Matrimonial</td>
                            <td class="invoice-content--td text-center border-r">$750.00</td>
                            <td class="invoice-content--td text-center border-r">2</td>
                            <td class="invoice-content--td text-right">$150.00</td>
                        </tr>
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td border-r">Habitacion Matrimonial</td>
                            <td class="invoice-content--td text-center border-r">$750.00</td>
                            <td class="invoice-content--td text-center border-r">2</td>
                            <td class="invoice-content--td text-right">$150.00</td>
                        </tr>
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td border-r">Habitacion Matrimonial</td>
                            <td class="invoice-content--td text-center border-r">$750.00</td>
                            <td class="invoice-content--td text-center border-r">2</td>
                            <td class="invoice-content--td text-right">$150.00</td>
                        </tr>
                        <tr class="invoice-content--tr">
                            <td class="invoice-content--td border-r"></td>
                            <td class="invoice-content--td border-r"></td>
                            <td class="invoice-content--td border-r"></td>
                            <td class="invoice-content--td"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice-footer">
                <div class="invoice-footer--about">
                    <div class="section-1">
                        <h3>Payment Method</h3>
                        <p>Lorem ipsum dolor sit amet</p>
                        <p>Lorem ipsum dolor sit amet</p>
                        <p>Lorem ipsum dolor sit amet</p>
                    </div>
                    <div class="section-2">
                        <h3>Contact</h3>
                        <p>{{$hotel->location}}</p>
                        <p>{{$hotel->phone}}</p>
                        <p>{{$hotel->email}}</p>
                    </div>
                </div>
                <div class="invoice-footer--total">
                    <div class="table-total">
                        <table class="invoice-footer--table">
                            <thead>
                                <tr class="invoice-footer--tr">
                                    <td class="text-uppercase"><b>sub total</b></td>
                                    <td class="text-right"><b>S/. {{$total}}</b></td>
                                </tr>
                            </thead>
                            <tbody class="border-b">
                                <tr class="invoice-footer--tr">
                                    <td class="invoice-footer--td">IGV 0.18%</td>
                                    <td class="text-right invoice-footer--td">0.00</td>
                                </tr>
                                <tr class="invoice-footer--tr">
                                    <td class="invoice-footer--td">Discount 10%</td>
                                    <td class="text-right invoice-footer--td">0.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="invoice-footer--tr">
                                    <td class="invoice-footer--td"><b>Grand total</b></td>
                                    <td class="text-right invoice-footer--td"><b>S/. {{$total}}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="firm">
                        <img src="{{asset('firm.jpg') }}" alt="logo">
                    </div>
                </div>
            </div>

        </div>
        <p style="padding-top: 100px; text-align: center; font-size: 12px; letter-spacing: 5px;" class="text-uppercase">
            Gracias por su preferencia
        </p>
    </div>
</body>
</html>
