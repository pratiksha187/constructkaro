@extends('layouts.app')

@section('title', 'Master Vendor Agreement | ConstructKaro')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-dark text-white py-3">
            <h3 class="mb-0">📑 Master Vendor Agreement</h3>
        </div>
        <div class="card-body p-4" style="max-height: 70vh; overflow-y: auto;">
            
            <h5 class="fw-bold mb-3">This Vendor Agreement (“Agreement”) is made between:</h5>
            <p>
                <strong>1.</strong> Swarajya Construction Private Limited, a company incorporated under the Companies Act, 2013, having its registered office at 
                B-G 1, Crescent Pearl, Katrang Road, Khopoli, 410203, acting under its brand name <strong>“ConstructKaro”</strong> (hereinafter referred to as 
                “ConstructKaro” or the “Company”);
            </p>
            <p>
                <strong>2.</strong> {{$vednor_details->name}}, a {{$workTypes_name->work_type}}, 
                having its principal office at {{$vednor_comp_details->registered_address}}, holding GSTIN {{$vednor_comp_details->gst_number}} (“Vendor”).
            </p>

            <p><strong>Together referred to as the “Parties” and individually as a “Party.”</strong></p>

            <hr>

            <h5 class="fw-bold mt-4">1. Purpose</h5>
            <p>ConstructKaro operates a digital marketplace connecting customers with verified vendors for construction-related services. This Agreement sets out the terms under which the Vendor shall provide its services to customers through ConstructKaro.</p>

            <h5 class="fw-bold mt-4">2. Definitions</h5>
            <ul>
                <li><b>Customer:</b> Any individual, company, or entity posting a project on ConstructKaro.</li>
                <li><b>Project:</b> The specific work requirement posted by a Customer.</li>
                <li><b>Milestone:</b> Defined stage of a Project linked to progress and payment.</li>
                <li><b>Platform:</b> The ConstructKaro digital platform (website & mobile app).</li>
            </ul>

            <h5 class="fw-bold mt-4">3. Scope of ConstructKaro</h5>
            <ol type="a">
                <li>Acts as a facilitator between Customers and Vendors.</li>
                <li>Provides tendering, bidding, milestone monitoring, and payment facilitation services.</li>
                <li>Manages payment collection from Customers and disbursal to Vendors (after deducting ConstructKaro’s commission).</li>
                <li>Provides dispute resolution and customer helpdesk support.</li>
            </ol>

            <h5 class="fw-bold mt-4">4. Vendor Obligations</h5>
            <ol type="a">
                <li>Maintain valid licenses, registrations, and GST compliance.</li>
                <li>Deliver services with professional skill, quality, and adherence to safety norms.</li>
                <li>Execute work as per approved BOQ, drawings, or contract terms.</li>
                <li>Avoid side-deals with Customers outside the platform.</li>
                <li>Provide accurate invoices and comply with tax laws.</li>
                <li>Adhere to ConstructKaro’s Code of Conduct and Safety Guidelines.</li>
            </ol>

            <h5 class="fw-bold mt-4">5. Commercials</h5>
            <ol type="a">
                <li>ConstructKaro will deduct a service fee/commission as per Annexure B.</li>
                <li>Vendor shall issue GST invoice to ConstructKaro for the net amount payable.</li>
                <li>Payment will be released milestone-wise upon Customer approval.</li>
                <li>A retention amount (5–10%) may be withheld till defect liability period.</li>
            </ol>

            <h5 class="fw-bold mt-4">6. Vendor Representations and Warranties</h5>
            <p>The Vendor represents and warrants that:</p>
            <ul>
                <li>It has full authority to enter into this Agreement.</li>
                <li>It holds all necessary licenses and approvals.</li>
                <li>It is not bound by any prior agreement that conflicts with this Agreement.</li>
                <li>It will provide services diligently, safely, and professionally.</li>
            </ul>

            <h5 class="fw-bold mt-4">7. ConstructKaro’s Role and Rights</h5>
            <ol type="a">
                <li>Acts as facilitator and brand face of the platform.</li>
                <li>Not responsible for execution quality or site-level issues.</li>
                <li>May send auditors for safety/quality checks.</li>
                <li>Right to verify, suspend, or blacklist vendors.</li>
                <li>Provides helpdesk escalation support for Customers.</li>
            </ol>

            <h5 class="fw-bold mt-4">8. Confidentiality</h5>
            <p>The Vendor shall keep confidential all project data, customer info, and proprietary information. This obligation shall survive termination.</p>

            <h5 class="fw-bold mt-4">9. Liability</h5>
            <ol type="a">
                <li>Vendor is fully responsible for execution, quality, and safety.</li>
                <li>ConstructKaro’s role is limited to facilitation and monitoring.</li>
                <li>ConstructKaro is not liable for damages from Vendor’s negligence.</li>
            </ol>

            <h5 class="fw-bold mt-4">10. Term and Termination</h5>
            <ol type="a">
                <li>Agreement continues until terminated.</li>
                <li>Either Party may terminate with 30 days’ notice.</li>
                <li>Immediate termination in cases of fraud, negligence, or misconduct.</li>
            </ol>

            <h5 class="fw-bold mt-4">11. Dispute Resolution</h5>
            <p>Step 1: Vendor-Customer discussion → Step 2: Mediation by ConstructKaro → Step 3: Arbitration under the Arbitration and Conciliation Act, 1996 (venue: Mumbai).</p>

            <h5 class="fw-bold mt-4">12. Governing Law</h5>
            <p>Governing law of India. Exclusive jurisdiction of Mumbai courts.</p>

            <hr>

            <h5 class="fw-bold mt-4">Annexures</h5>
            <p><b>Annexure A – Vendor Onboarding Documents</b></p>
            <ul>
                <li>GSTIN, PAN, Registrations, Licenses, Bank Details, Proof of Address</li>
            </ul>

            <p><b>Annexure B – Service Fee / Commission</b></p>
            <!-- <ul>
                <li>Contractors: 5–7% of project value</li>
                <li>Architects: Fixed fee</li>
                <li>Interior Designers: 14–15% of project value</li>
                <li>Consultants: Fixed fee</li>
                <li>Surveyors: Fixed fee</li>
                <li>Fabricators: 7–10% of project value</li>
            </ul> -->
            <ul>
                @if($workTypes_name->work_type == 'Contractor')
                    <li>Contractors: 5–7% of project value</li>
                @endif

                @if($workTypes_name->work_type == 'Architect')
                    <li>Architects: Fixed fee</li>
                @endif

                @if($workTypes_name->work_type == 'Interior Designer')
                    <li>Interior Designers: 14–15% of project value</li>
                @endif

                @if($workTypes_name->work_type == 'Consultant')
                    <li>Consultants: Fixed fee</li>
                @endif

                @if($workTypes_name->work_type == 'Surveyor')
                    <li>Surveyors: Fixed fee</li>
                @endif

                @if($workTypes_name->work_type == 'Fabricator')
                    <li>Fabricators: 7–10% of project value</li>
                @endif
            </ul>

            <p><b>Annexure C – Code of Conduct & Safety</b></p>
            <ul>
                <li>Follow safety standards and labour laws</li>
                <li>No bribery, corruption, malpractice</li>
                <li>Ensure insurance and site safety</li>
            </ul>

            <p><b>Annexure D – Milestone Payments</b></p>
            <p>Payments milestone-linked, evidence-based, with 5–10% retention. Framework defined category-wise.</p>

        </div>
        <!-- <div class="card-footer text-center bg-light py-3">
            <form method="POST" action="">
                @csrf
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="accept" required>
                    <label class="form-check-label" for="accept">
                        I have read and agree to the terms of this Master Vendor Agreement.
                    </label>
                </div>
                <button type="submit" class="btn btn-success px-5">Accept & Continue</button>
            </form>
        </div> -->
    </div>
</div>
@endsection
