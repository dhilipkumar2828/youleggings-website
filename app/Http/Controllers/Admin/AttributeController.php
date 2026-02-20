<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;

class AttributeController extends Controller

{
    public $userid;
    public $username;

    function __construct()

    {

        $this->middleware(function ($request, $next) {
    if (Auth::user()->roles[0]->id == 1) {
        return $next($request); // allow admin
    }
    return $next($request);
});

        //  $this->middleware('permission:Attribute Create', ['only' => ['create','store']]);

        //  $this->middleware('permission:Attribute Edit', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Attribute Delete', ['only' => ['destroy']]);

         $this->userid=@Auth::user()->id;

         $this->username=@Auth::user()->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()
    {
        $Attribute = Attribute::orderBy('id', 'DESC')->get();
        return view('backend.Attribute.view', compact('Attribute'));
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.Attribute.add');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request)
    {
        $types = $request->input('attribute_type');
        $values = $request->input('value');
        
        if (!is_array($types)) {
            Session::put('error', 'Invalid data submitted');
            return redirect()->back();
        }

        $added_count = 0;
        $duplicate_count = 0;

        foreach ($types as $index => $type) {
            if (empty($type)) continue;

            $duplicate_check = Attribute::where('attribute_type', $type)->first();

            if (!$duplicate_check) {
                $attribute = new Attribute;
                $attribute->attribute_type = $type;
                
                $row_values = isset($values[$index]) ? $values[$index] : [];
                $attribute->value = $row_values;
                $attribute->created_by = auth()->id() ?? $this->userid;
                $attribute->save();
                $added_count++;
            } else {
                $duplicate_count++;
            }
        }

        if ($added_count > 0) {
            Session::put('success', "$added_count Attribute(s) successfully added.");
        }
        
        if ($duplicate_count > 0) {
            Session::put('warning', "$duplicate_count Duplicate Attribute Type(s) skipped.");
        }

        return redirect()->route('attribute.index');
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

        $attribute=Attribute::find($id);

        if($attribute){

            return view('backend.Attribute.edit',compact('attribute'));

        }

        else{

            return back()->with('error','Data not  found');

        }

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

        $attribute=Attribute::find($id);

        if($attribute){

          $data=$request->all();
          // leave value as-is (array/string); model mutator will handle JSON encoding
          $status=$attribute->fill($data)->save();

           if($status){

            Session::put('success','Successfully update Category');

            return redirect()->route('attribute.index');

          }else{

            Session::put('warning','something went worng!');

          }

        }else{

            Session::put('error','Attribute not fround');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $attribute=Attribute::find($id);

        if($attribute){

            $status=$attribute->delete();

            if($status){

                Session::put('error','Attribute successfully deleted');

                return redirect()->route('attribute.index');

            }

            else{

                Session::put('error','Data not found');

            }

        }

    }

}
