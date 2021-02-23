<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$gnl->sitename}}</title>
</head>

<body>
<form action="{{ $form_action }}" method="post" id="payment_form">
    @foreach($post_params as $k=>$v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
</form>

<script>
    document.getElementById("payment_form").submit();
</script>
</body>

</html>