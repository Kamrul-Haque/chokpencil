@extends('layouts.app')

@section('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Edit Payment
            </div>
            <div class="card-body">
                <form action="{{ route('payment.update', ['payment'=>$payment, 'course'=>$course]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="acc">Account No.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+880</div>
                            </div>
                            <input id="acc" type="tel" class="form-control @error('acc') is-invalid @enderror" name="acc" value="{{ old('acc') ?? $payment->account_no }}" required>

                            @error('acc')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="trxid">Transaction ID</label>
                        <input type="text" id="trxid" name="trxid" class="form-control @error('trxid') is-invalid @enderror" value="{{ old('trxid') ?? $payment->transaction_id }}" required>

                        @error('trxid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reference">Reference</label>
                        <input type="text" id="reference" name="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') ?? $payment->reference }}">

                        @error('reference')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                        <button type="submit" class="btn custom btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
