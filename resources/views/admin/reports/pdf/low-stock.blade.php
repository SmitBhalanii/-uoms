<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Low Stock Products Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #f39c12;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #f39c12;
            margin: 0;
            font-size: 24px;
        }
        .header .company-name {
            color: #2c3e50;
            font-size: 18px;
            margin: 5px 0;
            font-weight: bold;
        }
        .header .report-info {
            color: #666;
            margin-top: 10px;
            font-size: 11px;
        }
        .summary-boxes {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border: 2px solid #ddd;
            background: #f9f9f9;
        }
        .summary-box .label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }
        .summary-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #f39c12;
            margin-top: 5px;
        }
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #f39c12;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-warning strong {
            color: #f39c12;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #f39c12;
            color: white;
            padding: 10px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }
        td {
            padding: 8px 5px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr.critical {
            background-color: #fee;
        }
        tr.out-of-stock {
            background-color: #fdd;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 50px;
            color: #28a745;
        }
        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">Divine Infoservice</div>
        <h1>Low Stock Products Report</h1>
        <div class="report-info">
            Generated on: {{ date('d M Y, h:i A') }}
        </div>
    </div>

    @if($lowStockProducts->count() > 0)
        <!-- Summary Statistics -->
        <div class="summary-boxes">
            <div class="summary-box">
                <div class="label">Total Low Stock</div>
                <div class="value">{{ $lowStockProducts->count() }}</div>
            </div>
            <div class="summary-box">
                <div class="label">Out of Stock</div>
                <div class="value">{{ $lowStockProducts->where('stock_quantity', 0)->count() }}</div>
            </div>
            <div class="summary-box">
                <div class="label">Critical (≤5)</div>
                <div class="value">{{ $lowStockProducts->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count() }}</div>
            </div>
        </div>

        <!-- Warning Alert -->
        <div class="alert-warning">
            <strong>⚠ Warning!</strong> The following products have stock quantity of 10 pieces or less. Please reorder soon.
        </div>

        <!-- Products Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Sr</th>
                    <th style="width: 15%;">SKU</th>
                    <th style="width: 25%;">Product Name</th>
                    <th style="width: 15%;">Brand</th>
                    <th style="width: 15%;">Category</th>
                    <th style="width: 15%;">Stock Qty</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $index => $product)
                    <tr class="{{ $product->stock_quantity == 0 ? 'out-of-stock' : ($product->stock_quantity <= 5 ? 'critical' : '') }}">
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $product->sku }}</strong></td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->brand->brand_name ?? 'N/A' }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>
                            @if($product->stock_quantity == 0)
                                <span class="badge badge-danger">OUT OF STOCK</span>
                            @elseif($product->stock_quantity <= 5)
                                <span class="badge badge-danger">{{ $product->stock_quantity }} (CRITICAL)</span>
                            @else
                                <span class="badge badge-warning">{{ $product->stock_quantity }} (LOW)</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <div style="font-size: 48px; color: #28a745; margin-bottom: 15px;">✓</div>
            <h3 style="color: #28a745;">Excellent Stock Management!</h3>
            <p>All products are well stocked. No products have stock quantity of 10 pieces or less.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Divine Infoservice - University Ordering Management System (UOMS)</p>
        <p>Report Generated: {{ date('d M Y, h:i A') }}</p>
    </div>
</body>
</html>
