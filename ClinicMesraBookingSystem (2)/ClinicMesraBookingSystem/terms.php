<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - Clinic Mesra</title>
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
            background: linear-gradient(135deg, #3498db, #2980b9);
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
            background: linear-gradient(135deg, #3498db, #2980b9);
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
            box-shadow: 0 5px 15px rgba(52,152,219,0.4);
        }
        .section-title {
            color: #2c3e50;
            border-left: 4px solid #3498db;
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
            background: #e9ecef;
            color: #6c757d;
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
            background: #3498db;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="popup-container">
        <div class="popup-header">
            <i class="fas fa-file-contract fa-2x mb-2"></i>
            <h3>Terms & Conditions</h3>
            <p>Clinic Mesra Booking System</p>
            <span class="badge-date mt-2">📅 Last updated: April 2026</span>
        </div>
        
        <div class="popup-body">
            <div class="section-title">
                <i class="fas fa-calendar-check me-2" style="color:#3498db;"></i> 1. Appointment Booking
            </div>
            <p class="policy-text">1.1 Patients must arrive at least <strong>15 minutes</strong> before their scheduled appointment time.</p>
            <p class="policy-text">1.2 Late arrivals may result in rescheduling or waiting for the next available slot.</p>
            <p class="policy-text">1.3 Cancellations must be made at least <strong>2 hours</strong> in advance.</p>
            <p class="policy-text">1.4 Failure to show up for an appointment (no-show) will be recorded in the system.</p>
            <p class="policy-text">1.5 Three (3) no-shows within 6 months may result in temporary suspension of online booking privileges.</p>
            
            <div class="section-title">
                <i class="fas fa-notes-medical me-2" style="color:#3498db;"></i> 2. Medical Records
            </div>
            <p class="policy-text">2.1 All medical information provided by patients is strictly confidential.</p>
            <p class="policy-text">2.2 Patient data will not be shared with any third parties without consent.</p>
            <p class="policy-text">2.3 Patients are responsible for providing accurate and complete medical history.</p>
            <p class="policy-text">2.4 The clinic reserves the right to request additional medical information when necessary.</p>
            
            <div class="section-title">
                <i class="fas fa-money-bill-wave me-2" style="color:#3498db;"></i> 3. Payment Terms
            </div>
            <p class="policy-text">3.1 Consultation fees must be paid before or immediately after the appointment.</p>
            <p class="policy-text">3.2 Accepted payment methods: Cash, Credit Card, Debit Card, and E-Wallet (Touch n Go, GrabPay).</p>
            <p class="policy-text">3.3 Receipts will be provided for all payments made.</p>
            <p class="policy-text">3.4 Late cancellation fee: <strong class="text-danger">RM10</strong> (less than 2 hours notice).</p>
            <p class="policy-text">3.5 No-show fee: <strong class="text-danger">RM20</strong> (will be charged to patient's account).</p>
            
            <div class="section-title">
                <i class="fas fa-ban me-2" style="color:#3498db;"></i> 4. Cancellation Policy
            </div>
            <p class="policy-text">4.1 To cancel an appointment, log in to your account and go to "My Appointments".</p>
            <p class="policy-text">4.2 Click the "Cancel" button next to the appointment you wish to cancel.</p>
            <p class="policy-text">4.3 Cancellations made at least 2 hours before appointment: <strong class="text-success">No fee</strong>.</p>
            <p class="policy-text">4.4 Cancellations made less than 2 hours before appointment: <strong class="text-danger">RM10 fee</strong>.</p>
            <p class="policy-text">4.5 No-shows (did not cancel and did not attend): <strong class="text-danger">RM20 fee</strong>.</p>
            
            <div class="section-title">
                <i class="fas fa-hospital-user me-2" style="color:#3498db;"></i> 5. Clinic Policies
            </div>
            <p class="policy-text">5.1 Patients must follow all clinic safety protocols and instructions from staff.</p>
            <p class="policy-text">5.2 The clinic reserves the right to reschedule appointments due to emergencies or doctor unavailability.</p>
            <p class="policy-text">5.3 Patients will be notified of any rescheduling via email or phone.</p>
            <p class="policy-text">5.4 Disruptive or aggressive behavior may result in being banned from the clinic.</p>
            <p class="policy-text">5.5 Children under 12 must be accompanied by a parent or guardian.</p>
            
            <div class="section-title">
                <i class="fas fa-shield-alt me-2" style="color:#3498db;"></i> 6. Data Privacy (PDPA Compliance)
            </div>
            <p class="policy-text">6.1 Personal data is collected and processed in accordance with Malaysian <strong>Personal Data Protection Act (PDPA) 2010</strong>.</p>
            <p class="policy-text">6.2 Patient data is used only for appointment management and medical purposes.</p>
            <p class="policy-text">6.3 Data is stored securely and accessible only by authorized clinic staff.</p>
            <p class="policy-text">6.4 Patients have the right to request access to or correction of their personal data.</p>
            <p class="policy-text">6.5 For data inquiries, please contact the clinic administrator.</p>
            
            <div class="section-title">
                <i class="fas fa-desktop me-2" style="color:#3498db;"></i> 7. System Usage
            </div>
            <p class="policy-text">7.1 Patients are responsible for keeping their login credentials secure.</p>
            <p class="policy-text">7.2 Do not share your account with others.</p>
            <p class="policy-text">7.3 The system is for legitimate appointment booking purposes only.</p>
            <p class="policy-text">7.4 Abuse of the system (e.g., fake bookings) may result in account suspension.</p>
            <p class="policy-text">7.5 The clinic reserves the right to modify these terms at any time.</p>
            
            <div class="section-title">
                <i class="fas fa-exclamation-triangle me-2" style="color:#3498db;"></i> 8. Limitation of Liability
            </div>
            <p class="policy-text">8.1 The clinic is not responsible for technical issues beyond its control.</p>
            <p class="policy-text">8.2 Patients are advised to confirm their appointment status before coming to the clinic.</p>
            <p class="policy-text">8.3 The clinic does not guarantee immediate treatment for emergency cases through this system.</p>
            <p class="policy-text">8.4 For emergencies, please call 999 or go to the nearest hospital.</p>
            
            <hr>
            
            <div class="alert alert-info text-center" style="font-size: 12px;">
                <i class="fas fa-info-circle me-2"></i>
                By using this system, you acknowledge that you have read, understood, and agree to all terms and conditions stated above.
            </div>
            
            <p class="text-muted text-center mt-2" style="font-size: 10px;">
                <i class="fas fa-map-marker-alt me-1"></i> Clinic Mesra, No 123, Jalan Clinic, Taman Kesihatan<br>
                <i class="fas fa-phone me-1"></i> 03-1234 5678 | <i class="fas fa-envelope me-1"></i> admin@clinicmesra.com
            </p>
        </div>
        
        <div class="popup-footer">
            <button onclick="window.close()" class="btn-close-popup">
                <i class="fas fa-check-circle me-2"></i> I Understand
            </button>
        </div>
    </div>
    
    <script>
        // Close popup when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>