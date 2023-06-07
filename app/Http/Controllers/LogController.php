<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Auth;
use Log;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($islem, $talep, $note, $last, $new)
    {
        if (Auth::guest()) {
            $user = explode('**', $islem);
            $log = new History();
            $log->user_id   = @$user[1];
            $log->talep_id  = $talep;
            $log->islem     = $islem;
            $log->note      = $note;
            $log->last_status = $last;
            $log->new_status  = $new;
            $log->save();
        } else {
            $log = new History();
            $log->user_id   = Auth::user()->id;
            $log->talep_id  = $talep;
            $log->islem     = $islem;
            $log->note      = $note;
            $log->last_status = $last;
            $log->new_status  = $new;
            $log->save();
        }
    }

    public function create_out($islem, $talep, $note, $last, $new, $user_id)
    {
        $log = new History();
        $log->user_id   = $user_id;
        $log->talep_id  = $talep;
        $log->islem     = $islem;
        $log->note      = $note;
        $log->last_status = $last;
        $log->new_status  = $new;
        $log->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
