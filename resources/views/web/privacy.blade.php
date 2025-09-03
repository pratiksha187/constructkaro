@extends('layouts.app')

@section('title', 'Privacy Policy - Constructkaro')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color:#1c2c3e;">Privacy Policy</h2>
            <p class="text-muted">Effective Date: 03/09/2025</p>
            <p class="fw-semibold" style="color:#f25c05;">
                Swarajya Construction Pvt. Ltd. (operating under the brand “Constructkaro”)
            </p>
        </div>

        <!-- Intro -->
        <div class="mb-4">
            <p>
                Swarajya Construction Pvt. Ltd. (“Company,” “we,” “our,” or “us”), operating under the brand Constructkaro, 
                respects your privacy and is committed to protecting the personal information of all Users (Customers) and 
                Vendors (Contractors, Architects, Consultants, Interior Designers, Suppliers).
            </p>
            <p>
                This Privacy Policy explains how we collect, use, disclose, and protect your information when you access 
                our website, mobile application, or related services (“Platform” or “Services”).
            </p>
        </div>

        <hr class="mb-4">

        <!-- Sections -->
        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">1. Information We Collect</h5>
            <p>We may collect and process the following categories of information:</p>
            <ul>
                <li><strong>From Users (Customers):</strong> Name, contact number, email, address, Aadhaar/PAN (if required), project details, payments.</li>
                <li><strong>From Vendors:</strong> Business details, GST/PAN, verification documents, bank details, technical documents.</li>
                <li><strong>Automatically (Both Users & Vendors):</strong> IP, device, browser, log data, cookies, analytics.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">2. How We Use Your Information</h5>
            <ul>
                <li>To create and manage accounts.</li>
                <li>To verify vendors before listing.</li>
                <li>To facilitate project postings and agreements.</li>
                <li>To prepare e-agreements (via e-sign tools).</li>
                <li>To process payments and vendor payouts.</li>
                <li>To monitor project quality and safety.</li>
                <li>To send updates and notifications.</li>
                <li>To comply with legal obligations.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">3. Sharing & Disclosure</h5>
            <p>We do not sell or rent personal data. We may share with:</p>
            <ul>
                <li><strong>Vendors ↔ Customers:</strong> Limited information for project execution.</li>
                <li><strong>Third Parties:</strong> Payment gateways, hosting, e-signature tools, analytics.</li>
                <li><strong>Authorities:</strong> If required by law or court order.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">4. Confidentiality Obligations</h5>
            <ul>
                <li>Vendors must not bypass Constructkaro to deal directly with customers.</li>
                <li>Customers must not bypass Constructkaro once introduced to vendors.</li>
                <li>Both must maintain confidentiality of project details and documents.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">5. Data Security</h5>
            <ul>
                <li>Encryption of sensitive data.</li>
                <li>Access control & limited staff handling.</li>
                <li>PCI-DSS compliant payment gateways.</li>
                <li>Regular security audits.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">6. Data Retention</h5>
            <ul>
                <li>Data retained as long as required by law or service.</li>
                <li>Vendor and project records stored for compliance.</li>
                <li>Data anonymized or securely deleted when no longer needed.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">7. User Rights</h5>
            <ul>
                <li>Access and review your data.</li>
                <li>Correct inaccuracies.</li>
                <li>Request deletion (if allowed by law).</li>
                <li>Withdraw marketing consent.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">8. Cookies Policy</h5>
            <p>
                Our platform uses cookies for analytics and personalization. 
                Users may disable cookies in their browser, but some features may not work.
            </p>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">9. Third-Party Links</h5>
            <p>
                Our platform may contain links to third-party sites. 
                We are not responsible for their privacy practices.
            </p>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">10. Updates to Policy</h5>
            <p>
                This Privacy Policy may be updated from time to time. 
                Users will be notified of changes via email or app. 
                Continued use means acceptance.
            </p>
        </div>

        <div class="policy-section">
            <h5 class="fw-bold" style="color:#f25c05;">11. Grievance Officer</h5>
            <p><strong>Name:</strong> Mrs. Sheetal Agarwal</p>
            <p><strong>Email:</strong> swarajyaconstruction@outlook.com</p>
            <p><strong>Phone:</strong> 9326216153</p>
            <p><strong>Address:</strong> B- G1, Crescent Pearl, Katrang Road, Khopoli, Tal. Khalapur, Dist. Raigad, 410203</p>
        </div>
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
