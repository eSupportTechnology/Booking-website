<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; }
        table { width:100%; border-collapse:collapse; }
        th,td { border:1px solid #ddd; padding:8px; }
        th { background:#f3f4f6; }
    </style>
</head>
<body>

<h2>Earnings Invoice</h2>
<p><strong>Partner:</strong> {{ $renter->company_name }}</p>
<p><strong>Date:</strong> {{ now()->format('M d, Y') }}</p>

<table>
<tr><th>Description</th><th>Amount ($)</th></tr>
<tr><td>Car Earnings</td><td>{{ number_format($carEarnings,2) }}</td></tr>
<tr><td>Taxi Earnings</td><td>{{ number_format($taxiEarnings,2) }}</td></tr>
<tr><td><strong>Gross Earnings</strong></td><td>{{ number_format($grossEarnings,2) }}</td></tr>
<tr><td>Car Commission ({{ $carCommissionRate }}%)</td><td>-{{ number_format($carCommission,2) }}</td></tr>
<tr><td>Taxi Commission ({{ $taxiCommissionRate }}%)</td><td>-{{ number_format($taxiCommission,2) }}</td></tr>
<tr>
    <td><strong>Net Payable</strong></td>
    <td><strong>{{ number_format($netEarnings,2) }}</strong></td>
</tr>
</table>

</body>
</html>
