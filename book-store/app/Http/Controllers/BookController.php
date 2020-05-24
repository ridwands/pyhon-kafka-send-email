<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index(){
        $product = DB::table('products')->get();

        return view ('welcome', ['product' => $product]);
    }

    public function register(Request $request) {
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = Hash::make($request->input('password'));

            $check_email = DB::table('users')->where('email', $email)->count();
            if ($check_email == 0){
                $register = DB::table('users')->insert(
                    ['email' => $email, 'password' => $password]
                );
                if ($register){
                    return redirect('login')->with('status', 'Successfully Registration');
                }
            }else{
                return redirect('register')->with('status', 'Email Already in Use');
            }
        }
        return view ('register');
    }
    public function login(Request $request) {
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = $request->input('password');

            $check_email = DB::table('users')->where('email', $email)->first();
            if (!empty($check_email)){
                    $check_password=Hash::check($password, $check_email->password);
                    if ($check_password == 1){
                        $request->session()->put('email', $email);
                        return redirect('/');
                    }else{
                        return redirect('/login')->with('status', 'Email or Password is Wrong');
                    }
            }else{
                return redirect('/login')->with('status', 'Email or Password is Wrong');
            }
        }
        return view ('login');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect ('/');
    }

    public function payment(Request $request) {
        $price = $request->input('price').'.0';
        $amount = $request->input('amount');
        $book_name = $request->input('book_name');

        $response = Http::post(env('KAFKA_PUBLISHER', 'http://localhost:5001/').'/payment',[
            'email' => $request->session()->get('email'),
            'book_name' => $book_name,
            'price' => $price,
            'amount' => $amount
        ]);

        return redirect('/')->with('status', 'Check Your Email For Payment Detail');

    }
}
