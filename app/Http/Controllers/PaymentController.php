<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function submit(Request $request, $courseId)
    {
        $user = auth()->user();
        $baserow = new \App\Services\BaserowService();

        $data = [
            'User ID' => $user->id,
            'Course ID' => $courseId,
            'User Email' => $user->email,
            'Course Title' => $request->input('course_title'),
            'Price' => $request->input('price'),
            'Payment Method' => $request->input('payment_method'),
            'Sender Number' => $request->input('sender_number'),
            'Transaction ID' => $request->input('transaction_id'),
            'Status' => 'Pending',
            'Submission Time' => now()->toDateTimeString(),
        ];

        $baserow->create('payments', $data); // Use your own insert method

        return redirect()->back()->with('success', 'Payment submitted! You will get access after admin approval.');
    }
}
