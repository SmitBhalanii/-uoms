<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #007bff;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .order-info p {
            margin: 10px 0;
        }
        .order-info strong {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background: #007bff;
            color: #ffffff;
            padding: 12px;
            text-align: left;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .status-pending {
            background: #ffc107;
            color: #000;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Order Placed Successfully</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
            
            <p>Thank you for placing your order with UOMS. Your order has been received and is being processed.</p>
            
            <div class="order-info">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                <p><strong>Total Items:</strong> {{ $order->total_items }}</p>
                <p><strong>Status:</strong> <span class="status-badge status-pending">{{ ucfirst($order->status) }}</span></p>
                @if($order->remarks)
                <p><strong>Your Remarks:</strong> {{ $order->remarks }}</p>
                @endif
            </div>
            
            <h3>Ordered Products:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->product->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }} {{ $item->product->unit->short_name ?? 'pcs' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <p>You will receive another email when your order status is updated by the admin.</p>
            
            <center>
                <a href="{{ route('user.orders.show', $order) }}" class="button">View Order Details</a>
            </center>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} UOMS - University Order Management System</p>
            <p>This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
