<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thanks for pucrchasing</title>
</head>

<body>
    <div>
        Hello <b>{{ $customerDetails['customer_name'] }}</b>,
    </div>
    <div>
        <h2>Your Order Details</h2>

        <label>Plan Name: </label> {{ $customerDetails['package_name'] }} <br><br>

        <label>Price: </label> = <bdi>{{ $customerDetails['order_total'] }}</bdi><br><br>

        <label>Order Status:</label>: {{ $customerDetails['order_status'] }}<br><br>

        <label>Date:</label>: {{ $customerDetails['created_at'] }}<br><br>

    </div>

    <div>
        <p>Thanks for purchase, See you soon!!!</p>
    </div>

</body>

</html>
