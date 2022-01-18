@extends('layouts.app')

@section('content')
    <div class="container-fluid px-md-5 py-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Payments
                </div>
                @if($payments->count())
                    <div class="table-responsive-lg">
                        <table class="table border-bottom-0">
                            <thead class="font-weight-bolder">
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Account No.</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th class="text-center">Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $payment->course->title }}</td>
                                    <td>{{ $payment->user->name }}</td>
                                    <td>{{ $payment->user->email }}</td>
                                    <td>{{ $payment->account_no }}</td>
                                    <td>{{ $payment->transaction_id }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->reference }}</td>
                                    <td>@if($payment->is_verified) Verified @elseif($payment->needs_verification) Pending @else Rejected @endif</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($payment->needs_verification)
                                            <form action="{{ route('admin.payment.verify', ['course'=>$payment->course, 'payment'=>$payment]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm ml-1" title="verify">verify</button>
                                            </form>
                                            <form class="ml-1" action="{{ route('admin.payment.destroy', ['course'=>$payment->course, 'payment'=>$payment]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="delete">Reject</button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h4 class="d-flex justify-content-center">NO RECORDS FOUND</h4>
                @endif
                <div class="text-left">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
