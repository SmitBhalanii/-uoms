<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #ffc107;
            color: #333;
        }
        .products-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }
        .products-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .total-row {
            background: #f0f0f0;
            font-weight: bold;
        }
        .action-button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            font-size: 12px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 New Order Received!</h1>
        <p>University Ordering Management System (UOMS)</p>
    </div>
    
    <div class="content">
        <p>Dear Admin,</p>
        <p>A new order has been placed in the system and requires your review.</p>
        
        <div class="info-box">
            <h3 style="margin-top: 0; color: #667eea;">📋 Order Information</h3>
            <div class="info-row">
                <span class="info-label">Order Number:</span>
                <span class="info-value"><strong>{{ $order->order_number }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Order Date:</span>
                <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value"><span class="status-badge status-pending">{{ strtoupper($order->status) }}</span></span>
            </div>
        </div>
        
        <div class="info-box">
            <h3 style="margin-top: 0; color: #667eea;">👤 Customer Information</h3>
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $order->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $order->user->email }}</span>
            </div>
            @if($order->user->department)
            <div class="info-row">
                <span class="info-label">Department:</span>
                <span class="info-value">{{ $order->user->department }}</span>
            </div>
            @endif
            @if($order->user->college_name)
            <div class="info-row">
                <span class="info-label">College:</span>
                <span class="info-value">{{ $order->user->college_name }}</span>
            </div>
            @endif
        </div>
        
        <h3 style="color: #667eea;">📦 Order Details</h3>
        <table class="products-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th style="text-align: center;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->product_name }}</strong>
                        @if($item->product->brand)
                            <br><small style="color: #666;">{{ $item->product->brand->brand_name }}</small>
                        @endif
                    </td>
                    <td><code>{{ $item->product->sku }}</code></td>
                    <td style="text-align: center;"><strong>{{ $item->quantity }} pcs</strong></td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total Items:</td>
                    <td style="text-align: center;">{{ $order->total_items }} pcs</td>
                </tr>
            </tbody>
        </table>
        
        @if($order->remarks)
        <div class="info-box" style="margin-top: 20px;">
            <h4 style="margin-top: 0; color: #667eea;">💬 Customer Remarks:</h4>
            <p style="margin: 0; font-style: italic;">{{ $order->remarks }}</p>
        </div>
        @endif
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('admin.orders.show', $order) }}" class="action-button">
                View Order Details →
            </a>
        </div>
        
        <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px;">
            <strong>Next Steps:</strong><br>
            1. Review the order details<br>
            2. Check product availability<br>
            3. Approve or reject the order<br>
            4. Customer will be notified via email
        </p>
    </div>
    
    <div class="footer">
        <p><strong>University Ordering Management System (UOMS)</strong></p>
        <p>This is an automated notification. Please do not reply to this email.</p>
        <p><a href="{{ route('admin.dashboard') }}">Go to Admin Dashboard</a></p>
    </div>
</body>
</html>
