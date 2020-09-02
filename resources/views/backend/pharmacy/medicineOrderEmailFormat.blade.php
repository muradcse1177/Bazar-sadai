<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<p>
    Dear, {{$companyName}}
</p>
<p>
    Greetings from <a href="bazar-sadai.com">Bazar-sadai.com.</a> Hope you are well!!
</p>
<h4> Name: {{$user_name}}</h4>
<p> Phone: {{$user_phone}}</p>
<p> Pharmacy Name: {{$pharmacy}}</p>
<p> Pharmacy Address: {{$address}}</p>
<table>
    <tr>
        <th>Medicine Name</th>
        <th>Type</th>
        <th>Generic Name</th>
        <th>Unit</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php
    use Illuminate\Support\Facades\DB;
    for($i=0; $i<count($medicines); $i++){
    $medicine = DB::table('products')
        ->select('*')
        ->where('id',  $medicines[$i])
        ->first();
    ?>
    <tr>
        <td>{{$medicine->name}}</td>
        <td>{{$medicine->type}}</td>
        <td>{{$medicine->genre}}</td>
        <td>{{$medicine->unit}}</td>
        <td>{{$quantity[$i]}}</td>
        <td>{{$price[$i]}}</td>
    </tr>
    <?php
    }
    ?>
</table>
<p>Best Regards, </p>
<p>Bazar-sadai.com </p>
</body>
</html>
