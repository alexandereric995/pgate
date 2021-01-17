<?php
// # GetPaymentSample
// Edit By Alexander Eric
// payments list retriever
// API used: Mdec 3d game engine api payment v1

$createdPayment = require __DIR__ . '/CreatePaymentUsinggetpay.php';
/** @var Payment $createdPayment */

use get\Api\Payment;

// ### Retrieve payment
// Retrieve the payment object by calling the
// static `get` method
// Payment ID
try {
    $payment = Payment::get($createdPayment->getId(), $apiContext);
} catch (Exception $ex) {
    // Payment Gateway for MDEC 3D GAME ENGINE
    ResultPrinter::printError("Dapatkan Bayaran", "Bayaran", null, null, $ex);
    exit(1);
}

// NOTE: Payment Gateway for MDEC 3D GAME ENGINE
 ResultPrinter::printResult("Dapatkan Bayaran", "Bayaran", $payment->getId(), null, $payment);

return $payment;
