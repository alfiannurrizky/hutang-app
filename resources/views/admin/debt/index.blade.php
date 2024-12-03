@extends('layouts.template_default')

@section('content')
    <!-- Basic Tables start -->
    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hutang</h4>
                    </div>
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="card-content">

                        <div class="card-body">
                            <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal"
                                data-bs-target="#inlineForm">
                                Tambah Data
                            </button>

                            <!--login form Modal -->
                            <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel33">Tambah Data Hutang</h4>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('saveDataDebt') }}" method="POST" id="debtForm">
                                            @csrf
                                            <div class="modal-body" id="inputFields">
                                                <label for="name">Customer: </label>
                                                <div class="form-group">
                                                    <select class="choices form-select" id="customer_id" name="customer_id"
                                                        required>
                                                        <option value="">Pilih Customer</option>
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label for="product_id" class="me-2">Produk yang ingin dihutang:</label>
                                                <div class="form-group">
                                                    <select class="choices form-select" id="product_id" name="product_id"
                                                        required>
                                                        <option value="">Pilih Produk</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }} - Rp
                                                                {{ number_format($product->price) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label for="quantity" class="me-2">Jumlah:</label>
                                                <div class="form-group d-flex align-items-center mb-3">
                                                    <input id="quantity" class="form-control" type="number"
                                                        name="quantity" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Close</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Simpan</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-lg" id="table-hutang">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>CUSTOMER</th>
                                            <th>JUMLAH HUTANG</th>
                                            <th>STATUS</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($debts as $debt)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $debt->customer->name }}</td>
                                                <td class="text-bold-500">Rp {{ number_format($debt->total_debt, 2) }}</td>
                                                <td>
                                                    @if ($debt->is_paid)
                                                        <span class="badge bg-success">Lunas</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum Lunas</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.debt.detail', $debt->customer->id) }}"
                                                        class="btn btn-primary btn-sm">Detail</a>

                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#payDebt-{{ $debt->customer->id }}">
                                                        Bayar
                                                    </button>

                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#inlineForm2-{{ $debt->customer->id }}">
                                                        Tambah
                                                    </button>

                                                    <!-- Modal untuk pembayaran hutang -->
                                                    <div class="modal fade text-left"
                                                        id="payDebt-{{ $debt->customer->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel33">Bayar
                                                                        Hutang
                                                                        {{ $debt->customer->name }}</h4>
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('payDebt') }}" method="POST"
                                                                    id="debtForm">
                                                                    @csrf
                                                                    <input type="hidden" name="customer_id"
                                                                        value="{{ $debt->customer->id }}">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="payment_amount"
                                                                                class="form-label">Jumlah
                                                                                Pembayaran</label>
                                                                            <input type="number" name="payment_amount"
                                                                                class="form-control" min="1"
                                                                                max="{{ $debt->total_amount }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-light-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Close</span>
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary ms-1"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Simpan</span>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade text-left"
                                                        id="inlineForm2-{{ $debt->customer->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel33"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel33">Tambah
                                                                        Data
                                                                        Hutang</h4>
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('saveDataDebt') }}" method="POST"
                                                                    id="debtForm">
                                                                    @csrf

                                                                    <input type="hidden" name="customer_id"
                                                                        value="{{ $debt->customer->id }}">

                                                                    <div class="modal-body" id="inputFields">
                                                                        <label for="product-{{ $debt->customer->id }}"
                                                                            class="me-2">Produk yang
                                                                            ingin dihutang:</label>
                                                                        <div
                                                                            class="form-group d-flex align-items-center mb-3">
                                                                            <select class="form-control me-2"
                                                                                id="product-{{ $debt->customer->id }}"
                                                                                name="product_id" required>
                                                                                <option value="">Pilih Produk
                                                                                </option>
                                                                                @foreach ($products as $product)
                                                                                    <option value="{{ $product->id }}">
                                                                                        {{ $product->name }} - Rp
                                                                                        {{ number_format($product->price, 2) }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <label for="quantity-{{ $debt->customer->id }}"
                                                                            class="me-2">Jumlah:</label>
                                                                        <div
                                                                            class="form-group d-flex align-items-center mb-3">
                                                                            <input id="quantity-{{ $debt->customer->id }}"
                                                                                class="form-control" type="number"
                                                                                name="quantity" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-light-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Close</span>
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary ms-1"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Simpan</span>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
