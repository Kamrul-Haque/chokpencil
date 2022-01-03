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

    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="container py-4">
        <h5 class="text-center">Payment Method</h5>
        <div class="d-flex justify-content-center pb-4">
            <div class="border border-primary px-5 py-3">
                <a href="#" class="text-decoration-none text-primary">
                    <i class="fas fa-credit-card"></i> International Cards
                </a>
            </div>
            <div class="border px-5 py-3">
                <a href="{{ route('payment.create', $course) }}" class="text-decoration-none text-dark">
                    <i class="fad fa-mobile"></i><i class="fas fa-arrow-right fa-xs px-1"></i><i class="far fa-money-bill fa-sm"></i> Mobile Banking
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Stripe Payment
                    </div>
                    <div class="card-body">
                        <form action="{{ route('payment.stripe.store', $course) }}" method="post" id="payment-form">
                            @csrf
                            <div class="form-group">
                                <label for="name_on_card">Name on Card <span class="text-danger">*</span></label>
                                <input type="text" id="name_on_card" name="name_on_card" value="{{ old('name_on_card') }}" class="form-control @error('name_on_card') is-invalid @enderror" required>
                                @error('name_on_card') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="card-element">Card Information <span class="text-danger">*</span></label>
                                <div id="card-element" class="form-control">

                                </div>
                                <span id="card-errors" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="reference">Reference<span class="text-danger">*</span></label>
                                <input type="text" id="reference" name="reference" value="{{ old('reference') }}" class="form-control @error('reference') is-invalid @enderror" placeholder="name of the student" required>
                                @error('reference') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                                <button id="payment-button" type="submit" class="btn custom btn-primary">Pay @if($course->currency == 'BDT')&#2547;@elseif($course->currency == 'USD')&dollar;@else{{$course->currency}}@endif{{ $course->fee }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Create a Stripe client
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');

            // Create an instance of Elements
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    },
                    border: '2px solid #999',
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                // Disable the submit button to prevent repeated clicks
                document.getElementById('payment-button').disabled = true;

                var options = {
                    name: document.getElementById('name_on_card').value,
                }

                stripe.createToken(card, options).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;

                        // Enable the submit button
                        document.getElementById('payment-button').disabled = false;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        })
    </script>
@endsection
