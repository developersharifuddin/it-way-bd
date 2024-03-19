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
    .book-img img {
        width: 100px;
        height: 120px
    }

    .book-text-area p {
        font-size: 13px;
    }

    .book-list-wrapper {
        text-align: center
    }

    .book-info__content .fs-6 {
        font-size: 13px;
    }

    .bookListContainer .col-4:hover {
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
            <h4 class="card-title float-left pt-2">Create New purchase_orders</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.purchase-orders.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="supplier_id">Supplier ID</label>
                            <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select name="product_id[]" class="form-control @error('product_id') is-invalid @enderror" id="product_id" value="{{ old('product_id') }}" required>
                                <option value="">Select Product</option>
                                {{-- Fetch and loop through your products --}}
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                            <label for="total_purchase_qty">Total Purchase Quantity</label>
                            <input type="number" name="total_purchase_qty" class="form-control @error('total_purchase_qty') is-invalid @enderror" id="total_purchase_qty" value="{{ old('total_purchase_qty') }}" required>
                            @error('total_purchase_qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="is_purchased">Is Purchased</label>
                            <input type="checkbox" name="is_purchased" class="form-check @error('is_purchased') is-invalid @enderror" id="is_purchased" value="{{ old('is_purchased') }}" checked required>
                            @error('is_purchased')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="is_received">Is Received</label>
                            <input type="checkbox" name="is_received" class="form-check @error('is_received') is-invalid @enderror" checked required>
                            @error('is_received')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 col-md-3">
                        <div class="form-group">
                            <label for="is_closed">Is Closed</label>
                            <input type="checkbox" name="is_closed" class="form-check @error('is_closed') is-invalid @enderror" checked required>
                            @error('is_closed')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="text-right">
                        <a type="button" class="btn btn-primary" href="{{ route('admin.purchase-orders.index') }}">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.content -->
@endsection
