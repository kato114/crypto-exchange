<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$gnl->sitename}}</title>
</head>

<body>
<form action="https://secure.paypal.com/cgi-bin/webscr" method="post" id="payment_form">
    <input type="hidden" name="cmd" value="_xclick"/>
    <input type="hidden" name="business" value="{{$paypal['sendto']}}"/>
    <input type="hidden" name="cbt" value="{{$gnl->sitename}}"/>
    <input type="hidden" name="currency_code" value="USD"/>
    <input type="hidden" name="quantity" value="1"/>
    <input type="hidden" name="item_name" value="Add Money To {{$gnl->sitename}} Account"/>
    <input type="hidden" name="custom" value="{{$paypal['track']}}"/>
    <input type="hidden" name="amount" value="{{$paypal['amount']}}"/>
    <input type="hidden" name="return" value="{{route('deposit')}}"/>
    <input type="hidden" name="cancel_return" value="{{route('deposit')}}"/>
    <input type="hidden" name="notify_url" value="{{route('ipn.paypal')}}"/>
</form>

<script>
    document.getElementById("payment_form").submit();
</script>
</body>

</html>

