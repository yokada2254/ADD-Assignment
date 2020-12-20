<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\Contact;
use App\Models\ContactTypes;


class PeopleContactController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request, People $people){
        $data = array_filter($request->validate(['page' => 'int|nullable']));
        
        $fields = ['id', 'data', 'contact_type_id'];

        if(!is_null($people->id)){
            return $people->contacts()->with('contactType')->get($fields);
        }else{
            $contacts = Contact::with('contactType');
            
            if(isset($data['page'])){
                return $contacts->paginate(10, $fields);
            }else{
                return $contacts->get($fields);
            }
        }
    }

    public function create(People $people){
        $contactTypes = ContactTypes::all();
        $contact = new Contact();
        return view('people.contacts.create', compact('contact', 'people', 'contactTypes'));
    }

    public function store(People $people, Request $request){
        $data = $this->validation($request);
        $people->contacts()->create($data);

        return redirect()->route("people.show", ["people" => $people]);
    }

    public function edit(People $people, Contact $contact){
        $contactTypes = ContactTypes::all();
        return view('people.contacts.edit', compact('contact', 'people', 'contactTypes'));
    }

    public function update(People $people, Contact $contact, Request $request){
        $data = $this->validation($request);
        $contact->update($data);
        return redirect()->route('people.show', ['people' => $people]);
    }

    public function destroy(People $people, Contact $contact){
        return redirect()->route('people.show', ["people" => $people]);
    }

    private function validation(Request $request){
        return $request->validate([
            'contact_type_id' => 'int|required',
            'data' => 'string|min:5|max:100|required'
        ]);
    }
}