<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Barryvdh\DomPDF\Facade\Pdf;


class PaymentConformationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function build()
{
    $pdf = PDF::loadView('payment.receipt', ['payment' => $this->payment]);

    return $this->subject('Payment Confirmation')
                ->view('emails.payment_conform')  
                ->with([
                    'payment' => $this->payment,
                ])
                ->attachData($pdf->output(), 'receipt.pdf', [
                    'mime' => 'application/pdf',
                ]);
}


}

