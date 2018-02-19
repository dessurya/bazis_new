<?php

namespace App\Http\Controllers\AdminPortal;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserLog;

use Auth;
use Hash;
use DB;
use Mail;
use Validator;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use LogUserRecord;

class UserController extends Controller
{
	public function index(){
    	$me = User::find(Auth::user()->id);

    	$getUsers = User::get();
        return view('admin-portal.account.index', compact(
        	'me',
        	'getUsers'
        ));
  }

  public function loguser(){
      $get = UserLog::orderBy('id', 'desc')->get();
        return view('admin-portal.account.logs', compact(
          'get'
        ));
  }

  public function add(request $request){
    $message = [
        'name.required' => 'Wajib di isi',
        'email.required' => 'Wajib di isi',
        'email.email' => 'Format email',
        'email.unique' => 'Email sudah dipakai',
      ];

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:zisju_users,email'
      ], $message);

      if($validator->fails()){
        return redirect()->route('adpor.user.index')->withErrors($validator)->withInput();
      }

    DB::transaction(function() use($request){
      $confirmation_code = str_random(30).time();
      
      $user = new User;
      $user->name = $request->name;
      $user->email = $request->email;
      $user->login_count = 0;
      $user->password = Hash::make('134z15-jakut');
      $user->confirmation_code = $confirmation_code;
      $user->save();

      LogUserRecord::userAdd($user);

      // $data = array([
      //  'name' => $request->name,
      //  'email' => $request->email,
      //  'confirmation_code' => $confirmation_code
      // ]);

      // Mail::send('backend.email.confirm', ['data' => $data], function($message) use ($data) {
      // $message->to($data[0]['email'], $data[0]['name'])->subject('Aktifasi Akun CMS Gofress');
      // });
    });

    return redirect()->route('adpor.user.index')->with('berhasil', $request->name.' success to add');
  }

  public function update(request $request){
  	$message = [
      'me_name.required' => 'Wajib di isi',
      'me_email.required' => 'Wajib di isi',
      'me_email.email' => 'Format email',
      'old_password.required' => "This field is required",
      'new_password.required' => "This field is required",
      'new_password.min' => "Too Short",
    ];

    $validator = Validator::make($request->all(), [
      'me_name' => 'required',
      'me_email' => 'required|email',
      'old_password' => 'required',
      'new_password' => 'required|min:8',
    ], $message);

    if($validator->fails())
    {
      return redirect()->route('adpor.user.index')->withErrors($validator)->withInput();
    }

  	$me = User::find(Auth::user()->id);

    if(Hash::check($request->old_password, $me->password)){
      $me->password = Hash::make($request->new_password);
      $me->name = $request->me_name;
      $me->email = $request->me_email;
      $me->save();

      return redirect()->route('adpor.user.index')->with('berhasil', 'Your account has been changed');
    }
    else{
      return redirect()->route('adpor.user.index')->withInput()->with('errors_oldpass', 'Wrong Password!	');
    }
  }

  public function status($id){
    try {
      $id = Crypt::decrypt($id);
    } 
    catch (DecryptException $e) {
      return view('errors.404');
    }

    if (Auth::user()->id == $id) {
      return redirect()->route('adpor.user.index')->with('berhasil', 'Error! Cant change self status');
    }
    $find = User::find($id);
  	if ($find->confirmed == 'N') {
			$find->confirmed = 'Y';
		}
		else if ($find->confirmed == 'Y') {
			$find->confirmed = 'N';
		}
		$find->save();
    LogUserRecord::userChangeStatus($find);

		return redirect()->route('adpor.user.index')->with('berhasil', $find->name.' success to change status');
  }

  public function resetPassword($id){
    try {
      $id = Crypt::decrypt($id);
    } 
    catch (DecryptException $e) {
      return view('errors.404');
    }

  	if (Auth::user()->id == $id) {
  		return redirect()->route('adpor.user.index')->with('berhasil', 'Error! Cant reset self password');
  	}
  	$find = User::find($id);
		$find->password = Hash::make('134z15-jakut');
		$find->save();
    LogUserRecord::userResetPassword($find);

		return redirect()->route('adpor.user.index')->with('berhasil', $find->name.' success to reset password');
  }

  public function delete($id){
    try {
      $id = Crypt::decrypt($id);
    } 
    catch (DecryptException $e) {
      return view('errors.404');
    }

  	if (Auth::user()->id == $id) {
  		return redirect()->route('adpor.user.index')->with('berhasil', 'Error! Cant reset self password');
  	}

  	$find = User::find($id);

		$result = DB::transaction(function() use($find){
      $tryDel = true;
      try {
        $find->delete();
        if($find->avatar != 'users.png'){
          File::delete('asset/picture/admin-portal/user/'.$find->avatar);
        }
      } 
      catch (QueryException $e) {
        $tryDel = false;
      }
      return $tryDel;
		});

    if($result == true){
      LogUserRecord::userDelete($find);
      return redirect()->route('adpor.user.index')
        ->with('berhasil', 'Berhasil Menghapus '.$find->name);
    }
    else{
      return view('errors.404');
    }
  }
}
