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
        .info{
            border: 2px dashed darkgray;
        }
        em{
            font-weight: 900;
            font-style: normal;
        }
        .wishlist-button{
            outline: none;
            background: transparent;
            border: none;
            padding-left: 0;
        }
        .wishlist-button:hover{
            text-decoration: underline;
        }
        th{
            font-weight: 900;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <h5 class="text-center">Payment Method</h5>
        <div class="d-flex justify-content-center pb-4">
            <div class="border px-5 py-3">
                <a href="{{ route('payment.stripe.create', $course) }}" class="text-decoration-none text-dark">
                    <i class="fas fa-credit-card"></i> International Cards
                </a>
            </div>
            <div class="border border-primary px-5 py-3">
                <a href="#" class="text-decoration-none text-primary text-dark">
                    <i class="fad fa-mobile"></i><i class="fas fa-arrow-right fa-xs px-1"></i><i class="far fa-money-bill fa-sm"></i> Mobile Banking
                </a>
            </div>
        </div>
        <div class="info table-responsive-lg">
            @if($paymentInfos->count())
                <table class="table border-bottom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Method</th>
                            <th>Account No.</th>
                            <th>Account Type</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($paymentInfos as $paymentInfo)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $paymentInfo->method }}</td>
                            <td>0{{ $paymentInfo->account_no }}</td>
                            <td>{{ $paymentInfo->account_type }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <p>Please pay <em>{{ $course->fee }} {{ $course->currency }}</em> to any of the above accounts & give the payment information below.</p>
                </div>
            @else
                <div class="text-center my-2">
                    <h5><strong>No Payment Methods Added yet!</strong></h5>
                </div>
            @endif
        </div>
        <br>
        <div class="card">
            <div class="card-header">
                Payment
            </div>
            <div class="card-body">
                <form action="{{ route('payment.store', $course) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="type">Payment Method</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="" selected disabled>Please Select...</option>
                            <option value="BKash" @if(old('type') == "BKash") selected @endif>BKash</option>
                            <option value="Nagad" @if(old('type') == "Nagad") selected @endif>Nagad</option>
                            <option value="Rocket" @if(old('type') == "Rocket") selected @endif>Rocket</option>
                        </select>

                        @error('type')
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
                        <label for="trxid">Transaction ID</label>
                        <input type="text" id="trxid" name="trxid" class="form-control @error('trxid') is-invalid @enderror" value="{{ old('trxid') }}" required>

                        @error('trxid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reference">Reference</label>
                        <input type="text" id="reference" name="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') }}">

                        @error('reference')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                        <button type="submit" class="btn custom btn-primary">Pay @if($course->currency == 'BDT')&#2547;@elseif($course->currency == 'USD')&dollar;@else{{$course->currency}}@endif{{ $course->fee }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
