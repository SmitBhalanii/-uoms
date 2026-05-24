<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Updated</title>
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
            background: #28a745;
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
        .status-update {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .status-update p {
            margin: 10px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .status-pending {
            background: #ffc107;
            color: #000;
        }
        .status-approved {
            background: #28a745;
            color: #fff;
        }
        .status-rejected {
            background: #dc3545;
            color: #fff;
        }
        .status-processing {
            background: #17a2b8;
            color: #fff;
        }
        .status-completed {
            background: #343a40;
            color: #fff;
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
            background: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .remarks-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Order Status Updated</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
            
            <p>Your order status has been updated by the admin.</p>
            
            <div class="status-update">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Previous Status:</strong> <span class="status-badge status-{{ $oldStatus }}">{{ ucfirst($oldStatus) }}</span></p>
                <p><strong>Current Status:</strong> <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></p>
                <p><strong>Updated On:</strong> {{ $order->updated_at->format('d M Y, h:i A') }}</p>
            </div>
            
            @if($order->remarks)
            <div class="remarks-box">
                <p><strong>Admin Remarks:</strong></p>
                <p>{{ $order->remarks }}</p>
            </div>
            @endif
            
            <div class="order-info">
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Total Items:</strong> {{ $order->total_items }}</p>
            </div>
            
            @if($order->status == 'approved')
            <p style="color: #28a745; font-weight: bold;">✓ Great news! Your order has been approved and will be processed soon.</p>
            @elseif($order->status == 'rejected')
            <p style="color: #dc3545; font-weight: bold;">✗ Unfortunately, your order has been rejected. Please check the admin remarks above.</p>
            @elseif($order->status == 'processing')
            <p style="color: #17a2b8; font-weight: bold;">⚙ Your order is currently being processed.</p>
            @elseif($order->status == 'completed')
            <p style="color: #28a745; font-weight: bold;">✓ Your order has been completed successfully!</p>
            @endif
            
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
