@extends('layouts.app')

@section('page-title', 'Monthly Report')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 20px; background: white; border-radius: 16px; min-height: calc(100vh - 120px);">
    <!-- Summary Cards -->
    @php
        $netMovement = $incomingTotal - $outgoingTotal;
        $isPositive = $netMovement > 0;
    @endphp
    
    <div style="display: flex; justify-content: flex-end; margin-bottom: 40px;">
        <button onclick="exportToExcel()" 
                style="padding: 12px 24px; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 16px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export to Excel
        </button>
    </div>

    <!-- Incoming Transactions Section -->
    <div style="margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 3px solid #E8D7FF;">
            <img src="{{ asset('StockInAdd.png') }}" alt="Incoming" width="24" height="24" style="object-fit: contain;">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #7C6BA8;">Incoming Transactions</h2>
            <span style="margin-left: auto; background: rgba(109, 40, 217, 0.15); color: #6d28d9; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                {{ $incomingTransactions->count() }} items
            </span>
        </div>
        
        @if($incomingTransactions->count() > 0)
            <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #E8D7FF; box-shadow: 0 4px 12px rgba(124, 107, 168, 0.08);">
                <table style="width: 100%; border-collapse: collapse; background: white;">
                    <thead>
                        <tr style="background: linear-gradient(to right, #F5E6FF 0%, #F0E8FF 100%); border-bottom: 2px solid #E8D7FF;">
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Supplier</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Product</th>
                            <th style="padding: 16px; text-align: center; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Quantity</th>
                            <th style="padding: 16px; text-align: right; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Unit Price</th>
                            <th style="padding: 16px; text-align: right; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomingTransactions as $transaction)
                            <tr style="border-bottom: 1px solid #F0E8FF; transition: all 0.2s ease; background: white;">
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px;">{{ $transaction->supplier->name ?? 'N/A' }}</td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; font-weight: 500;">{{ $transaction->product->name ?? 'N/A' }}</td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; text-align: center;">
                                    <span style="background: rgba(180, 231, 255, 0.2); padding: 4px 10px; border-radius: 6px; color: #6d28d9; font-weight: 600;">
                                        {{ $transaction->quantity }} units
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; text-align: right;">${{ number_format($transaction->price, 2) }}</td>
                                <td style="padding: 14px 16px; color: #0369a1; font-size: 14px; font-weight: 600; text-align: right;">${{ number_format($transaction->quantity * $transaction->price, 2) }}</td>
                                <td style="padding: 14px 16px; color: #64748b; font-size: 14px;">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: linear-gradient(135deg, rgba(245, 230, 255, 0.5) 0%, rgba(232, 215, 255, 0.3) 100%); border-radius: 10px; border: 2px dashed #E8D7FF;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9F8FBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto; display: block;">
                    <path d="M20 17v2H4v-2"/>
                    <rect x="2" y="5" width="20" height="8" rx="1"/>
                    <path d="M2 5v12a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5"/>
                </svg>
                <p style="margin: 12px 0 0 0; color: #9F8FBF; font-size: 16px; font-weight: 500;">No incoming transactions for {{ $currentMonth->format('F Y') }}</p>
            </div>
        @endif
    </div>

    <!-- Outgoing Transactions Section -->
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 3px solid #E8D7FF;">
            <img src="{{ asset('StockOutAdd.png') }}" alt="Outgoing" width="24" height="24" style="object-fit: contain;">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #7C6BA8;">Outgoing Transactions</h2>
            <span style="margin-left: auto; background: rgba(212, 186, 255, 0.2); color: #6d28d9; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                {{ $outgoingTransactions->count() }} items
            </span>
        </div>
        
        @if($outgoingTransactions->count() > 0)
            <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #E8D7FF; box-shadow: 0 4px 12px rgba(124, 107, 168, 0.08);">
                <table style="width: 100%; border-collapse: collapse; background: white;">
                    <thead>
                        <tr style="background: linear-gradient(to right, #F5E6FF 0%, #F0E8FF 100%); border-bottom: 2px solid #E8D7FF;">
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Customer</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Product</th>
                            <th style="padding: 16px; text-align: center; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Quantity</th>
                            <th style="padding: 16px; text-align: right; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Unit Price</th>
                            <th style="padding: 16px; text-align: right; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600; color: #7C6BA8; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($outgoingTransactions as $transaction)
                            <tr style="border-bottom: 1px solid #F0E8FF; transition: all 0.2s ease; background: white;">
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px;">{{ $transaction->customer->name ?? 'N/A' }}</td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; font-weight: 500;">{{ $transaction->product->name ?? 'N/A' }}</td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; text-align: center;">
                                    <span style="background: rgba(212, 186, 255, 0.2); padding: 4px 10px; border-radius: 6px; color: #6d28d9; font-weight: 600;">
                                        {{ $transaction->quantity }} units
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; color: #374151; font-size: 14px; text-align: right;">${{ number_format($transaction->price, 2) }}</td>
                                <td style="padding: 14px 16px; color: #6d28d9; font-size: 14px; font-weight: 600; text-align: right;">${{ number_format($transaction->quantity * $transaction->price, 2) }}</td>
                                <td style="padding: 14px 16px; color: #64748b; font-size: 14px;">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: linear-gradient(135deg, rgba(245, 230, 255, 0.5) 0%, rgba(232, 215, 255, 0.3) 100%); border-radius: 10px; border: 2px dashed #E8D7FF;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9F8FBF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto; display: block;">
                    <path d="M20 17v2H4v-2"/>
                    <rect x="2" y="5" width="20" height="8" rx="1"/>
                    <path d="M2 5v12a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5"/>
                </svg>
                <p style="margin: 12px 0 0 0; color: #9F8FBF; font-size: 16px; font-weight: 500;">No outgoing transactions for {{ $currentMonth->format('F Y') }}</p>
            </div>
        @endif
    </div>
</div>

<style>
    @media print {
        button, a {
            display: none;
        }
        
        body {
            background: white;
        }
    }
    
    @media (max-width: 768px) {
        h1 {
            font-size: 24px !important;
        }
        
        h2 {
            font-size: 18px !important;
        }
        
        table {
            font-size: 12px !important;
        }
        
        td, th {
            padding: 10px 8px !important;
        }
    }
</style>

@php
    $incomingData = [
        ['Incoming Transactions', $currentMonth->format("F Y")],
        ['Supplier', 'Product', 'Quantity', 'Unit Price', 'Total', 'Date']
    ];
    foreach($incomingTransactions as $transaction) {
        $incomingData[] = [
            $transaction->supplier->name ?? 'N/A',
            $transaction->product->name ?? 'N/A',
            $transaction->quantity,
            $transaction->price,
            $transaction->quantity * $transaction->price,
            \Carbon\Carbon::parse($transaction->transaction_date)->format("M d, Y")
        ];
    }
    
    $outgoingData = [
        ['Outgoing Transactions', $currentMonth->format("F Y")],
        ['Customer', 'Product', 'Quantity', 'Unit Price', 'Total', 'Date']
    ];
    foreach($outgoingTransactions as $transaction) {
        $outgoingData[] = [
            $transaction->customer->name ?? 'N/A',
            $transaction->product->name ?? 'N/A',
            $transaction->quantity,
            $transaction->price,
            $transaction->quantity * $transaction->price,
            \Carbon\Carbon::parse($transaction->transaction_date)->format("M d, Y")
        ];
    }
@endphp

<div id="reportData" 
     data-incoming="{{ json_encode($incomingData) }}"
     data-outgoing="{{ json_encode($outgoingData) }}"
     data-month="{{ $currentMonth->format('F Y') }}"
     data-incoming-count="{{ $incomingCount }}"
     data-incoming-total="{{ $incomingTotal }}"
     data-outgoing-count="{{ $outgoingCount }}"
     data-outgoing-total="{{ $outgoingTotal }}"
     data-net-movement="{{ $incomingTotal - $outgoingTotal }}"
     style="display: none;">
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
    function exportToExcel() {
        const reportData = document.getElementById('reportData');
        const month = reportData.dataset.month;
        const filename = 'Monthly_Report_' + month.replace(" ", "_") + '.xlsx';
        
        const incomingData = JSON.parse(reportData.dataset.incoming);
        const outgoingData = JSON.parse(reportData.dataset.outgoing);
        
        // Create a new workbook
        const wb = XLSX.utils.book_new();
        
        // Summary data
        const summaryData = [
            ['Monthly Report', month],
            [],
            ['Incoming Goods', reportData.dataset.incomingCount, '$' + reportData.dataset.incomingTotal],
            ['Outgoing Goods', reportData.dataset.outgoingCount, '$' + reportData.dataset.outgoingTotal],
            ['Net Movement', parseInt(reportData.dataset.incomingCount) - parseInt(reportData.dataset.outgoingCount), '$' + reportData.dataset.netMovement],
            []
        ];
        
        const summaryWs = XLSX.utils.aoa_to_sheet(summaryData);
        XLSX.utils.book_append_sheet(wb, summaryWs, "Summary");
        
        // Incoming transactions
        if (incomingData.length > 2) {
            const incomingWs = XLSX.utils.aoa_to_sheet(incomingData);
            XLSX.utils.book_append_sheet(wb, incomingWs, "Incoming");
        }
        
        // Outgoing transactions
        if (outgoingData.length > 2) {
            const outgoingWs = XLSX.utils.aoa_to_sheet(outgoingData);
            XLSX.utils.book_append_sheet(wb, outgoingWs, "Outgoing");
        }
        
        // Write the file
        XLSX.writeFile(wb, filename);
    }
</script>
@endsection
