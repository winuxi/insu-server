<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ appName() }} - {{ $claim->claim_number }} Detail</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            color: #000000;
            background: #f5f5f5;
            padding: 30px 15px;
            font-size: 11px;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20mm;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .policy-id {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000000;
        }

        .policy-subtitle {
            font-size: 14px;
            color: #333333;
            font-style: italic;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #cccccc;
            padding-bottom: 3px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #000000;
        }

        .info-table td {
            border: 1px solid #cccccc;
            padding: 6px 8px;
            font-size: 10px;
            vertical-align: top;
        }

        .info-table td.label {
            background: #f0f0f0;
            font-weight: bold;
            width: 25%;
        }

        .info-table td.value {
            background: #ffffff;
            width: 25%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            border: 1px solid #000000;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #cccccc;
            padding: 5px 7px;
            text-align: left;
            font-size: 9px;
        }

        .data-table th {
            background: #e8e8e8;
            font-weight: bold;
            text-transform: uppercase;
        }

        .data-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .status-verified {
            color: #006600;
            font-weight: bold;
        }

        .status-not-verified {
            color: #cc0000;
            font-weight: bold;
        }

        .amount {
            font-weight: bold;
            color: #000000;
        }

        .description-section {
            background: #ffffff;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #cccccc;
        }

        .description-section h3 {
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            margin: 10px 0 6px 0;
        }

        .description-section p {
            margin: 0 0 6px 0;
            color: #000000;
            font-size: 10px;
            line-height: 1.3;
            text-align: justify;
        }

        .terms-list {
            list-style: none;
            padding: 0;
            margin: 8px 0;
        }

        .terms-list li {
            margin: 8px 0;
            padding: 8px;
            background: #ffffff;
            border: 1px solid #cccccc;
            font-size: 10px;
        }

        .terms-list li strong {
            color: #000000;
            font-weight: bold;
        }

        .terms-list ul {
            margin: 6px 0 0 0;
            padding-left: 12px;
        }

        .terms-list ul li {
            margin: 3px 0;
            background: none;
            border: none;
            padding: 0;
            list-style: disc;
        }

        .highlight-box {
            background: #f8f8f8;
            border: 1px solid #000000;
            padding: 10px;
            margin: 10px 0;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .three-column {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .no-data-message {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-style: italic;
            background: #f9f9f9;
            border: 1px solid #cccccc;
            margin: 12px 0;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                max-width: none;
                padding: 15mm;
                margin: 0;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px 10px;
            }

            .container {
                padding: 15mm;
            }

            .two-column,
            .three-column {
                grid-template-columns: 1fr;
            }

            .data-table {
                font-size: 8px;
            }

            .data-table th,
            .data-table td {
                padding: 3px 4px;
            }
        }
    </style>
</head>

<body>
    @php
        use App\Models\Claim;
        use App\Models\Policy;
        use App\Models\User;
        use Illuminate\Support\Carbon;
    @endphp
    <div class="container">
        <div class="header">
            <h1 class="policy-id">{{ $claim->claim_number }}</h1>
        </div>

           <!-- Claim Information -->
        <div class="section">
            <table class="info-table">
                <tr>
                    <td class="label">Insurance</td>
                    <td class="value">{{ insuranceCustomerPrefix($claim->insurance->id) }}</td>
                    <td class="label">Claim Date</td>
                    <td class="value">{{ Carbon::parse($claim->date)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td class="value">{{ Claim::STATUS[$claim->status] }}</td>
                    <td class="label">Created At</td>
                    <td class="value">{{ Carbon::parse($claim->created_at)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Reason</td>
                    <td class="value">{{ $claim?->reason }}</td>
                    <td class="label">Note</td>
                    <td class="value">{{ $claim?->note }}</td>
                </tr>
            </table>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <table class="info-table">
                <tr>
                    <td class="label">Customer ID</td>
                    <td class="value">{{ invoiceCustomerPrefix($claim->customer->id) }}</td>
                    <td class="label">Name</td>
                    <td class="value">{{ $claim->customer->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">{{ $claim->customer?->email }}</td>
                    <td class="label">Phone Number</td>
                    <td class="value">{{ $claim->customer?->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Company</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()?->company_name }}</td>
                    <td class="label">Date of Birth</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()?->dob }}</td>
                </tr>
                <tr>
                    <td class="label">Age</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()?->age }}</td>
                    <td class="label">Gender</td>
                    <td class="value">{{ User::GENDERS[$claim->customer?->gender] ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Marital Status</td>
                    <td class="value">{{ User::MARITAL_STATUS[$claim->customer?->companyDetails?->first()?->marital_status] ?? '-' }}</td>
                    <td class="label">Blood Group</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()->blood_group }}</td>
                </tr>
                <tr>
                    <td class="label">Height</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()->height }}</td>
                    <td class="label">Weight</td>
                    <td class="value">70 kg</td>
                </tr>
                <tr>
                    <td class="label">Tax Number</td>
                    <td class="value">{{ $claim->customer?->companyDetails?->first()->tax_no }}</td>
                    <td class="label">Address</td>
                    <td class="value">{{ $claim->customer?->addresses?->first()->address }}</td>
                </tr>
            </table>
        </div>

        <!-- Insured Detail -->
        <div class="section">
            <div class="section-title">Insured Detail</div>
            @if($claim->insurance->insureds && $claim->insurance->insureds->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>Relation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claim->insurance->insureds as $insured)
                        <tr>
                            <td>{{ $insured->name }}</td>
                            <td>{{ Carbon::parse($insured->dob)->format('M d, Y') }}</td>
                            <td>{{ $insured->age }}</td>
                            <td>{{ App\Models\User::GENDERS[$insured->gender] ?? '' }}</td>
                            <td>{{ $insured->blood_group }}</td>
                            <td>{{ $insured->height }}</td>
                            <td>{{ $insured->weight }}</td>
                            <td>{{ $insured->relation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data-message">
                No Data Found
            </div>
            @endif
        </div>

        <!-- Nominee Detail -->
        <div class="section">
            <div class="section-title">Nominee Detail</div>
            @if($claim->insurance->nominees && $claim->insurance->nominees->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Relation</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claim->insurance->nominees as $nominee)
                        <tr>
                            <td>{{ $nominee->name }}</td>
                            <td>{{ Carbon::parse($nominee->dob)->format('M d, Y') }}</td>
                            <td>{{ $nominee->relation }}</td>
                            <td>{{ $nominee->percentage .' %' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data-message">
                No Data Found
            </div>
            @endif
        </div>

        <!-- Document Detail -->
        <div class="section">
            <div class="section-title">Document Detail</div>
            @if($claim->documents && $claim->documents->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Document</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claim->documents as $document)
                        <tr>
                            <td>{{ $document->documentType->name }}</td>
                            <td>{{ $document->media->first()->name }}</td>
                            <td class="{{ $document->status == 1 ? 'status-verified' : 'status-not-verified' }}">
                                {{ App\Models\claimDocument::STATUS[$document->status] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data-message">
                No Data Found
            </div>
            @endif
        </div>

        <!-- Agent Detail -->
        <div class="section">
            <div class="section-title">Agent Detail</div>
            <table class="info-table">
                <tr>
                    <td class="label">Agent ID</td>
                    <td class="value">{{ agentNumberPrefix($claim->insurance?->agent?->id) }}</td>
                    <td class="label">Name</td>
                    <td class="value">{{ $claim->insurance?->agent?->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="value">{{ $claim->insurance?->agent?->email }}</td>
                    <td class="label">Phone Number</td>
                    <td class="value">{{ $claim->insurance?->agent?->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Company</td>
                    <td class="value">{{ $claim->insurance?->agent?->companyDetails?->first()?->company_name }}</td>
                    <td class="label">Address</td>
                    <td class="value">{{ $claim->insurance?->agent?->addresses?->first()->address }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Detail -->
        <div class="section">
            <div class="section-title">Payment Detail</div>
            @if($claim->insurance->payments && $claim->insurance->payments->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Premium</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claim->insurance->payments as $payment)
                        <tr>
                            <td>{{ Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                            <td class="amount">$5,000</td> {{-- for now --}}
                            <td>CGST (5%) ($250)<br>SGST (5%) ($250)</td>{{-- for now --}}
                            <td class="amount">{{ $payment->amount }}</td>{{-- for now --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data-message">
                No Data Found
            </div>
            @endif
        </div>

        <!-- Policy Description -->
        <div class="section">
            <div class="section-title">Policy Description</div>
            <div class="description-section">
                @if($claim->insurance?->policy?->description)
                    {!! $claim->insurance?->policy?->description !!}
                @else
                    <div class="no-data-message">
                        No Data Found
                    </div>
                @endif
            </div>
        </div>

        <!-- Policy Terms & Condition -->
        <div class="section">
            <div class="section-title">Policy Terms & Condition</div>
            <div class="description-section">
                @if($claim->insurance?->policy?->term)
                    {!! $claim->insurance?->policy?->term !!}
                @else
                    <div class="no-data-message">
                        No Data Found
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
