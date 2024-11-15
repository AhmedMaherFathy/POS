<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Table PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .pdf-container {
            width: 100%;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 14px;
        }

        .table th, .table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <h1>Product Details</h1>
        {{dd($data);}}
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Production Date</th>
                    <th>Expiration Date</th>
                    <th>Selling Price</th>
                    <th>Buying Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example rows; Replace these with dynamic data if necessary -->
                <tr>
                    <td>{{$data->name}}</td>
                    <td>{{$data->production_date}}</td>
                    <td>{{$data->expiration_date}}</td>
                    <td>{{$data->selling_price}}</td>
                    <td>{{$data->buying_price}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->discount}}</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</body>
</html>
