<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order Details</title>
</head>

<body>
    <div>
        Hello <b>Admin</b>,
    </div>

    <div>
        <h2>New Order Details</h2>

        <label>Plan Name: </label> {{ $customerDetails['package_name'] }}<br><br>

        <label>Price: </label> = <bdi>{{ $customerDetails['order_total'] }}</bdi><br><br>

        <label>Order Status:</label>: {{ $customerDetails['order_status'] }}<br><br>

        <label>Date:</label>: {{ $customerDetails['created_at'] }}<br><br>
    </div>

    <div>
        <h2>Customer Details</h2>

        <label>Customer ID:</label> {{ $customerDetails['customer_id'] }}<br><br>

        <label>Customer Name:</label> {{ $customerDetails['customer_name'] }}<br><br>

        <label>Customer Email:</label> {{ $customerDetails['customer_email'] }}<br><br>

    </div>

</body>

</html>
