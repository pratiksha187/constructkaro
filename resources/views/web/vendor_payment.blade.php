@extends('layouts.vender.app')
@section('title', 'Vendor Dashboard | ConstructKaro')
@section('content')
<style>
    :root {
        --navy: #1c2c3e;
        --orange: #f25c05;
    }

    .card-stat {
        border-radius: 15px;
        color: #fff;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        min-height: 130px;
    }
    .card-green { background: #22c55e; }
    .card-yellow { background: #fbbf24; }
    .card-blue { background: #3b82f6; }

    .payment-table th {
        color: var(--navy);
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .status-badge {
        font-size: 0.8rem;
        border-radius: 20px;
        padding: 5px 12px;
    }
    .status-paid {
        background-color: #d1fae5;
        color: #065f46;
    }
    .status-processing {
        background-color: #fef3c7;
        color: #92400e;
    }
</style>

<div class="container mt-4">

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-stat card-green">
                <h5>Total Earnings</h5>
                <h2 class="fw-bold">₹00</h2>
                <p class="mb-0">Lifetime earnings</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat card-yellow">
                <h5>Pending Payments</h5>
                <h2 class="fw-bold">₹00</h2>
                <p class="mb-0">Awaiting processing</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat card-blue">
                <h5>Next Payout</h5>
                <h2 class="fw-bold"></h2>
                <p class="mb-0">₹00 expected</p>
            </div>
        </div>
    </div>

    {{-- Payment Transactions --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Payment Transactions</h5>

            <div class="table-responsive">
                <table class="table align-middle payment-table">
                    <thead class="table-light">
                        <tr>
                            <th>Project ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Commission</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>#CK-203</td>
                            <td>₹3,20,000</td>
                            <td><span class="status-badge status-paid">Paid</span></td>
                            <td>15 Oct 2024</td>
                            <td class="text-danger">₹16,000 (5%)</td>
                            <td><a href="#" class="text-decoration-none"><i class="bi bi-file-earmark-text"></i> Download</a></td>
                        </tr> -->
                        <!-- <tr>
                            <td>#CK-204</td>
                            <td>₹1,85,000</td>
                            <td><span class="status-badge status-processing">Processing</span></td>
                            <td>28 Nov 2024</td>
                            <td class="text-danger">₹12,950 (7%)</td>
                            <td class="text-muted">Pending</td>
                        </tr> -->
                        <tr><td>No Payment Is There</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
