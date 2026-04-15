<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ $proposal->title }}</title>
    <style>
        @page {
            margin: 26px 26px 30px 26px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.55;
            color: #0f172a;
            background: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        .page {
            width: 100%;
        }

        .hero {
            background: #0f172a;
            color: #ffffff;
            border-radius: 16px;
            padding: 24px 26px;
            margin-bottom: 18px;
        }

        .hero-table {
            width: 100%;
            border-collapse: collapse;
        }

        .hero-table td {
            vertical-align: top;
        }

        .eyebrow {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #a5b4fc;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .hero-title {
            font-size: 28px;
            line-height: 1.2;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: #ffffff;
        }

        .hero-intro {
            margin: 0;
            color: #cbd5e1;
            font-size: 11px;
            line-height: 1.7;
        }

        .hero-side {
            width: 230px;
            padding-left: 16px;
        }

        .hero-card {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 14px 16px;
        }

        .hero-card-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #cbd5e1;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .hero-card-name {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .hero-card-text {
            font-size: 10px;
            color: #cbd5e1;
            line-height: 1.5;
        }

        .main-layout {
            width: 100%;
            border-collapse: collapse;
        }

        .main-layout td {
            vertical-align: top;
        }

        .content-col {
            width: 68%;
            padding-right: 18px;
        }

        .side-col {
            width: 32%;
        }

        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .section-type {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.7px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .section-title {
            margin: 0 0 8px 0;
            font-size: 20px;
            line-height: 1.25;
            font-weight: 700;
            color: #0f172a;
        }

        .section-content {
            color: #334155;
            white-space: pre-line;
            line-height: 1.75;
        }

        .side-block {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .side-block-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .summary-table,
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td,
        .meta-table td {
            padding: 6px 0;
            vertical-align: top;
        }

        .summary-label,
        .meta-label {
            color: #64748b;
            font-size: 10px;
        }

        .summary-value,
        .meta-value {
            text-align: right;
            color: #0f172a;
            font-weight: 700;
            font-size: 10px;
        }

        .summary-total td {
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 14px;
            font-weight: 700;
        }

        .page-break {
            page-break-before: always;
        }

        .pricing-header {
            margin-bottom: 12px;
        }

        .pricing-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }

        .pricing-subtitle {
            margin: 6px 0 0 0;
            color: #64748b;
            font-size: 10px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items th {
            background: #f8fafc;
            color: #475569;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #e2e8f0;
            padding: 9px 10px;
        }

        table.items td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            vertical-align: top;
        }

        .item-name {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .item-description {
            color: #64748b;
            font-size: 10px;
            line-height: 1.55;
        }

        .totals-wrap {
            width: 100%;
            margin-top: 14px;
        }

        .totals-box {
            width: 260px;
            margin-left: auto;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 14px;
        }

        .notes-box {
            margin-top: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
            padding: 14px 16px;
            page-break-inside: avoid;
        }

        .notes-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .notes-content {
            white-space: pre-line;
            color: #334155;
            line-height: 1.7;
        }

        .footer {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }

        .empty-text {
            color: #64748b;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="hero">
            <table class="hero-table">
                <tr>
                    <td>
                        <div class="eyebrow">PitchFlow Proposal</div>
                        <h1 class="hero-title">{{ $proposal->title }}</h1>
                        <p class="hero-intro">
                            {{ $proposal->intro_message ?: 'A professional proposal prepared for client review.' }}
                        </p>
                    </td>

                    <td class="hero-side">
                        <div class="hero-card">
                            <div class="hero-card-label">Prepared For</div>
                            <div class="hero-card-name">
                                {{ $proposal->client?->name ?? 'Unknown Client' }}
                            </div>
                            <div class="hero-card-text">
                                {{ $proposal->client?->company ?: 'Independent Client' }}
                            </div>

                            @if ($proposal->client?->email)
                                <div class="hero-card-text" style="margin-top: 8px;">
                                    {{ $proposal->client->email }}
                                </div>
                            @endif

                            @if ($proposal->valid_until)
                                <div class="hero-card-text" style="margin-top: 10px;">
                                    Valid until {{ $proposal->valid_until->format('M d, Y') }}
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="main-layout">
            <tr>
                <td class="content-col">
                    @if ($proposal->sections->count())
                        @foreach ($proposal->sections as $section)
                            @if ($loop->index < 4)
                                <div class="section">
                                    <div class="section-type">{{ $section->type ?: 'section' }}</div>
                                    <h2 class="section-title">{{ $section->title }}</h2>
                                    <div class="section-content">
                                        {{ $section->content ?: 'No content available.' }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="section">
                            <div class="section-type">overview</div>
                            <h2 class="section-title">Proposal Overview</h2>
                            <div class="section-content empty-text">
                                No structured sections available yet.
                            </div>
                        </div>
                    @endif
                </td>

                <td class="side-col">
                    <div class="side-block">
                        <div class="side-block-title">Proposal Summary</div>

                        <table class="summary-table">
                            <tr>
                                <td class="summary-label">Status</td>
                                <td class="summary-value">{{ ucfirst($proposal->status) }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Subtotal</td>
                                <td class="summary-value">${{ number_format((float) $proposal->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Discount</td>
                                <td class="summary-value">${{ number_format((float) $proposal->discount, 2) }}</td>
                            </tr>
                            <tr class="summary-total">
                                <td>Total</td>
                                <td style="text-align: right;">${{ number_format((float) $proposal->total, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="side-block">
                        <div class="side-block-title">Proposal Details</div>

                        <table class="meta-table">
                            <tr>
                                <td class="meta-label">Created</td>
                                <td class="meta-value">{{ $proposal->created_at->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label">Valid Until</td>
                                <td class="meta-value">
                                    {{ $proposal->valid_until ? $proposal->valid_until->format('M d, Y') : '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="meta-label">Currency</td>
                                <td class="meta-value">USD</td>
                            </tr>
                            @if ($proposal->sent_at)
                                <tr>
                                    <td class="meta-label">Sent At</td>
                                    <td class="meta-value">{{ $proposal->sent_at->format('M d, Y') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    @if ($proposal->notes)
                        <div class="side-block">
                            <div class="side-block-title">Internal Notes</div>
                            <div class="section-content" style="font-size: 10px;">
                                {{ $proposal->notes }}
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="page">
        @if ($proposal->sections->count() > 4)
            @foreach ($proposal->sections as $section)
                @if ($loop->index >= 4)
                    <div class="section">
                        <div class="section-type">{{ $section->type ?: 'section' }}</div>
                        <h2 class="section-title">{{ $section->title }}</h2>
                        <div class="section-content">
                            {{ $section->content ?: 'No content available.' }}
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <div class="pricing-header">
            <h2 class="pricing-title">Pricing Items</h2>
            <p class="pricing-subtitle">
                A clear breakdown of the quoted services and final pricing.
            </p>
        </div>

        @if ($proposal->items->count())
            <table class="items">
                <thead>
                    <tr>
                        <th style="width: 42%;">Item</th>
                        <th style="width: 14%;">Quantity</th>
                        <th style="width: 20%;">Unit Price</th>
                        <th style="width: 24%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->items as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item->name }}</div>
                                @if ($item->description)
                                    <div class="item-description">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                            <td>${{ number_format((float) $item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty-text">No pricing items available.</p>
        @endif

        <div class="totals-wrap">
            <div class="totals-box">
                <table class="summary-table">
                    <tr>
                        <td class="summary-label">Subtotal</td>
                        <td class="summary-value">${{ number_format((float) $proposal->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="summary-label">Discount</td>
                        <td class="summary-value">${{ number_format((float) $proposal->discount, 2) }}</td>
                    </tr>
                    <tr class="summary-total">
                        <td>Total</td>
                        <td style="text-align: right;">${{ number_format((float) $proposal->total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if ($proposal->notes)
            <div class="notes-box">
                <div class="notes-title">Additional Notes</div>
                <div class="notes-content">{{ $proposal->notes }}</div>
            </div>
        @endif

        <div class="footer">
            Generated from PitchFlow on {{ now()->format('M d, Y \a\t h:i A') }}
        </div>
    </div>
</body>

</html>
