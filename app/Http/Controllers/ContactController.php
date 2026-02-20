<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
      function __construct()
    {
         $this->middleware('permission:Contact List|Contact Create|Contact Edit|Contact Delete', ['only' => ['index','store']]);
         $this->middleware('permission:Contact Create', ['only' => ['create','store']]);
         $this->middleware('permission:Contact Edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Contact Delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts=Contact::orderBy('id','DESC')->get();
        return view('backend.contact.view',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.contact.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
            'address'=>'string|required',
            'email'=>'required|email',
            'mobile'=>'required|min:11|numeric',
            'photo'=>'string',

        ]);
        $data=$request->all();
        $slug=Str::slug($request->input('title'));
        $slug_count=Contact::where('slug',$slug)->count();
        if($slug_count>0){
            $slug .=time().'-'.$slug;
        }
        $data['slug']=$slug;
        // return $data;
        $status=Contact::create($data);
        if($status){
            Session::put('success','Successfully created Contact');
            return redirect()->route('contact.index');

        }else{
            return back()->with('error','something went worng!');
        }
    }
    public function sendEmail()
{
    $data = [
        'title' => 'Mail from Laravel',
        'body' => 'This is a test email sent using SMTP in Laravel.'
    ];

    // Mail::send('emails.testmail', $data, function ($message) {
    //     $message->to('recipient@example.com')
    //             ->subject('Test Email Subject')
    //             ->from('your_email@example.com', 'Your App Name');
    // });
 $content = "This is a test email sent using raw content in Laravel.";

    Mail::raw($content, function ($message) {
        $message->to('gflrs777@gmail.com')
                ->subject('Test Email Subject')
                ->from('prayashacollections@gmail.com', 'Prrayesha');
    });
    return "Email sent successfully!";
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
        $contact=Contact::find($id);
        if($contact){
            return view('backend.contact.edit',compact('contact'));
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
        $contact=Contact::find($id);
        if($contact){
            // return view('backend.banner.edit',compact('banner'));
           // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'address'=>'string|required',
            'email'=>'required|email',
            'mobile'=>'required|min:11|numeric',
            'photo'=>'string',
        ]);
        $data=$request->all();

        $status=$contact->fill($data)->save();
        if($status){
             Session::put('success','Successfully update Contact');
            return redirect()->route('contact.index');

        }else{
            return back()->with('error','something went worng!');
        }
        }

    }

        public function reviews(){

        return view('frontend.reviews');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact=Contact::find($id);
        if($contact){
            $status=$contact->delete();
            if($status){
                Session::put('error','Contact successfully deleted');
               return redirect()->route('contact.index');
            }
            else{
                return back()->with('error','Data not found');
            }

        }

    }
}
