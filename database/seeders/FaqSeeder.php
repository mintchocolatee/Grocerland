<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'big_title' => 'Ordering Process',
            'subquestions_answers' => [
                ['subquestion' => 'How do I place an order?', 'answer' => 'To place an order, simply browse our product page, add items to your cart, and proceed to checkout.'],
                ['subquestion' => 'Can I modify my order?', 'answer' => 'No, you cannot modify your order once you placed your order.'],
            ],
        ]);

        Faq::create([
            'big_title' => 'Delivery and Shipping',
            'subquestions_answers' => [
                ['subquestion' => 'What are your delivery areas?', 'answer' => 'We deliver to all major cities and towns. '],
                ['subquestion' => 'How much does shipping cost?', 'answer' => 'Shipping costs is RM10 for all the places. We offer free shipping for orders over RM100.'],
            ],
        ]);

        Faq::create([
            'big_title' => 'Payment Information',
            'subquestions_answers' => [
                ['subquestion' => 'What payment methods do you accept?', 'answer' => 'We accept credit cards, debit cards, and PayPal.'],
                ['subquestion' => 'Is it safe to use my credit card on your website?', 'answer' => 'Yes, we use SSL encryption to ensure your payment information is secure.'],
            ],
        ]);

        Faq::create([
            'big_title' => 'Returns and Refunds',
            'subquestions_answers' => [
                ['subquestion' => 'What is your return policy?', 'answer' => 'You can return unopened items within 14 days for a full refund. Perishable items are non-returnable.'],
                ['subquestion' => 'How do I request a refund?', 'answer' => 'To request a refund, contact our customer support with your order details. Refunds are processed within 5-7 business days.'],
            ],
        ]);

        Faq::create([
            'big_title' => 'Account and Security',
            'subquestions_answers' => [
                ['subquestion' => 'How do I create an account?', 'answer' => 'Click on the Sign-Up button and fill out the registration form with your details.'],
                ['subquestion' => 'What should I do if I forget my password?', 'answer' => 'Use the "Forgot Password" link on the login page to reset your password.'],
            ],
        ]);

        Faq::create([
            'big_title' => 'Customer Support',
            'subquestions_answers' => [
                ['subquestion' => 'How can I contact customer support?', 'answer' => 'You can reach us via the email written at the footer of our website, or call us using the phone number.'],
                ['subquestion' => 'What are your customer support hours?', 'answer' => 'Our customer support is available from 9 AM to 6 PM, Monday to Friday.'],
            ],
        ]);

    }
}
