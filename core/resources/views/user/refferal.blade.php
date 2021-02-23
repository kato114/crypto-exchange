@extends('user')
@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title">
                <h1>{{$page_title}}</h1>
            </div>
        </div>
    </div>









    <div class="affilate-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">


                    <div class="tables">
                        <div class="title">
                            <h3>Referral Link</h3>
                        </div>
                        <div class="affiliate">
                            <form class="input-box">
                                <input type="text" id="myInput"
                                       value=" {{ route('refer.register',auth::user()->username) }}">
                                <button class="copy" type="button" onclick="myFunction()" title="Clipboard Copy"><i
                                        class="fas fa-copy"></i></button>
                            </form>
                        </div>
                    </div>


                    <div class="tables">
                        <div class="title">
                            <h3>Referral  Bonus</h3>
                        </div>
                        <div class="chart">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Bonus</th>
                                    <th scope="col">Remaining Balance</th>
                                    <th scope="col">Details </th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($trx) >0)
                                    @foreach($trx as $k=>$data)
                                <tr>
                                    <th data-label="Date"><i class="fas fa-calendar-alt"></i> {{ date('d M Y',strtotime($data->created_at))}}</th>
                                    <td data-label="Bonus">
                                        <i class="icofont-money"></i>
                                        <span class="strong">{{number_format($data->amount,$basic->decimal)}} </span>
                                        <span class="strong base-color">{{$basic->currency}}</span>
                                    </td>
                                    <td data-label="Remaining Balance">
                                        <i class="icofont-money"></i>
                                        <span class="strong">{{number_format($data->main_amo,$basic->decimal)}} </span>
                                        <span class="strong base-color">{{$basic->currency}}</span>
                                    </td>

                                    <td data-label="Details"> {{$data->title}}</td>
                                </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4"> No Data Found !!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="post-navigation">
                                <ul class="pagination">
                                    {{ $trx->links('partials.pagination') }}
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





@endsection
@section('js')
    <script>
        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();

            /* Copy the text inside the text field */
            document.execCommand("copy");

        }
    </script>
@endsection
