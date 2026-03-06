<?php

namespace App\Http\Controllers;

use App\Models\Contactform;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class ContactformController extends Controller

{

     function __construct()

    {

        //  $this->middleware('permission:Enquiry List', ['only' => ['index']]);

        //  $this->middleware('permission:Contact Create', ['only' => ['create','store']]);

        //  $this->middleware('permission:Contact Edit', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Contact Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $contact_list=Contactform::orderBy('id','DESC')->get();

        return view('backend.contact.list',compact('contact_list'));

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

        $contact_list=Contactform::find($id);

        if($contact_list){

            $status=$contact_list->delete();

            if($status){

                Session::put('error','Contact successfully deleted');

               return redirect('contactlist');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}
