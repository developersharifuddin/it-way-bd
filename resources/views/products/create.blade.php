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
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.purchase-orders.index') }}">Purchase Orders</a></li>
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
            <h4 class="card-title float-left pt-2">Create New Purchase Order</h4>
        </div>
        <div class="container p-4">
            <form method="POST" action="{{ route('admin.purchase-orders.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id"></label>
                                    <input name="supplier_id" class="form-control" placeholder="----New Purchase Order----" disabled />
                                </div>
                            </div>


                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier Name</label>
                                    <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" id="supplier" data-live-search="true" required>
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
                                <label for="">Purchase Order Date</label>
                                <input type="date" class="form-control" id="po_date" name="po_date" required min="{{ date('Y-m-d') }}" required>
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
                                    <input disabled type="number" name="total_purchase_qty" min="1" max="5000" placeholder="0" class="form-control @error('total_purchase_qty') is-invalid @enderror" id="total_purchase_qty" required>
                                    @error('total_purchase_qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="">Total Published Price</label>
                                <input disabled type="number" class="form-control" id="total_unit_price" placeholder="0.00" name="total_unit_price" required>
                            </div>


                            <div class="mb-3 col-md-3">
                                <label for="">Total Purchase Price</label>
                                <input disabled type="number" class="form-control" id="total_price" placeholder="0.00" name="total_price">
                            </div>

                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter Rremarks..." required>{{old('remarks')}}</textarea>
                                    @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group d-flex">
                                    <input type="checkbox" name="is_purchased" class="form-check @error('is_purchased') is-invalid @enderror mx-2" id="is_purchased" checked required>
                                    <label for="is_purchased">Is Purchased </label>
                                    @error('is_purchased')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group d-flex">
                                    <input type="checkbox" name="is_received" id="is_received" class="form-check @error('is_received') is-invalid @enderror  mx-2" required>
                                    <label for="is_received">Is Received </label>
                                    @error('is_received')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col-md-3" id="challan_number_field" style="display: none;">
                                <div class="form-group">
                                    <label for="challan_number">challan Number</label>
                                    <input type="number" name="challan_number" min="1" placeholder="Challan number..." class="form-control @error('challan_number') is-invalid @enderror" id="challan_number" required>
                                    @error('challan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col-md-3">
                                <div class="form-group d-flex">
                                    <input type="checkbox" name="is_closed" class="form-check @error('is_closed') is-invalid @enderror mx-2" checked required>
                                    <label for="is_closed">Is Closed </label>
                                    @error('is_closed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-header bordered">
                        <h4>Purchase Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row justify-content-center">

                            <div class="mb-3 col-md-4">
                                <label for="product_id">Select Product</label>
                                <select name="" class="form-control" id="product" data-live-search="true" onchange="document.getElementById('addProduct').disabled = false;">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <div id="add_product_button_container" class=" col-md-3 align-self-end mt-2">
                                    <span id="addProduct" onclick="addProduct()" class="btn btn-sm btn-primary mt-4" disabled>
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                            </div>



                        </div>

                        <div id="tableContainer">
                            <table class="table table-sm">
                                <thead>
                                    <tr class="bg-light">
                                        <th>product ID</th>
                                        <th>product Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Published Price</th>
                                        <th>Purchase Price</th>
                                        <th>Purchase Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="productTableBody"></tbody>
                            </table>
                        </div>

                        <div id="save_purchase_container" class="text-right">
                            <button id="save_purchase" class="btn btn-sm btn-success btn-lg">Save purchase</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- /.content -->


@endsection
@push('.js')
{{-- <script src="{{ asset('js/package.js?ver=1.0.2') }}"></scri /pt> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // $(document).ready(function() {
    document.getElementById('po_date').valueAsDate = new Date();




    function addProduct() {
        const productId = $("#product").val();
        if (productId == "") {
            alert("Please select supplier and product.");
            return;
        }
        axios.get('/admin/get-Product/' + productId)
            .then(function(response) {
                $("#product").val("");
                console.log(response.data.items)
                var tableBody = document.getElementById("productTableBody");


                var newRow = tableBody.insertRow();
                newRow.innerHTML = `<td>${response.data.items.id} <input type="hidden" name="product_id[]" id="product_id" value="${response.data.items.id}" required></td> 
                          <td>${response.data.items.name}</td> 
                          <td>${response.data.items.brand_id}</td> 
                          <td>${response.data.items.category_id}</td> 
                          <td class="published_price">${response.data.items.published_price}</td> 
                          <td class="purchase-price">${response.data.items.purchase_price}</td> 
                          <td class="item_qty"><input type="number" name="purchase_qty[]" value="1" min="1" max="5000" onchange="updateTotalPurchaseQty()" class="form-check @error('purchase_qty') is-invalid @enderror" required></td>  
                          <td><button onclick="deleteRow(this)" class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button></td>`;

                updateTotalPurchaseQty()
                updateTotalPurchasePrice();
                updateTotalPublishedPrice();

                toastr.success('Add for Purchase Order.', response.data.items.name);
            })
            .catch(function(error) {
                console.error('Failed to fetch categories:', error);
                toastr.error(error.message);
            });
    }



    // Define updateTotalPurchaseQty function in the global scope
    function updateTotalPurchaseQty() {
        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="purchase_qty[]"]');
        var totalPurchaseQtyInput = document.getElementById('total_purchase_qty');
        var totalQty = 0;
        purchaseQtyInputs.forEach(function(input) {
            totalQty += parseInt(input.value) || 0;
        });
        totalPurchaseQtyInput.value = totalQty;
        updateTotalPurchasePrice();
        updateTotalPublishedPrice();

    }

    function updateTotalPurchasePrice() {
        var purchasePriceElements = document.querySelectorAll('.purchase-price');
        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="purchase_qty[]"]');
        var totalPriceInput = document.getElementById('total_price');
        var total = 0;

        // Iterate over each item row
        purchasePriceElements.forEach(function(priceElement, index) {
            var purchasePrice = parseFloat(priceElement.textContent || 0); // Get purchase price
            var purchaseQty = parseInt(purchaseQtyInputs[index].value) || 0; // Get purchase quantity
            var subtotal = purchasePrice * purchaseQty; // Calculate subtotal for the current row
            total += subtotal; // Add subtotal to total
        });

        totalPriceInput.value = total.toFixed(2); // Update total purchase price input field
    }

    function updateTotalPublishedPrice() {
        var purchasePriceElements = document.querySelectorAll('.published_price');
        var purchaseQtyInputs = document.querySelectorAll('.item_qty input[name="purchase_qty[]"]');
        var totalPriceInput = document.getElementById('total_unit_price');
        var total = 0;

        // Iterate over each item row
        purchasePriceElements.forEach(function(priceElement, index) {
            var purchasePrice = parseFloat(priceElement.textContent || 0); // Get purchase price
            var purchaseQty = parseInt(purchaseQtyInputs[index].value) || 0; // Get purchase quantity
            var subtotal = purchasePrice * purchaseQty; // Calculate subtotal for the current row
            total += subtotal; // Add subtotal to total
        });

        totalPriceInput.value = total.toFixed(2); // Update total purchase price input field
    }


    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateTotalPurchaseQty();
        updateTotalPurchasePrice();
        updateTotalPublishedPrice();
    }
    // });



    // Get references to the checkbox and input field
    const isReceivedCheckbox = document.getElementById('is_received');
    const challanNumberField = document.getElementById('challan_number_field');

    // Add event listener to the checkbox
    isReceivedCheckbox.addEventListener('change', function() {
        // If checkbox is checked, show the input field; otherwise, hide it
        if (this.checked) {
            challanNumberField.style.display = 'block';
        } else {
            challanNumberField.style.display = 'none';
        }
    });

</script>

@endpush
