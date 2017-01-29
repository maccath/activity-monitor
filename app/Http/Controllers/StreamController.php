<?php

namespace App\Http\Controllers;

use App\ActivityStreams\PeriodicStreamInterface;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\ActivityStreams\PeriodicStreamInterface $stream
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fetch(Request $request, PeriodicStreamInterface $stream)
    {
        $stream->fetch();

        $fetched = sprintf(
            '%s fetched %d new items',
            $stream->getName(),
            $stream->getItems()->count()
        );

        $request->session()->flash('status', $fetched);
        return redirect('/streams');
    }
}
