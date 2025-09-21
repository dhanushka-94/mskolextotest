@extends('layouts.app')

@section('title', 'Terms of Service - MSK Computers')

@section('content')
<div class="min-h-screen bg-dark-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">Terms of Service</h1>
            <p class="text-gray-400 text-lg">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-gradient-to-br from-[#1a1a1c] to-[#2a2a2c] rounded-xl border border-gray-800 p-8">
            <div class="prose prose-invert max-w-none">
                
                <h2 class="text-2xl font-semibold text-white mb-4">1. Acceptance of Terms</h2>
                <p class="text-gray-300 mb-6">
                    By accessing and using the MSK Computers website and services, you accept and agree to be bound by these Terms of Service. 
                    If you do not agree to these terms, please do not use our services.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">2. About MSK Computers</h2>
                <p class="text-gray-300 mb-6">
                    MSK Computers is a technology retailer specializing in computers, laptops, peripherals, and IT services. We are committed to 
                    providing quality products and exceptional customer service to individuals and businesses in Sri Lanka.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">3. Products and Services</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">3.1 Product Information</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>We strive to provide accurate product descriptions, specifications, and pricing</li>
                        <li>Product images are for illustration purposes and may vary from actual products</li>
                        <li>All prices are in Sri Lankan Rupees (LKR) unless otherwise stated</li>
                        <li>Prices and availability are subject to change without notice</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">3.2 Product Availability</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>All products are subject to availability</li>
                        <li>We reserve the right to limit quantities or discontinue products</li>
                        <li>In case of unavailability, we will notify you and offer alternatives or refunds</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">4. Ordering and Payment</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">4.1 Order Process</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>Orders are confirmed upon receipt of payment</li>
                        <li>You will receive an order confirmation via email or SMS</li>
                        <li>We reserve the right to cancel orders for any reason</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">4.2 Payment Methods</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>WebXPay - Secure online payment gateway (Credit/Debit Cards, Online Banking, Mobile Wallets)</li>
                        <li>Bank Transfer - Direct bank transfer to our designated account</li>
                        <li>All payments must be received before product dispatch</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">4.3 Pricing and Taxes</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>All prices include applicable taxes unless otherwise stated</li>
                        <li>Additional charges may apply for delivery and handling</li>
                        <li>We reserve the right to adjust prices due to tax changes or errors</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">5. Shipping and Delivery</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">5.1 Delivery Areas</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>We deliver throughout Sri Lanka</li>
                        <li>Delivery times may vary based on location and product availability</li>
                        <li>Remote areas may have additional delivery charges</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">5.2 Delivery Process</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>You will receive SMS notifications about order status and delivery</li>
                        <li>Someone must be available to receive the delivery</li>
                        <li>Products must be inspected upon delivery</li>
                        <li>Any damage or discrepancies must be reported immediately</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">6. Returns and Refunds</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">6.1 Return Policy</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>Returns are accepted within 7 days of delivery for defective products</li>
                        <li>Products must be in original condition with all accessories and packaging</li>
                        <li>Custom-built systems and software are non-returnable unless defective</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">6.2 Refund Process</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Refunds will be processed within 7-14 business days</li>
                        <li>Refunds will be made to the original payment method</li>
                        <li>Shipping charges are non-refundable unless the return is due to our error</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">7. Warranties</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">7.1 Manufacturer Warranties</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>All products come with manufacturer's warranty as specified</li>
                        <li>Warranty terms vary by product and manufacturer</li>
                        <li>Warranty claims must be processed through authorized service centers</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">7.2 Service Warranty</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Our services come with a 30-day satisfaction guarantee</li>
                        <li>We will rectify any service-related issues at no additional cost</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">8. User Accounts and Security</h2>
                <div class="text-gray-300 mb-6">
                    <h3 class="text-lg font-medium text-white mb-2">8.1 Account Registration</h3>
                    <ul class="list-disc list-inside space-y-2 mb-4">
                        <li>You may create an account to access additional features</li>
                        <li>You are responsible for maintaining account security</li>
                        <li>You must provide accurate and current information</li>
                    </ul>

                    <h3 class="text-lg font-medium text-white mb-2">8.2 Prohibited Activities</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Using our services for illegal activities</li>
                        <li>Attempting to hack, disrupt, or damage our systems</li>
                        <li>Providing false information or impersonating others</li>
                        <li>Violating intellectual property rights</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">9. Intellectual Property</h2>
                <p class="text-gray-300 mb-6">
                    All content on this website, including text, graphics, logos, images, and software, is the property of MSK Computers or 
                    its licensors and is protected by copyright and other intellectual property laws. You may not use, reproduce, or 
                    distribute any content without our written permission.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">10. Privacy and Data Protection</h2>
                <p class="text-gray-300 mb-6">
                    Your privacy is important to us. Our collection and use of personal information is governed by our 
                    <a href="{{ route('privacy-policy') }}" class="text-primary-400 hover:text-primary-300 underline">Privacy Policy</a>, 
                    which forms part of these Terms of Service.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">11. Limitation of Liability</h2>
                <div class="text-gray-300 mb-6">
                    <p class="mb-4">
                        To the fullest extent permitted by law, MSK Computers shall not be liable for any indirect, incidental, 
                        special, consequential, or punitive damages, including but not limited to:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Loss of profits, data, or business opportunities</li>
                        <li>Interruption of business operations</li>
                        <li>Cost of substitute products or services</li>
                        <li>Any damages arising from product defects beyond our control</li>
                    </ul>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-4">12. Force Majeure</h2>
                <p class="text-gray-300 mb-6">
                    We shall not be liable for any failure or delay in performance due to events beyond our reasonable control, 
                    including but not limited to acts of God, natural disasters, war, terrorism, government actions, strikes, 
                    or supplier failures.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">13. Governing Law</h2>
                <p class="text-gray-300 mb-6">
                    These Terms of Service are governed by the laws of Sri Lanka. Any disputes arising from these terms or 
                    your use of our services shall be subject to the exclusive jurisdiction of the courts of Sri Lanka.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">14. Changes to Terms</h2>
                <p class="text-gray-300 mb-6">
                    We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately 
                    upon posting on our website. Your continued use of our services after any changes constitutes acceptance 
                    of the new terms.
                </p>

                <h2 class="text-2xl font-semibold text-white mb-4">15. Contact Information</h2>
                <div class="text-gray-300 mb-6">
                    <p class="mb-4">If you have any questions about these Terms of Service, please contact us:</p>
                    <div class="bg-dark-800 rounded-lg p-4">
                        <p class="font-medium text-white mb-2">MSK Computers</p>
                        <p>Email: <a href="mailto:info@mskcomputers.lk" class="text-primary-400 hover:text-primary-300">info@mskcomputers.lk</a></p>
                        <p>Phone: <a href="tel:+94112345678" class="text-primary-400 hover:text-primary-300">+94 11 234 5678</a></p>
                        <p>Website: <a href="{{ url('/') }}" class="text-primary-400 hover:text-primary-300">{{ url('/') }}</a></p>
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-6">
                    <p class="text-sm text-gray-400 text-center">
                        By using MSK Computers services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
