@extends('layouts.app')

@section('title', 'Master Customer Agreement | ConstructKaro')

@section('content')
<style>
  :root {
    --primary: #f25c05;
    --dark: #1c2c3e;
    --light: #ffffff;
    --muted: #6b7280;
  }

  body {
    background-color: #f8fafc;
  }

  .agreement-page {
    padding: 60px 20px;
  }

  .agreement-container {
    background: #fff;
    max-width: 1466px;
    margin: 0 auto;
    padding: 40px 50px;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  }

  .agreement-container h1 {
    text-align: center;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--dark);
    font-size: 26px;
    margin-bottom: 30px;
    border-bottom: 3px solid var(--primary);
    padding-bottom: 10px;
  }

  .meta-block {
    background: #fafafa;
    border-left: 4px solid var(--primary);
    padding: 18px 22px;
    border-radius: 6px;
    margin-bottom: 30px;
    font-size: 15px;
    color: #333;
  }

  .toc {
    background: var(--dark);
    color: #fff;
    padding: 20px 25px;
    border-radius: 6px;
    margin-bottom: 35px;
  }

  .toc h4 {
    font-size: 16px;
    color: #fff;
    font-weight: 600;
    margin-bottom: 12px;
  }

  .toc a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 3px 0;
    font-size: 14px;
    transition: all 0.2s;
  }

  .toc a:hover {
    color: var(--primary);
    padding-left: 5px;
  }

  .section {
    margin-bottom: 35px;
  }

  h2 {
    font-size: 20px;
    color: var(--dark);
    border-left: 5px solid var(--primary);
    padding-left: 10px;
    margin-bottom: 15px;
    font-weight: 600;
  }

  h3 {
    font-size: 16px;
    color: var(--primary);
    margin-top: 15px;
    font-weight: 600;
  }

  p, li {
    font-size: 15px;
    color: #333;
    line-height: 1.7;
  }

  ul {
    margin-left: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 10px 12px;
    text-align: left;
    font-size: 14px;
  }

  th {
    background-color: #f4f4f4;
    font-weight: 600;
  }

  .annexure {
    margin-top: 40px;
    border-top: 2px dashed #ddd;
    padding-top: 20px;
  }

  .agreement-footer {
    margin-top: 40px;
    text-align: center;
    font-size: 14px;
    color: #666;
    border-top: 2px solid #eee;
    padding-top: 15px;
  }

  .agreement-footer a {
    color: var(--primary);
    text-decoration: none;
  }

  @media (max-width: 768px) {
    .agreement-container {
      padding: 25px;
    }
    .toc {
      margin-bottom: 25px;
    }
  }
</style>

<div class="agreement-page">
  <div class="agreement-container">
    <h1>MASTER CUSTOMER AGREEMENT</h1>

    <div class="meta-block">
      <p><strong>This Customer Agreement (“Agreement”)</strong> is made between:</p>
      <p><strong>1.</strong> Swarajya Construction Private Limited, registered under the Companies Act, 2013, having its registered office at <em>B-G 1, Crescent Pearl, Katrang Road, Khopoli, 410203</em>, acting under its brand name <strong>“ConstructKaro”</strong> (“the Company”).</p>
      <p><strong>and</strong></p>
      <p><strong>2. {{$user->full_name}} </strong>, an individual / firm / company / institution with registered address at {{$user->state}},{{$user->region}},{{$user->city}} (hereinafter referred to as the “Customer”).</p>
      <p>Together referred to as the “Parties” and individually as a “Party.”</p>
    </div>

    <div id="section1" class="section">
      <h2>1. Introduction and Scope of Agreement</h2>
      <p>This Agreement defines the framework for project listing, vendor bidding, milestone-based execution, and escrow payment handling between ConstructKaro and the Customer.</p>
    </div>

    <div id="section2" class="section">
      <h2>2. Definitions and Key Terms</h2>
      <p>Includes definitions such as “ConstructKaro”, “Customer”, “Vendor”, “Project”, “BOQ”, and “Milestone”.</p>
    </div>

    <div id="section3" class="section">
      <h2>3. Role of ConstructKaro</h2>
      <p>ConstructKaro manages vendor allocation, milestone tracking, and payment verification for transparency and accountability.</p>
    </div>

    <div id="section4" class="section">
      <h2>4. Customer Obligations & Project Process</h2>
      <ul>
        <li>Provide accurate project details and BOQ.</li>
        <li>Ensure milestone payments are deposited before work begins.</li>
        <li>Allow ConstructKaro’s team site access for verification.</li>
        <li>Approve milestones within 7 days of notification.</li>
      </ul>
    </div>

    <div id="section5" class="section">
      <h2>5. Payments and Milestones</h2>
      <p>All payments go through ConstructKaro’s escrow system with verification before release. A retention of 5–10% may apply for 6 months post-completion.</p>
    </div>

    <div id="section6" class="section">
      <h2>6. Quality and Safety Assurance</h2>
      <p>ConstructKaro enforces material and workmanship standards with regular inspections to ensure project safety and quality.</p>
    </div>

    <div id="section7" class="section">
      <h2>7. Dispute Resolution and Cancellations</h2>
      <p>Disputes are handled first through ConstructKaro’s mediation; unresolved cases go to arbitration in Khalapur, Maharashtra.</p>
    </div>

    <div id="section8" class="section">
      <h2>8. Data Privacy and Confidentiality</h2>
      <p>All project data and communications are confidential and stored securely in compliance with Indian IT laws.</p>
    </div>

    <div id="section9" class="section">
      <h2>9. Limitation of Liability</h2>
      <p>ConstructKaro’s total liability is limited to its service commission; it acts only as a facilitator.</p>
    </div>

    <div id="section10" class="section">
      <h2>10. Intellectual Property Rights</h2>
      <p>All rights to ConstructKaro’s platform, design, and code belong to Swarajya Construction Pvt. Ltd.</p>
    </div>

    <div id="section11" class="section">
      <h2>11. Payment, Refunds & Escrow Handling</h2>
      <p>Outlines the escrow process, refund policy, and commission structure as per Annexure A and B.</p>
    </div>

    <div id="section12" class="section">
      <h2>12. Termination and Suspension</h2>
      <p>ConstructKaro may suspend or terminate services for non-payment or breach of agreement terms.</p>
    </div>

    <div id="section13" class="section">
      <h2>13. Force Majeure and Jurisdiction</h2>
      <p>Neither party shall be held liable for delays due to uncontrollable events. Jurisdiction: Raigad, Maharashtra.</p>
    </div>

    <div id="section14" class="section">
      <h2>14. Confidentiality and Data Protection</h2>
      <p>ConstructKaro and Customer shall maintain strict confidentiality for three years post-termination.</p>
    </div>

    <div id="section15" class="section">
      <h2>15. Liability, Indemnity & Insurance</h2>
      <p>Both Customer and Vendor agree to indemnify ConstructKaro from any legal or financial liability caused by negligence or breach.</p>
    </div>

    <div id="section16" class="section">
      <h2>16. Governing Law, Notices, and Final Provisions</h2>
      <p>All disputes shall be governed by Indian law, with notices to <strong>info@constructkaro.com</strong>.</p>
    </div>

    <div class="annexure">
      <h2>Annexure A – Escrow & Payment Flow</h2>
      <p>Describes milestone-based escrow process for transparent vendor payment.</p>
    </div>

    <div class="annexure">
      <h2>Annexure B – Commission Matrix</h2>
      <table>
        <thead>
          <tr>
            <th>Category</th>
            <th>Type of Service</th>
            <th>Commission (%)</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Civil Contractors</td><td>Road Work, Building Construction, Plot Development</td><td>5–8%</td><td>Milestone-wise</td></tr>
          <tr><td>Architects & Designers</td><td>Planning and Approvals</td><td>7–10%</td><td>Concept to GFC</td></tr>
          <tr><td>Interior Designers</td><td>Turnkey Interiors</td><td>10–12%</td><td>Customized Works</td></tr>
          <tr><td>Consultants</td><td>Structural / Legal / MEP</td><td>5–7%</td><td>Advisory Services</td></tr>
          <tr><td>Surveyors</td><td>DGPS / Drone / Layout Marking</td><td>3–5%</td><td>Per Project Basis</td></tr>
        </tbody>
      </table>
    </div>

    <div class="annexure">
      <h2>Annexure C – Vendor Verification Steps</h2>
      <p>Outlines ConstructKaro’s three-tier vendor verification: Identity, Technical Validation, and Compliance & Financial Check.</p>
    </div>

    <div class="agreement-footer">
      <p><strong>Swarajya Construction Pvt. Ltd. (ConstructKaro Brand)</strong><br>
      B-G 1, Crescent Pearl, Katrang Road, Khopoli, Maharashtra – 410203<br>
      <a href="mailto:info@constructkaro.com">info@constructkaro.com</a> | <a href="https://constructkaro.com" target="_blank">www.constructkaro.com</a></p>
    </div>
  </div>
</div>
@endsection
