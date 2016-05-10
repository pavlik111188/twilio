<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function setEmail(Request $request) {

        \Session::put('emailN', $request->emailN);
        return redirect('/register');
    }
    public function index()
    {
            //Twilio::message('+18085551212', 'Pink Elephants and Happy Rainbows');
            return view('welcome');

    }


    public function textMess(Request $request) {
        // Get form inputs
        //dd($request);
        //return $request->phoneNumber;
        $number = \Input::get('phoneNumber');
        $message = \Input::get('message');

        // Create an authenticated client for the Twilio API
        $client = new \Services_Twilio('AC64f2f6ac96ea0f89301e484412734402', '5e585186d66b991b694c43017a555192');
        try {
            // Use the Twilio REST API client to send a text message
            $m = $client->account->messages->sendMessage(
                '+15807012741', // the text will be sent from your Twilio number
                '+12015550123', // the phone number the text will be sent to
                'hi' // the body of the text message
            );
        } catch(Services_Twilio_RestException $e) {
            // Return and render the exception object, or handle the error as needed
            return $e;
        };

        // Return the message object to the browser as JSON
        return $m;
    }

    public function isValidNumber($number) {
        $sid = $_ENV['TWILIO_ACCOUNT_SID'];
        $token = $_ENV['TWILIO_AUTH_TOKEN'];
        $client = new \Lookups_Services_Twilio($sid, $token);
            //$number = $client->phone_numbers->get($number, array("CountryCode" => "US", "Type" => "carrier"));
        try {
            $number = $client->phone_numbers->get($number, array("CountryCode" => "US", "Type" => "carrier"));
            return $number->phone_number;
        } catch ( \Services_Twilio_RestException $e ) {
            //elog( 'EACT', $e->getMessage(  ) , __FUNCTION__ );
            return false;
        }
    }

    public function checkNumber(Request $request)
    {
        //return $this->isValidNumber($request->phone);
        if ($this->isValidNumber($request->phone)) {
            return $this->isValidNumber($request->phone);
        } else {
            echo "Phone number is not valid";
        }
        /*$sid = $_ENV['TWILIO_ACCOUNT_SID'];
        $token = $_ENV['TWILIO_AUTH_TOKEN'];
        $client = new \Lookups_Services_Twilio($sid, $token);
        try {
            $number = $client->phone_numbers->get($request->phone, array("CountryCode" => "US", "Type" => "carrier"));
            //$number->carrier->type;
            dd($number);
            return "Phone number: ". $number->phone_number ."<br /> Type: ".$number->carrier->type . "<br /> Operator: ".$number->carrier->name;
        }
        catch (Exception $e) {
            if($e->getStatus() == 404) {
                return false;
            } else {
                throw $e;
            }
        }*/
        //$number = $client->phone_numbers->get($request->phone, array("CountryCode" => "US", "Type" => "carrier"));
        //return "Phone number: ". $number->phone_number ."<br /> Type: ".$number->carrier->type . "<br /> Operator: ".$number->carrier->name; // => Sprint Spectrum, L.P.
    }
    public function render($request, \Exception $e)
    {
        if ($e instanceof \ForbiddenException) {
            return redirect()->route('home')->withErrors(['error' => $e->getMessage()]);
        }

        return parent::render($request, $e);
    }
}