<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdminOrAuthor');
         return User::latest()->paginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request,[
            'name'=>'required|string|max:255|min:4',
            'email'=>'required|string|max:255|email|unique:users',
            'password'=>'required|string|min:8',
            'type'=>'required',
            'bio'=>'required|string|max:255',
        ]);

        return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'type'=>$request['type'],
            'bio'=>$request['bio'],
            //'photo'=>$request['photo'],
            'password'=>Hash::make($request['password']) ,
        ]);
    }


    public function show($id)
    {
        //
    }

     public function profile()
        {
            return auth('api')->user();
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
        $this->authorize('isAdmin');
        $user=User::findOrFail($id);
        $this->validate($request,[
            'name'=>'required|string|max:255|min:4',
            'email'=>'required|string|max:255|email|unique:users,email,'.$user->id,
            'password'=>'sometimes|string|min:8',
            'type'=>'required',
            'bio'=>'required|string|max:255',
        ]);
        $user->update($request->all());
        return ['message' =>'updated the user info'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user=User::findOrFail($id);

        $user->delete();
        return ['message'=>'User Deleteeeed'];
    }
}
