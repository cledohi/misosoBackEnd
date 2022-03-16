<?php 
namespace App\Controllers;
use PDO;
use Exception;
class StripeController
{
public function stripepay($request, $response, $args){
	 try {
$input = json_decode($request->getBody());
$token=$input->token;
$email=$input->email;
$data=$input->data;
// parse attributes from JSON
$receiptEmail = $data['receiptEmail'];
$amount = $data['amount'];
  
$customer = \Stripe\Customer::create([
    'email' => $email,
    'source'  => $token,
]);
    // create the charge
    $charge = \Stripe\Charge::create([
      'amount' => $amount,
      'currency' => 'aud',
      'source' => 'tok_visa',
      'receipt_email' => $receiptEmail
    ]);

   
  } catch (Exception $e) {
   
  }
return "hello";
}

}
?>