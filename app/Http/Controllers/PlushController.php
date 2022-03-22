<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlushRequest;
use App\Models\Plush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlushController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plushies = Plush::all();
        return response()->json($plushies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), (new PlushRequest())->rules());
        if ($validator->fails()) {
            $errormsg = "";
            foreach ($validator->errors()->all() as $error) {
                $errormsg .= $error . " ";
            }
            $errormsg = trim($errormsg);
            return response()->json($errormsg, 400);
        }
        $plsuh = new Plush();
        $plsuh->fill($request->all());
        $plsuh->save();
        return response()->json($plsuh, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plush  $plush
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $plush = Plush::find($id);
        if (is_null($plush)) {
            return response()->json(["message" => "A megadott azonosítóval nem található plush."], 404);
        }
        return response()->json($plush);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plush  $plush
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if ($request->isMethod('PUT')) {
            $validator = Validator::make($request->all(), (new PlushRequest())->rules());
            if ($validator->fails()) {
                $errormsg = "";
                foreach ($validator->errors()->all() as $error) {
                    $errormsg .= $error . " ";
                }
                $errormsg = trim($errormsg);
                return response()->json($errormsg, 400);
            }
        }
        $plsuh = Plush::find($id);
        if (is_null($plsuh)) {
            return response()->json(["message" => "A megadott azonosítóval nem található Plush."], 404);
        }
        $plsuh->fill($request->all());
        $plsuh->save();
        return response()->json($plsuh, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plush  $plush
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $plush = Plush::find($id);
        if (is_null($plush)) {
            return response()->json(["message" => "A megadott azonosítóval nem található plush."], 404);
        }
        Plush::destroy($id);
        return response()->noContent();
    }
}
