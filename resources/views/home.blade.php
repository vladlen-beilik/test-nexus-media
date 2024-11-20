@extends('layout')

@section('content')
    <div class="card">
        <div class="index-table-wrapper">
            <div class="index-table-header">
                <div class="index-table-header-filter">
                    <div class="col-right" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-icon btn-no-label btn-sort dropdown-toggle">
                                <span class="btn-icon-holder">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">
                                        <path d="M7.75 6.06v7.69a.75.75 0 0 1-1.5 0v-7.69l-1.72 1.72a.75.75 0 0 1-1.06-1.06l3-3a.75.75 0 0 1 1.06 0l3 3a.75.75 0 1 1-1.06 1.06l-1.72-1.72Z"></path>
                                        <path d="M13.75 6.25a.75.75 0 0 0-1.5 0v7.69l-1.72-1.72a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72v-7.69Z"></path>
                                    </svg>
                                </span>
                                Sort
                            </button>
                            <ul class="dropdown-menu align-right">
                                <li>
                                    <button>Import</button>
                                </li>
                                <li>
                                    <button>Export</button>
                                </li>
                                <li>
                                    <button>Duplicate</button>
                                </li>
                            </ul>
                        </div>
                    </div>
{{--                    <div class="search-filter">--}}
{{--                        <span class="tag">Wholesale</span>--}}
{{--                        <span class="tag">Wholesale<button class="tag-close">Close</button></span>--}}
{{--                    </div>--}}
                </div>
            </div>
{{--            <div class="index-table-footer-action">--}}
{{--                <div class="index-table-footer-inner">--}}
{{--                    <button class="btn btn-secondary">Bulk edit</button>--}}
{{--                    <button class="btn btn-secondary">Set as active</button>--}}
{{--                    <div class="dropdown">--}}
{{--                        <button class="btn btn-secondary btn-icon btn-no-label dropdown-toggle">--}}
{{--                            <span class="btn-icon-holder">--}}
{{--                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">--}}
{{--                                    <path d="M6 10a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"></path>--}}
{{--                                    <path d="M11.5 10a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"></path>--}}
{{--                                    <path d="M15.5 11.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"></path>--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                            Cancel--}}
{{--                        </button>--}}
{{--                        <ul class="dropdown-menu align-right">--}}
{{--                            <li>--}}
{{--                                <button class="dropdown-item">Import</button>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <button class="dropdown-item">Export</button>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <button class="dropdown-item delete">Delete</button>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="index-table-inner">
                <div class="index-table-header-action">
                    <div class="index-table-header-inner">
                        <div class="form-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="checkbox-icon"></span>
                                <span class="label-text">2 Selected</span>
                            </label>
                        </div>
                        <button class="link">Cancel</button>
                    </div>
                </div>
                <table class="index-table">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Total Price</th>
                        <th>Financial Status</th>
                        <th>Fulfillment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order['customer']['name'] ?? '' }}</td>
                            <td>{{ $order['customer']['email'] ?? '' }}</td>
                            <td>${{ $order['total_price'] ?? '$0' }}</td>
                            <td>
                                @if($order['financial_status'] === 'paid')
                                    <span class="badge badge-success">{{ $order['financial_status'] }}</span>
                                @elseif($order['financial_status'] === 'pending')
                                    <span class="badge badge-warning">{{ $order['financial_status'] }}</span>
                                @elseif($order['financial_status'] === 'refunded')
                                    <span class="badge badge-danger">{{ $order['financial_status'] }}</span>
                                @else
                                    <span class="badge badge-info">{{ $order['financial_status'] }}</span>
                                @endif
                            </td>
                            <td>
                                @if($order['fulfillment_status'])
                                    <span class="badge badge-info">{{ $order['fulfillment_status'] }}</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="index-table-footer">
                <div class="table-result">Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }} results</div>
                <div class="button-group">
                    <a
                        href="{{ $orders->previousPageUrl() }}"
                        class="btn btn btn-icon btn-no-label{{ $orders->currentPage() == 1 ? ' disabled-link' : null }}"
                        {{ $orders->currentPage() == 1 ? 'disabled' : '' }}
                    >
                        <span class="btn-icon-holder">
                            <svg viewBox="0 0 20 20" class="Icon_Icon__Dm3QW" style="width: 20px; height: 20px;">
                                <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414l-4.293 4.293 4.293 4.293a.999.999 0 0 1-.707 1.707z"></path>
                            </svg>
                        </span>
                        prev
                    </a>
                    <a
                        href="{{ $orders->nextPageUrl() }}"
                        class="btn btn btn-icon btn-no-label{{ $orders->lastPage() === $orders->currentPage() ? ' disabled-link' : null }}"
                        {{ $orders->lastPage() === $orders->currentPage() ? 'disabled' : '' }}
                    >
                        <span class="btn-icon-holder">
                            <svg viewBox="0 0 20 20" class="Icon_Icon__Dm3QW" style="width: 20px; height: 20px;">
                                <path d="M8 16a.999.999 0 0 1-.707-1.707l4.293-4.293-4.293-4.293a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5a.997.997 0 0 1-.707.293z"></path>
                            </svg>
                        </span>
                        next
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
