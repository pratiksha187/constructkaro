@extends('layouts.app')

@section('title', 'Privacy Policy - Constructkaro')

@section('content')
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">Privacy Policy</h2>

        <p><strong>Effective Date:</strong> 03/09/2025</p>
        <p><strong>Entity:</strong> Swarajya Construction Pvt. Ltd. (operating under the brand “Constructkaro”)</p>
        <p>
            Swarajya Construction Pvt. Ltd. (“Company,” “we,” “our,” or “us”), operating under the brand Constructkaro, 
            respects your privacy and is committed to protecting the personal information of all Users (Customers) 
            and Vendors (Contractors, Architects, Consultants, Interior Designers, Suppliers).
        </p>
        <p>
            This Privacy Policy explains how we collect, use, disclose, and protect your information when you access 
            our website, mobile application, or related services (“Platform” or “Services”).
        </p>

        <hr>

        <h5>1. Information We Collect</h5>
        <p>We may collect and process the following categories of information:</p>
        <p><strong>From Users (Customers):</strong></p>
        <ul>
            <li>Personal details: Name, contact number, email, address.</li>
            <li>Identity verification: Aadhaar, PAN (if required for agreements).</li>
            <li>Project-related details: Land size, project type, uploaded documents, ad postings.</li>
            <li>Payment information: Details for ad postings, premium/custom plans.</li>
        </ul>
        <p><strong>From Vendors:</strong></p>
        <ul>
            <li>Business details: Company profile, office address, GST number, PAN.</li>
            <li>Verification documents: MSME, ESIC, PF, PWD license, certifications, turnover proof.</li>
            <li>Bank account details (for payouts).</li>
            <li>Uploaded technical documents: BOQs, drawings, experience certificates.</li>
        </ul>
        <p><strong>Automatically Collected (Both Users & Vendors):</strong></p>
        <ul>
            <li>Device information: IP address, browser, device type.</li>
            <li>Log data: Actions on platform, date/time, interactions.</li>
            <li>Cookies & analytics data.</li>
        </ul>

        <h5>2. How We Use Your Information</h5>
        <ul>
            <li>To create and manage accounts for users and vendors.</li>
            <li>To verify vendors before listing them.</li>
            <li>To facilitate project postings, vendor bids, and customer-vendor agreements.</li>
            <li>To prepare legally binding e-agreements (via e-sign tools).</li>
            <li>To process secure payments and vendor payouts.</li>
            <li>To monitor quality and safety of projects.</li>
            <li>To communicate important updates and notifications.</li>
            <li>To comply with legal and regulatory obligations.</li>
        </ul>

        <h5>3. Sharing & Disclosure of Information</h5>
        <p>We do not sell or rent personal data. However, information may be shared with:</p>
        <ul>
            <li><strong>Vendors ↔ Customers:</strong> Limited information for project execution.</li>
            <li><strong>Third-Party Service Providers:</strong> Payment gateways, e-signature providers, hosting, analytics, digital marketing partners.</li>
            <li><strong>Regulatory Authorities:</strong> Where required under law or court order.</li>
        </ul>

        <h5>4. Confidentiality Obligations</h5>
        <ul>
            <li>Vendors agree not to bypass Constructkaro by dealing directly with customers outside the platform.</li>
            <li>Customers agree not to bypass Constructkaro by contacting vendors outside the platform once introduced.</li>
            <li>Both parties agree to maintain confidentiality of project details, pricing, and documents.</li>
        </ul>

        <h5>5. Data Security</h5>
        <ul>
            <li>Encryption of sensitive information.</li>
            <li>Access control and limited staff handling.</li>
            <li>Secure servers and PCI-DSS compliant payment gateways.</li>
            <li>Regular security audits and updates.</li>
        </ul>

        <h5>6. Data Retention</h5>
        <ul>
            <li>Data is retained as long as required to provide services or comply with law.</li>
            <li>Vendor and project records are retained for regulatory and compliance purposes.</li>
            <li>Once no longer needed, data is anonymized or securely deleted.</li>
        </ul>

        <h5>7. User Rights</h5>
        <p>You may:</p>
        <ul>
            <li>Access and review your personal information.</li>
            <li>Correct inaccuracies.</li>
            <li>Request deletion (subject to legal retention requirements).</li>
            <li>Withdraw marketing consent at any time.</li>
        </ul>

        <h5>8. Cookies Policy</h5>
        <p>
            Our platform uses cookies for analytics, personalization, and improving user experience. 
            Users may adjust browser settings to block cookies, but some features may not function.
        </p>

        <h5>9. Third-Party Links</h5>
        <p>
            Our platform may contain links to third-party sites. We are not responsible for their privacy practices.
        </p>

        <h5>10. Updates to Policy</h5>
        <p>
            This Privacy Policy may be updated from time to time. Users will be notified of material changes via email/app notifications. 
            Continued use of the platform constitutes acceptance of updates.
        </p>

        <h5>11. Grievance Officer</h5>
        <p><strong>Name:</strong> Mrs. Sheetal Agarwal</p>
        <p><strong>Email:</strong> swarajyaconstruction@outlook.com</p>
        <p><strong>Phone:</strong> 9326216153</p>
        <p><strong>Address:</strong> B- G1, Crescent Pearl, Katrang Road, Khopoli, Tal. Khalapur, Dist. Raigad, 410203</p>
    </div>
</section>

{{-- Security Scripts --}}
<script>
    // Disable right click
    document.addEventListener("contextmenu", function(e){
        e.preventDefault();
    });

    // Disable text selection
    document.addEventListener("selectstart", function(e){
        e.preventDefault();
    });

    // Disable copy
    document.addEventListener("copy", function(e){
        e.preventDefault();
        alert("Copying is disabled on this page.");
    });

    // Block Print Screen key
    document.addEventListener("keydown", function(e) {
        if (e.key === "PrintScreen") {
            navigator.clipboard.writeText('');
            alert("Screenshots are disabled on this page.");
        }
        // Block Ctrl+P (Print)
        if (e.ctrlKey && e.key === "p") {
            e.preventDefault();
            alert("Printing is disabled on this page.");
        }
    });

    // Try to detect screenshot tools (works in some browsers)
    setInterval(() => {
        navigator.clipboard.writeText('');
    }, 300);
</script>

<style>
    /* Prevent user text selection globally */
    body, #policy-content {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide content when trying to print */
    @media print {
        body {
            display: none;
        }
    }
</style>
@endsection
