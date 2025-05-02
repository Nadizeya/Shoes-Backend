{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Invoice</title>--}}
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            text-align: left;--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--        }--}}
{{--        .invoice-container {--}}
{{--            width: 80%;--}}
{{--            margin: auto;--}}
{{--            padding: 20px;--}}
{{--            border: 1px solid #ddd;--}}
{{--            background: #fff;--}}
{{--        }--}}
{{--        .text-center {--}}
{{--            text-align: center;--}}
{{--        }--}}
{{--        h2 {--}}
{{--            color: #222;--}}
{{--            font-size: 24px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--        .invoice-header {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            padding-bottom: 10px;--}}
{{--        }--}}
{{--        .invoice-header div {--}}
{{--            width: 50%;--}}
{{--        }--}}
{{--        .invoice-header .right {--}}
{{--            text-align: right;--}}
{{--        }--}}
{{--        .invoice-table {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}
{{--        .invoice-table th, .invoice-table td {--}}
{{--            border: 1px solid #ddd;--}}
{{--            padding: 10px;--}}
{{--            text-align: left;--}}
{{--        }--}}
{{--        .invoice-table th {--}}
{{--            background: #f5f5f5;--}}
{{--        }--}}
{{--        .text-bold {--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="invoice-container">--}}
{{--    <h2 class="text-center">INVOICE</h2>--}}

{{--    <div class="invoice-header">--}}
{{--        <div>--}}
{{--            <p class="text-bold">Customer Name: {{ $invoiceData->name }}</p>--}}
{{--            <p>Order Code: <span class="text-bold">{{ $invoiceData->order_code }}</span></p>--}}
{{--            <p>Date: <span class="text-bold">{{ $invoiceData->date }}</span></p>--}}
{{--            <p>Status: <span class="text-bold">{{ ucfirst($invoiceData->status) }}</span></p>--}}
{{--            <p>Order Address: <span class="text-bold">{{ $invoiceData->address }}</span></p>--}}
{{--            <p>PhoneNumber: <span class="text-bold">{{ $invoiceData->phone }}</span></p>--}}




{{--        </div>--}}
{{--        <div class="right">--}}
{{--            <p>Your Name</p>--}}
{{--            <p>Your Address</p>--}}
{{--            <p>City</p>--}}
{{--            <p>Postcode</p>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <table class="invoice-table">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Product</th>--}}
{{--            <th>Size</th>--}}
{{--            <th>Quantity</th>--}}
{{--            <th>Price</th>--}}
{{--            <th>Subtotal</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach ($invoiceData->items as $item)--}}
{{--            <tr>--}}
{{--                <td>{{ $item->variation->product->name ?? 'N/A' }}</td>--}}
{{--                <td>{{ $item->variation->size ?? 'N/A' }}</td>--}}
{{--                <td>{{ $item->quantity }}</td>--}}
{{--                <td>{{ number_format($item->price, 2) }} MMK</td>--}}
{{--                <td class="text-bold">{{ number_format($item->quantity * $item->price, 2) }} MMK</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <p class="text-bold">Total Quantity: {{ $invoiceData->total_qty }}</p>--}}
{{--    <p class="text-bold">Total Amount: ${{ number_format($invoiceData->amount, 2) }}</p>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background: #f8f8f8;
        }
        .invoice-container {
            width: 60%;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 15px;
        }
        .header img {
            width: 80px; /* Adjust logo size */
            margin-bottom: 5px;
        }
        h2 {
            color: #222;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .invoice-details {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #eee;
        }
        .invoice-details p {
            font-size: 16px;
            margin: 5px 0;
        }
        .text-bold {
            font-weight: bold;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .invoice-table th {
            background: #f5f5f5;
            color: #333;
        }
        .total-section {
            text-align: right;
            margin-top: 15px;
        }
        .total-section p {
            font-size: 16px;
            margin: 5px 0;
        }
        .total-section .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #d9534f;
        }
        .thank-you {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #5cb85c;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <!-- Shop Logo -->
    <div class="header">
        <img src="{{ asset('vendors/images/logo/apple-touch-icon.png') }}" alt="Shop Logo"> <!-- Ensure the logo exists -->
        <h2>INVOICE</h2>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <p class="text-bold">Customer Name: {{ $invoiceData->name }}</p>
        <p>Order Code: <span class="text-bold">{{ $invoiceData->order_code }}</span></p>
        <p>Date: <span class="text-bold">{{ $invoiceData->date }}</span></p>
        <p>Status: <span class="text-bold">{{ ucfirst($invoiceData->status) }}</span></p>
        <p>Order Address: <span class="text-bold">{{ $invoiceData->address }}</span></p>
        <p>Phone Number: <span class="text-bold">{{ $invoiceData->phone }}</span></p>
    </div>

    <!-- Order Table -->
    <table class="invoice-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoiceData->items as $item)
            <tr>
                <td>{{ $item->variation->product->name ?? 'N/A' }}</td>
                <td>{{ $item->variation->size ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} MMK</td>
                <td class="text-bold">{{ number_format($item->quantity * $item->price, 2) }} MMK</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        <p class="text-bold">Total Quantity: {{ $invoiceData->total_qty }}</p>
        <p class="grand-total">Total Amount: {{ number_format($invoiceData->amount, 2) }} MMK</p>
    </div>

    <!-- Thank You Note -->
    <p class="thank-you">Thank you for shopping with us!</p>
</div>

</body>
</html>

{{--    <!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>NadiYonnHtike</title>--}}

{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, sans-serif;--}}
{{--            text-align: left;--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            background: #f8f8f8;--}}
{{--        }--}}
{{--        .invoice-container {--}}
{{--            width: 70%;--}}
{{--            margin: 20px auto;--}}
{{--            padding: 20px;--}}
{{--            background: #fff;--}}
{{--            border-radius: 8px;--}}
{{--            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);--}}
{{--        }--}}
{{--        .header {--}}
{{--            text-align: center;--}}
{{--            padding-bottom: 20px;--}}
{{--            border-bottom: 2px solid #eee;--}}
{{--        }--}}
{{--        .header img {--}}
{{--            width: 80px; /* Adjust logo size */--}}
{{--            margin-bottom: 10px;--}}
{{--        }--}}
{{--        h2 {--}}
{{--            color: #333;--}}
{{--            font-size: 26px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--        .invoice-header {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            padding-top: 20px;--}}
{{--        }--}}
{{--        .invoice-header div {--}}
{{--            width: 48%;--}}
{{--        }--}}
{{--        .invoice-header .right {--}}
{{--            text-align: right;--}}
{{--        }--}}
{{--        .text-bold {--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--        .invoice-table {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}
{{--        .invoice-table th, .invoice-table td {--}}
{{--            border: 1px solid #ddd;--}}
{{--            padding: 10px;--}}
{{--            text-align: left;--}}
{{--        }--}}
{{--        .invoice-table th {--}}
{{--            background: #f5f5f5;--}}
{{--            color: #333;--}}
{{--        }--}}
{{--        .total-section {--}}
{{--            text-align: right;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}
{{--        .total-section p {--}}
{{--            font-size: 16px;--}}
{{--            margin: 5px 0;--}}
{{--        }--}}
{{--        .total-section .grand-total {--}}
{{--            font-size: 20px;--}}
{{--            font-weight: bold;--}}
{{--            color: #d9534f;--}}
{{--        }--}}
{{--        .thank-you {--}}
{{--            text-align: center;--}}
{{--            margin-top: 30px;--}}
{{--            font-size: 18px;--}}
{{--            font-weight: bold;--}}
{{--            color: #5cb85c;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="invoice-container">--}}
{{--    <!-- Shop Logo -->--}}
{{--    <div class="header">--}}
{{--        <img src="file://{{ public_path('vendors/images/logo/apple-touch-icon.png') }}" alt="Logo" width="80px" height="80px">--}}
{{--        <h2>INVOICE</h2>--}}
{{--    </div>--}}

{{--    <!-- Invoice Details -->--}}
{{--    <div class="invoice-header">--}}
{{--        <div>--}}
{{--            <p class="text-bold">Customer Name: {{ $invoiceData->name }}</p>--}}
{{--            <p>Order Code: <span class="text-bold">{{ $invoiceData->order_code }}</span></p>--}}
{{--            <p>Date: <span class="text-bold">{{ $invoiceData->date }}</span></p>--}}
{{--            <p>Status: <span class="text-bold">{{ ucfirst($invoiceData->status) }}</span></p>--}}
{{--            <p>Order Address: <span class="text-bold">{{ $invoiceData->address }}</span></p>--}}
{{--            <p>Phone Number: <span class="text-bold">{{ $invoiceData->phone }}</span></p>--}}
{{--        </div>--}}
{{--        <div class="right">--}}
{{--            <p class="text-bold">Shop Details</p>--}}
{{--            <p>Your Shop Name</p>--}}
{{--            <p>Your Address</p>--}}
{{--            <p>Your City, Zip Code</p>--}}
{{--            <p>+123 456 7890</p>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Order Table -->--}}
{{--    <table class="invoice-table">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Product</th>--}}
{{--            <th>Size</th>--}}
{{--            <th>Quantity</th>--}}
{{--            <th>Price</th>--}}
{{--            <th>Subtotal</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach ($invoiceData->items as $item)--}}
{{--            <tr>--}}
{{--                <td>{{ $item->variation->product->name ?? 'N/A' }}</td>--}}
{{--                <td>{{ $item->variation->size ?? 'N/A' }}</td>--}}
{{--                <td>{{ $item->quantity }}</td>--}}
{{--                <td>{{ number_format($item->price, 2) }} MMK</td>--}}
{{--                <td class="text-bold">{{ number_format($item->quantity * $item->price, 2) }} MMK</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <!-- Total Section -->--}}
{{--    <div class="total-section">--}}
{{--        <p class="text-bold">Total Quantity: {{ $invoiceData->total_qty }}</p>--}}
{{--        <p class="grand-total">Total Amount: {{ number_format($invoiceData->amount, 2) }} MMK</p>--}}
{{--    </div>--}}

{{--    <!-- Thank You Note -->--}}
{{--    <p class="thank-you">Thank you for shopping with us!</p>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}
