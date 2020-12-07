<!DOCTYPE html>
<html>
<head>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body>
<p>
    Dear, {{$userName}}
</p>
<p>
    Greetings from <a href="bazar-sadai.com">Bazar-sadai.com.</a> Hope you are well!!
</p>
<h4> Your delivery person name: {{$dev_name}}</h4>
<h4> Your delivery person phone: {{$dev_phone}}</h4>
<h4> Your order transaction ID: {{$tx_id}}</h4>
<p>Please call your delivery person if needed.</p>
<h4> Your marketing list are following. Please check.</h4>
<table style="width:100%">
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    @foreach($data as  $products)
    <tr>
        <td>{{$products->name}}</td>
        <td>{{$products->quantity. $products->unit}}</td>
        <td>{{$products->edit_price}}</td>
    </tr>
    @endforeach
</table>

<p>Best Regards, </p>
<p>Bazar-sadai.com </p>
</body>
</html>
