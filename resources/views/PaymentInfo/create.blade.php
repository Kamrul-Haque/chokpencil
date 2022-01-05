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
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <div class="card-header">
                    Create Payment Method
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment-info.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="service">Payment Method</label>
                            <select name="service" id="service" class="form-control @error('service') is-invalid @enderror" required>
                                <option value="" selected disabled>Please Select...</option>
                                <option value="BKash" @if(old('service') == "BKash") selected @endif>BKash</option>
                                <option value="Nagad" @if(old('service') == "Nagad") selected @endif>Nagad</option>
                                <option value="Rocket" @if(old('service') == "Rocket") selected @endif>Rocket</option>
                            </select>

                            @error('service')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="acc">Account No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+880</div>
                                </div>
                                <input id="acc" type="tel" class="form-control @error('acc') is-invalid @enderror" name="acc" value="{{ old('acc') }}" required>

                                @error('acc')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Account Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="" selected disabled>Please Select...</option>
                                <option value="Merchant" @if(old('type') == "Merchant") selected @endif>Merchant</option>
                                <option value="Personal" @if(old('type') == "Personal") selected @endif>Personal</option>
                            </select>

                            @error('type')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                            <button type="submit" class="btn custom btn-dark">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
