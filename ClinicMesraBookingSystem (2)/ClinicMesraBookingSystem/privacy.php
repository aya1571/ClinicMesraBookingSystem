<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Clinic Mesra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .popup-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .popup-header {
            background: linear-gradient(135deg, #27ae60, #1e8449);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .popup-header h3 {
            margin: 0;
            font-weight: bold;
        }
        .popup-header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }
        .popup-body {
            padding: 25px;
            max-height: 500px;
            overflow-y: auto;
        }
        .popup-footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .btn-close-popup {
            background: linear-gradient(135deg, #27ae60, #1e8449);
            border: none;
            padding: 10px 30px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-close-popup:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39,174,96,0.4);
        }
        .section-title {
            color: #2c3e50;
            border-left: 4px solid #27ae60;
            padding-left: 12px;
            margin-top: 20px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        .section-title:first-of-type {
            margin-top: 0;
        }
        .policy-text {
            color: #555;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .badge-date {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        hr {
            margin: 15px 0;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #27ae60;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="popup-container">
        <div class="popup-header">
            <i class="fas fa-shield-alt fa-2x mb-2"></i>
            <h3>Privacy Policy</h3>
            <p>Clinic Mesra Booking System</p>
            <span class="badge-date mt-2">📅 Last updated: April 2026</span>
        </div>
        
        <div class="popup-body">
            <div class="section-title">
                <i class="fas fa-database me-2" style="color:#27ae60;"></i> 1. Information We Collect
            </div>
            <p class="policy-text">We collect personal information including:</p>
            <ul class="policy-text">
                <li>Full name and IC number</li>
                <li>Email address and phone number</li>
                <li>Home address</li>
                <li>Medical history and appointment records</li>
                <li>Payment information</li>
            </ul>
            
            <div class="section-title">
                <i class="fas fa-chart-line me-2" style="color:#27ae60;"></i> 2. How We Use Your Information
            </div>
            <p class="policy-text">Your information is used for:</p>
            <ul class="policy-text">
                <li>Appointment scheduling and management</li>
                <li>Medical records and treatment history</li>
                <li>Clinic communication and reminders</li>
                <li>Billing and payment processing</li>
                <li>Improving our services</li>
            </ul>
            
            <div class="section-title">
                <i class="fas fa-lock me-2" style="color:#27ae60;"></i> 3. Data Protection
            </div>
            <p class="policy-text">We implement appropriate security measures to protect your personal information:</p>
            <ul class="policy-text">
                <li>Secure database storage</li>
                <li>Password encryption</li>
                <li>Role-based access control</li>
                <li>Regular security updates</li>
            </ul>
            
            <div class="section-title">
                <i class="fas fa-share-alt me-2" style="color:#27ae60;"></i> 4. Data Sharing
            </div>
            <p class="policy-text">We do not share your personal information with third parties except:</p>
            <ul class="policy-text">
                <li>When required by law</li>
                <li>With your explicit consent</li>
                <li>For referral to specialist clinics (with your permission)</li>
            </ul>
            
            <div class="section-title">
                <i class="fas fa-gavel me-2" style="color:#27ae60;"></i> 5. Your Rights
            </div>
            <p class="policy-text">Under the Malaysian PDPA 2010, you have the right to:</p>
            <ul class="policy-text">
                <li>Access your personal data</li>
                <li>Correct inaccurate data</li>
                <li>Request deletion of your data</li>
                <li>Withdraw consent for data processing</li>
            </ul>
            
            <div class="section-title">
                <i class="fas fa-clock me-2" style="color:#27ae60;"></i> 6. Data Retention
            </div>
            <p class="policy-text">We retain your personal data for as long as necessary to provide services and comply with legal obligations. Medical records are kept for a minimum of 7 years as required by Malaysian law.</p>
            
            <div class="section-title">
                <i class="fas fa-cookie-bite me-2" style="color:#27ae60;"></i> 7. Cookies
            </div>
            <p class="policy-text">Our website uses cookies to improve user experience. Cookies are small files stored on your device that help us remember your preferences and login status.</p>
            
            <div class="section-title">
                <i class="fas fa-child me-2" style="color:#27ae60;"></i> 8. Children's Privacy
            </div>
            <p class="policy-text">For patients under 18, personal information must be provided by a parent or legal guardian. We do not knowingly collect information from children without parental consent.</p>
            
            <div class="section-title">
                <i class="fas fa-edit me-2" style="color:#27ae60;"></i> 9. Changes to This Policy
            </div>
            <p class="policy-text">We may update this privacy policy from time to time. Any changes will be posted on this page with an updated revision date.</p>
            
            <div class="section-title">
                <i class="fas fa-envelope me-2" style="color:#27ae60;"></i> 10. Contact Us
            </div>
            <p class="policy-text">If you have any questions about this privacy policy or your personal data, please contact us:</p>
            <ul class="policy-text">
                <li>Email: admin@clinicmesra.com</li>
                <li>Phone: 03-1234 5678</li>
                <li>Address: No 123, Jalan Clinic, Taman Kesihatan</li>
            </ul>
            
            <hr>
            
            <div class="alert alert-success text-center" style="font-size: 12px;">
                <i class="fas fa-check-circle me-2"></i>
                This privacy policy complies with the Malaysian Personal Data Protection Act (PDPA) 2010.
            </div>
        </div>
        
        <div class="popup-footer">
            <button onclick="window.close()" class="btn-close-popup">
                <i class="fas fa-check-circle me-2"></i> I Understand
            </button>
        </div>
    </div>
    
    <script>
       
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>