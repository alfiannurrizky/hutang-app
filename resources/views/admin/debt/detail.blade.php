@extends('layouts.template_default')

@section('content')

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Hutang {{ $customer->name }}</h4>
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
                    </div>
                    <div class="card-content">

                        <div class="card-body">
                            <div class="row">
                                @foreach ($customer->debts as $debt)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $debt->product->name }}</h5>
                                                <p class="card-text">
                                                    <strong>Jumlah:</strong> {{ $debt->quantity }}<br>
                                                    <strong>Total Harga:</strong> Rp
                                                    {{ number_format($debt->total_amount, 2) }}<br>
                                                    <strong>Tanggal:</strong> {{ $debt->created_at }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
