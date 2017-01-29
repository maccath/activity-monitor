@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Streams Dashboard</div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th></th>
                            <th>Last Consumed</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($streams as $stream)
                            <tr>
                                <td>
                                    {{ $stream->getName() }}
                                </td>
                                <td>
                                    {{ $stream->getDescription() }}
                                </td>
                                <td>
                                    <span class="label label-{{ strtolower($stream->getType()) }}">
                                        {{ $stream->getType() }}
                                    </span>
                                </td>
                                <td>
                                    @if ($stream->getType() == 'Periodic')
                                        {{ $stream->lastFetch() ? $stream->lastFetch()->format('d-m-Y H:i') : 'Never' }}
                                    @else
                                        &mdash;
                                    @endif
                                </td>
                                <td>
                                    @if ($stream->getType() == 'Periodic')
                                        <a class="btn btn-default btn-xs" href="{{ $stream->getConsumeUrl() }}">Consume</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
