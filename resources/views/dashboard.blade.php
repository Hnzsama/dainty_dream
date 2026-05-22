@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="summary-cards">
    <div class="summary-card">
        <div class="card-body">
            <div class="card-icon-wrapper blue">
                <img src="{{ asset('CardStock.png') }}" alt="Total Items">
            </div>
            <div class="card-content">
                <div class="card-label">TOTAL ITEMS</div>
                <div class="card-value">{{ $totalProducts ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-body">
            <div class="card-icon-wrapper purple">
                <img src="{{ asset('CardStockIn.png') }}" alt="Stock In">
            </div>
            <div class="card-content">
                <div class="card-label">STOCK IN</div>
                <div class="card-value">{{ $totalStockIn ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-body">
            <div class="card-icon-wrapper pink">
                <img src="{{ asset('CardStockOut.png') }}" alt="Stock Out">
            </div>
            <div class="card-content">
                <div class="card-label">STOCK OUT</div>
                <div class="card-value">{{ $totalStockOut ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="summary-card">
        <div class="card-body">
            <div class="card-icon-wrapper cyan">
                <img src="{{ asset('CardStockValue.png') }}" alt="Stock Value">
            </div>
            <div class="card-content">
                <div class="card-label">STOCK VALUE</div>
                <div class="card-value">${{ number_format($totalStock ?? 0, 0) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="chart-container">
    <div class="chart-title">Monthly Overview</div>
    <canvas id="transactionChart" style="max-height: 300px;"></canvas>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-title">Recent Informations</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $tx)
                <tr>
                    <td>
                        @if($tx->type === 'Incoming')
                            <strong style="padding: 4px 8px; border-radius: 4px; background-color: rgba(180, 231, 255, 0.3); color: #0369a1;">{{ $tx->type }}</strong>
                        @else
                            <strong style="padding: 4px 8px; border-radius: 4px; background-color: rgba(212, 186, 255, 0.3); color: #6d28d9;">{{ $tx->type }}</strong>
                        @endif
                    </td>
                    <td>{{ $tx->product_name ?? 'N/A' }}</td>
                    <td>{{ $tx->quantity ?? 0 }} units</td>
                    <td>${{ number_format($tx->price ?? 0, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                        No transactions yet. Start by creating a transaction!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@php
    $incomingDataArray = [];
    $outgoingDataArray = [];
    for ($i = 1; $i <= 12; $i++) {
        $incomingDataArray[] = $monthlyData[$i]['incoming'] ?? 0;
        $outgoingDataArray[] = $monthlyData[$i]['outgoing'] ?? 0;
    }
@endphp

<script>
    const incomingData = {{ json_encode($incomingDataArray) }};
    const outgoingData = {{ json_encode($outgoingDataArray) }};
    
    const ctx = document.getElementById('transactionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Incoming',
                        data: incomingData,
                        backgroundColor: 'rgba(180, 231, 255, 0.2)',
                        borderColor: 'rgba(180, 231, 255, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    },
                    {
                        label: 'Outgoing',
                        data: outgoingData,
                        backgroundColor: 'rgba(212, 186, 255, 0.2)',
                        borderColor: 'rgba(212, 186, 255, 1)',
                        borderWidth: 2,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: '600'
                            },
                            color: '#7C6BA8'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            color: '#E8D7FF'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
