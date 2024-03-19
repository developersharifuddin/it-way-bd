@extends('layouts.admin')
@section('title', 'Admin | purchase_orders')

@section('page-headder')
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.purchase-orders.index') }}">purchase-orders</a></li>
        </ol>
    </div>
</div>
<style>
    .product-img img {
        width: 100px;
        height: 120px
    }

    .product-text-area p {
        font-size: 13px;
    }

    .product-list-wrapper {
        text-align: center
    }

    .product-info__content .fs-6 {
        font-size: 13px;
    }

    .productListContainer .col-4:hover {
        border: 1px solid #999;

    }

    #loader {
        display: none;

    }


    /* styles.css */

    .barcode-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 20px;
        /* Adjust the margin as needed */
    }

    .barcode-item {
        border: 1px solid #888;
        padding: 0 6px;
        margin: 4px;
        /* Adjust the margin as needed */
    }

</style>


<div class="row">
    <div class="card bg-white p-0">
        <div class="card-header justify-content-between py-3">
            <h4 class="card-title float-left pt-2">View purchase_orders</h4>
        </div>
        <div class="container p-4">
            <form>

                <div class="row">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">SPO ID</label>
                                    <input name="" class="form-control" value="{{$purchaseOrder->id}}" disabled />
                                </div>
                            </div>



                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name</label>
                                    <select name="supplier_id" class="form-control" disabled>
                                        @if ($purchaseOrder->supplier_id)
                                        <option value="{{ $purchaseOrder->supplier_id }}">
                                            {{ $purchaseOrder->supplier->name }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                            </div>


                            {{-- <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name</label>
                                    <select name="" class="form-control" disabled>
                                        <option value="">
                                            {{ $purchaseOrder->suppliersName }}
                            </option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="mb-3 col-md-3">
                        <label for="">Purchase Order Date</label>
                        <input type="date" class="form-control" id="po_date" value="{{ date('Y-m-d', strtotime($purchaseOrder->po_date)) }}" disabled>
                    </div>


                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="purchased_by">Purchased By</label>
                            <select name="purchased_by" class="form-control @error('purchased_by') is-invalid @enderror" required readonly>
                                <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}</option>
                            </select>
                            @error('purchased_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="total_purchase_qty">Total Purchase Order Quantity</label>
                            <input disabled type="number" name="total_purchase_qty" min="1" max="5000" value="{{$purchaseOrder->total_purchase_qty}}" class="form-control @error('total_purchase_qty') is-invalid @enderror" id="total_purchase_qty" required>
                            @error('total_purchase_qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-3">
                        <label for="">Total Purchase Price</label>
                        <input disabled type="number" class="form-control" value="{{$purchaseOrder->total_purchase_amount}}" placeholder="0.00" name="total_price">
                    </div>

                    <div class="mb-3 col-md-3" id="challan_number_field" style="display: none;">
                        <div class="form-group">
                            <label for="challan_number">challan Number</label>
                            <input type="number" value="{{$purchaseOrder->challan_number}}" min="1" placeholder="Challan number..." class="form-control">
                        </div>
                    </div>

                    <div class="mb-3 col-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" class="form-control" placeholder="Enter Rremarks..." disabled> {{$purchaseOrder->remarks}} </textarea>
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group d-flex">
                            <input type="checkbox" disabled name="is_purchased" class="form-check @error('is_purchased') is-invalid @enderror mx-2" id="is_purchased" {{ $purchaseOrder->is_purchased == 1 ? 'checked' : '' }} required>
                            <label for="is_purchased">Is Purchased </label>
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group d-flex">
                            <input type="checkbox" disabled name="is_received" id="is_received" class="form-check mx-2" {{ $purchaseOrder->is_received == 1 ? 'checked' : '' }} required>
                            <label for="is_received">Is Received </label>
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group d-flex">
                            <input type="checkbox" disabled name="is_closed" class="form-check mx-2" {{ $purchaseOrder->is_closed == 1 ? 'checked' : '' }} required>
                            <label for="is_closed">Is Closed </label>
                        </div>
                    </div>



                </div>
        </div>
        <div class=" bordered">
            <h4>Purchase Items</h4>
        </div>
        <div class="card-body">
            <div id="tableContainer">
                <table class="table table-sm">
                    <thead>
                        <tr class="bg-light">
                            <th>product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Published Price</th>
                            <th>Purchase Price</th>
                            <th>Purchase Qty</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach ($purchaseOrder->purchaseOrderChildren as $child)
                        <tr>
                            <td>{{ $child->itemInfo->name ?? 'N/A' }}</td>
                            <td>{{ $child->itemInfo->brands->name_english ?? 'N/A' }}</td>
                            <td>{{ $child->itemInfo->category->name_english ?? 'N/A' }}</td>
                            <td>{{ $child->itemInfo->published_price ?? 'N/A' }}</td>
                            <td>{{ $child->purchase_price }}</td>
                            <td>{{ $child->purchase_qty }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="save_purchase_container" class="text-right">

                <a type="button" class="btn bg-danger" href="{{ route('admin.purchase-orders.index') }}">Close</a>
            </div>
        </div>
    </div>
    </form>
</div>

</div>
</div>
<!-- /.content -->


@endsection
