<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$basic->sitename}}</title>
</head>

<body>
    <form method="GET" action="{{$payeer_url }}" id="payment_form">
        <input type="hidden" name="m_shop" value="{{$m_shop }}">
        <input type="hidden" name="m_orderid" value="{{$m_orderid }}">
        <input type="hidden" name="m_amount" value="{{$m_amount }}">
        <input type="hidden" name="m_curr" value="{{$m_curr }}">
        <input type="hidden" name="m_desc" value="{{$m_desc }}">
        <input type="hidden" name="m_sign" value="{{$sign }}">
    </form>
    <script>
        document.getElementById("payment_form").submit();
    </script>
</body>

</html>