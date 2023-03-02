<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentMethods;
use App\Models\MembershipPaymentsData;
use App\Mail\HostRegisterMail;
use App\Models\Discounts\AdminDiscount;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use DB;


class AuthenticationController extends Controller
{
    public function login(){
        return view('Authentications.login');
    }
    public function register(){
        return view('Authentications.register');
    }
    public function loginProcess(request $req){
      
        $email = $req->email;
        $password = $req->password;
        $credentials = array('email'=>$email, 'password' => $password);
        if (Auth::attempt($credentials)) {
            if(auth()->user()->status == 0){
                return redirect('/');
            }
            else if(auth()->user()->status == 1){
                return redirect('/'.auth()->user()->unique_id);
            }
            else if(auth()->user()->status == 2){
                return redirect('admin/dashboard');
            }else{
                return false;
            }
        }else{
            return 'there is an error';
        }
    }
    public function registerProcess(request $req){
        // dd($req);
        $validate = $req->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'unique_id' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password'=>'required|min:6',
            ],[
                'first_name.required' => 'First name is required',
                'last_name.required' => 'Last Name is required',
                'unique_id.required' => 'Stream Lode page name is required',
                'unique_id.unique' => 'This name is already taken please choose another',
                'email.required' => 'Email is required',
                'email.unique' => 'This email is already taken please choose another',
                'password' => 'Password must be required',
            ]);
               
            if(empty($validate['errors'])){
                $password = Hash::make($req->password);

                // 1st step of registration 
                $data = array(
                    'first_name' => $req->first_name,
                    'last_name' => $req->last_name,
                    'email' => $req->email,
                    'unique_id' => $req->unique_id,
                    'public_visibility' => 1,
                    'password' => $password,
                    'status' => 1 // user status 0 = guest ; 1 = host ; 2 = admin
                );
                $user = User::create($data);
                $user_id = $user->_id;
                $user_email = $user->email;
                $name = $req->first_name . " " . $req->last_name;

                $createSubscription = '';
                if(!empty($user_id)){
                    $createSubscription = $this->createSubscription($user_id,$req->membership_id,$name,$req->email,$req->token,$req->coupon_code);
                    return redirect('registration-status')->with(['paymentStatus'=> $createSubscription[0]['paymentStatus'], 'message'=>$createSubscription[0]['response'],'membership_id' => $createSubscription[0]['membership_id']]);
                }else{
                    return redirect()->back()->with('error','Sorry error in registration process please try again.');
                }
            }
            return redirect('membership');
    }
    public function createSubscription($user_id,$membership_id ,$name,$email,$token,$coupon_code){
       
        try{
            // $current = Carbon::now()->format('Y,m,d');
            $stripe_coupon_id = '';
            if($coupon_code != null){
                $stripe_coupon_id = AdminDiscount::where('coupon_code',$coupon_code)->get()->value('stripe_coupon_id');
            }
            // dd($stripe_coupon_id);
          $membership = DB::table('membership')->find($membership_id) ;
          
          $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
  
          #################### Create customer ##########################
  
          $customer =  $stripe->customers->create([
             'name' => $name,
             'email' => $email,
             'payment_method' => $token,
             'invoice_settings' => [
              'default_payment_method' => $token,
             ],
             'address' => [
               'line1' => '510 Townsend St',
               'postal_code' => '98140',
               'city' => 'San Francisco',
               'state' => 'CA',
               'country' => 'US',
             ],
            ]);
            
          //   #################### Attach payments method with customer ##########################
  
          $paymentMethodAttachStatus = $stripe->paymentMethods->attach(
              $token,
              ['customer' => $customer->id]
          );
  
          //  #################### Create subscription ##########################
  
        //   $createMembership =  $stripe->subscriptions->create([
        //       'customer' => $customer->id,
        //       'items' => [
        //         ['price' => $membership['price_id']],
        //       ],
        //       'coupon' => $stripe_coupon_id,
        //     //   'collection_method' => 'charge_automatically',
        //     ]);
        $createMembership = '';
            if($coupon_code != null){
                $createMembership =  $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => [
                      ['price' => $membership['price_id']],
                    ],
                    'coupon' => $stripe_coupon_id,
                ]);
            }else{
                $createMembership =  $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => [
                      ['price' => $membership['price_id']],
                    ]
                ]);
            }
  
            // dd($createMembership);
            $invoice = $createMembership->latest_invoice;
            $payment_intent = '';
            $host_inovice_url = '';
            $host_invoice_pdf = '';
            $subtotal = '';
            $discount = '';
            $total_excluding_discount = '';
            if(!empty($invoice)){
                $invoice_details =  $this->getInvoice($invoice);
                $subtotal = (int)$invoice_details->subtotal / 100;
                $total_excluding_discount = (int)$invoice_details->total /100 ;
                $payment_intent = $invoice_details->payment_intent;
                $host_inovice_url = $invoice_details->hosted_invoice_url;
                $host_invoice_pdf = $invoice_details->invoice_pdf;
                if($coupon_code != null){
                    $discount = (int)$invoice_details->total_discount_amounts[0]->amount / 100;
                }
                // send mail for user's email to get activation and payment done

                $mail = Mail::to($email)->send(new HostRegisterMail($name, $host_inovice_url , $host_invoice_pdf));
                // dd($mail);
            }

                // ######################### payment table data save  #######################################
  
            $payementMethods = new PaymentMethods;
            $payementMethods->user_id = $user_id;
            $payementMethods->stripe_payment_method = $token;  
            $payementMethods->brand = $paymentMethodAttachStatus->card->brand;
            $payementMethods->last_4 = $paymentMethodAttachStatus->card->last4;
            $payementMethods->expire_month = $paymentMethodAttachStatus->card->exp_month;
            $payementMethods->expire_year = $paymentMethodAttachStatus->card->exp_year;
            $payementMethods->save();

            // ######################## Store data in membership payment table ###############################
  
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
            $random_order_number = substr(str_shuffle($str_result),0,7);
  
            $membership_payment = new MembershipPaymentsData;
            $membership_payment->user_id = $user_id;
            $membership_payment->inovice_id = $createMembership->latest_invoice;
            $membership_payment->stripe_payment_intent = $payment_intent;
            $membership_payment->stripe_payment_method = $token; 
            $membership_payment->payment_method_id = $payementMethods->id;
            $membership_payment->order_id = $random_order_number;
            $membership_payment->membership_id = $membership_id;
            $membership_payment->membership_total_amount = $createMembership->plan->amount / 100;
            // prices starts
            $membership_payment->discount_coupon_name = $coupon_code;
            $membership_payment->subtotal = $subtotal;
            $membership_payment->discount_amount = $discount ;
            $membership_payment->total = $total_excluding_discount ;// while we use discount then we fix this and diff beteween unused time charge and new charge from invoice 
            // prices end
            $membership_payment->payment_status = $createMembership->status;
            $membership_payment->save();
  
          // ###################### Send Invoice ##################################

          $user = User::find($user_id);
          $user->stripe_customer_id = $customer->id;
          $user->subscription_id = $createMembership->id;
       
      
            // dd($createMembership);
            
            if($createMembership->status != 'incomplete'){
                $user->membership_id = $membership_id;
                $user->active_status = 1;
                $user->save();
                return array(['paymentStatus'=>TRUE,'response'=>'Congratulations you got ' . $membership['name'] . ' for a ' . $membership['interval'],'membership_id'=> $membership_id]);
            }else{
                $user->active_status = 0;
                $user->membership_id = null;
            }
          $user->save();
          return array(['paymentStatus'=> FALSE, 'response'=>'You are registered but for payment you will get invoice in your registered email ('.$email.') please pay from there and activate your subscription.','membership_id'=> $membership_id]);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function getInvoice($invoice_number){
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $invoice = $stripe->invoices->retrieve(
         $invoice_number,
          []
        );
        return $invoice;
    }
    // public function confirmPayment($payment_intent){
    //     $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
    //       $payment_response = $stripe->paymentIntents->confirm(
    //         $payment_intent,
    //         ['payment_method' => 'pm_card_visa']
    //       );
    //     return $payment_response;
    // }
    public function paymentStatus(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
         $payment_status =  $stripe->paymentIntents->retrieve(
            'pi_3MeHOcSDpE15tSXh1KJcOnmk',
            []
          );
          dd($payment_status);
        
    }

    public function updatePassword(Request $req){
        $req->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required_with:new_password|same:new_password|'
            ],[
                'current_password.required' => 'Your current password must be required',
                'new_password.required' => 'Your new password must be required',
                'new_password.min:6' => 'Your new password must be atleast 6 character',
                'confirm_new_password.required' => 'Your confirm new password must be required',
                'confirm_new_password.same:new_password' => 'Your confirm new password must be same as new password'
            ] 
        );
        $matchPassword=  Hash::check($req->current_password, auth()->user()->password);
        if($matchPassword == true){
            $password_change_status = User::find(auth()->user()->id)->update(['password'=> Hash::make($req->confirm_new_password)]);
            if($password_change_status == true){
                // logout from other session remain
                return redirect('/'.auth()->user()->unique_id.'/change-password')->with('success','Your password is changed succesfully.');
            }
        }else{
            return redirect('/'.auth()->user()->unique_id.'/change-password')->with('error','Your old password is not matched.');
        }
    }
    public function logout(){
    Auth::logout();
    return redirect('/')->with('success',"You have logged out succesfully");
    }
}
