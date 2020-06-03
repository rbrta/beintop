<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width-device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="ie-edge">
    <title>Document</title>
</head>
<body>



<form name="payment" method="post" action="https://sci.interkassa.com/" accept-charset="UTF-8">
  <input type="hidden" name="ik_co_id" value="5ed3d7051ae1bd39008b457b"/>
  <input type="hidden" name="ik_pm_no" value="ID_4233"/>
  <input type="hidden" name="ik_am" value="1.44"/>
  <input type="hidden" name="ik_cur" value="RUB"/>
  <input type="hidden" name="ik_desc" value="Payment Description"/>

  <input type="hidden" name="ik_ia_u" value="{{ $callback }}"/>
  <input type="hidden" name="ik_suc_u" value="{{ $success }}"/>
  <input type="hidden" name="ik_fal_u" value="{{ $failure }}"/>
  <input type="hidden" name="ik_pnd_u" value="{{ $pending }}"/>

  <input type="submit" value="Pay">
</form>

</body>
</html>