@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Streams Dashboard</div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th>Last Run</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($streams as $stream)
                            <tr>
                                <td>{{ $stream->getName() }}</td>
                                <td>{{ $stream->getDescription() }}</td>
                                <td>@if ($stream->getType() == 'Periodic') {{ $stream->lastFetch()->format('d-m-Y H:i') }} @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
