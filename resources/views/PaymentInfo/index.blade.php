@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Payment Information
            </div>
            <div class="card-body">
                @if($paymentInfos->count())
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Method</th>
                                <th>Account No.</th>
                                <th>Account Type</th>
                                <th class="text-center">Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paymentInfos as $paymentInfo)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $paymentInfo->method }}</td>
                                    <td>{{ $paymentInfo->account_no }}</td>
                                    <td>{{ $paymentInfo->account_type }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <div>
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.payment-info.edit', $paymentInfo) }}" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            </div>
                                            <form class="pl-1" action="{{ route('admin.payment-info.destroy', $paymentInfo) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                            </form>
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
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div class="flex-column">
                        <a href="{{ route('dashboard') }}" class="btn custom btn-light">Back</a>
                    </div>
                    <div class="flex-column justify-content-center">
                        {{ $paymentInfos->links() }}
                    </div>
                    <div class="flex-column">
                        <a href="{{ route('admin.payment-info.create') }}" class="btn custom btn-success">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
