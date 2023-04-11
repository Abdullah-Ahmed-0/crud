<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $BASE_URL                     = 'https://gorest.co.in/public/v2/';
    protected $TOKEN                        = 'fcce234d4a77dde2b8b588b4528b0bf6f138960a70d795429934efd67f8021f1';

    // All Users
    public function index(){
        $headers                            = array(
                                                'Accept:application/json',
                                                'Content-Type:application/json',
                                                'Authorization: Bearer '. $this->TOKEN
                                            );

        $ch                                 = curl_init($this->BASE_URL.'users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response                           = curl_exec($ch);
        $users                             = json_decode($response, true);
        curl_close($ch);
        return view('users.index',compact('users'));
    }

    // Create User View
    public function create(){
        return view('users.create');
    }

    // Store User
    public function store(Request $request){
        // Validate the request
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'gender'        => 'required',
            'status'        => 'required'
        ]);
        $data                               = [
            "name"          => $request->name,
            "gender"        => $request->gender == 1? 'male' : 'female',
            "email"         => $request->email,
            "status"        => $request->status == 1 ? 'active' : 'inactive'
        ];

        $headers                            = array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization: Bearer '.$this->TOKEN
        );
        $data                               = json_encode($data);
        // Curl request
        $ch                                 = curl_init($this->BASE_URL.'users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response                           = curl_exec($ch);
        curl_close($ch);
        // Curl request end
        $response                           = json_decode($response);
        return redirect()->route('users.index')->withSuccess(__('User created successfully.'));
    }

    // View User
    public function show($id)
    {
        $headers                            = array(
                                                'Accept:application/json',
                                                'Content-Type:application/json',
                                                'Authorization: Bearer '. $this->TOKEN
                                            );
        // Curl request
        $ch                                 = curl_init($this->BASE_URL.'users/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response                           = curl_exec($ch);
        curl_close($ch);
        // Curl request end
        $user                               = json_decode($response, true);
        return view('users.show', compact('user'));
    }
    // Edit User
    public function edit($id){
        $headers                            = array(
                                                'Accept:application/json',
                                                'Content-Type:application/json',
                                                'Authorization: Bearer '. $this->TOKEN
                                            );

        // Curl request
        $ch                                 = curl_init($this->BASE_URL.'users/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response                           = curl_exec($ch);
        curl_close($ch);
        // Curl request
        $user                               = json_decode($response, true);
        return view('users.edit', compact('user'));
    }
    // Update User
    public function update(Request $request, $id){
        // Validate
        $request->validate([
            'name'          => 'sometimes',
            'email'         => 'sometimes|email',
            'gender'        => 'sometimes',
            'status'        => 'sometimes'
        ]);
        $data                               = [
            "name"          => $request->name,
            "gender"        => $request->gender == 1? 'male' : 'female',
            "email"         => $request->email,
            "status"        => $request->status == 1 ? 'active' : 'inactive'
        ];

        $headers                            = array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization: Bearer '.$this->TOKEN
        );
        $data = json_encode($data);
        // Curl request
        $ch                                 = curl_init($this->BASE_URL.'users/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response                           = curl_exec($ch);
        curl_close($ch);
        // Curl end
        $response                           = json_decode($response);
        return redirect()->route('users.index')->withSuccess(__('User updated successfully.'));
    }
    // Delete User
    public function delete(Request $request, $id){
        $headers                            = array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization: Bearer '.$this->TOKEN
        );
        // Curl request
        $ch                                 = curl_init($this->BASE_URL.'users/'.$request->id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $response                           = curl_exec($ch);
        curl_close($ch);
        // Curl end
        return redirect()->route('users.index')->withSuccess(__('User Deleted successfully.'));
    }
}
