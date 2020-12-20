<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data = array_filter($request->validate([
            'people_id' => 'int|nullable',
            'page' => 'int|nullable'
        ]));
        // dd($data);

        $contacts = Contact::with('contactType');
        if(isset($data["people_id"])) $contacts->where('people_id', $data['people_id']);
        if(isset($data['page'])){
            return $contacts->paginate(10);
        }else{
            return $contacts->get();
        }
    }
}
