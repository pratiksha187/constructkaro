@extends('layouts.app')

@section('title', 'Master Vendor Agreement | ConstructKaro')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-dark text-white py-3">
            <h3 class="mb-0">📑 Master Vendor Agreement</h3>
        </div>
        <div class="card-body p-4" style="max-height: 70vh; overflow-y: auto;">

            <h5 class="fw-bold mb-3">Master Vendor Agreement (“Agreement”)</h5>

            <h5 class="fw-bold mt-4">1. Parties and Recitals</h5>
            <p>
                This Master Vendor Agreement (“Agreement”) is entered into on this ___ day of ____, 20, by and between:
            </p>
            <p>
                <strong>Swarajya Construction Private Limited,</strong> a company incorporated under the Companies Act, 2013,
                having its registered office at B-G 1, Crescent Pearl, Katrang Road, Khopoli, 410203,
                acting under its brand name <strong>“ConstructKaro”</strong> (hereinafter referred to as
                the “Company” or “ConstructKaro”, which expression shall, unless repugnant to the context,
                include its successors and permitted assigns),
            </p>
            <p><strong>AND</strong></p>
            <p>
                <strong>{{ $vednor_details->name }}</strong>, a {{ $workTypes_name->work_type }},
                having its principal office at {{ $vednor_comp_details->registered_address }},
                holding GSTIN {{ $vednor_comp_details->gst_number }} (hereinafter referred to as the “Vendor”,
                which expression shall, unless repugnant to the context, include its successors, legal heirs, and permitted assigns).
            </p>

            <h5 class="fw-bold mt-4">Recitals</h5>
            <ol style="list-style-type: decimal;">
                <li>ConstructKaro operates a digital marketplace to connect customers with verified vendors for construction-related services.</li>
                <li>Vendor is engaged in the business of providing professional services in its respective domain and has expressed interest in offering such services to Customers through ConstructKaro’s platform.</li>
                <li>Both Parties desire to enter into this Agreement to define their respective rights, duties, and obligations.</li>
            </ol>
            <p><strong>Together referred to as the “Parties”, and individually as a “Party.”</strong></p>

            <hr>

            <h5 class="fw-bold mt-4">2. Definitions</h5>
            <ol style="list-style-type: decimal;">
                <li>“Customer” means any individual, company, or entity posting a Project on the Platform.</li>
                <li>“Project” means the specific work requirement posted by a Customer.</li>
                <li>“Milestone” means a defined stage of a Project linked to progress and payment.</li>
                <li>“Platform” means ConstructKaro’s website, mobile application, and related digital tools.</li>
                <li>“Commission” or “Service Fee” means the percentage of Project value payable to ConstructKaro by way of facilitation charges.</li>
                <li>“Confidential Information” means all data, documents, drawings, BOQs, pricing, project details, algorithms, and any information not in the public domain shared between Parties.</li>
                <li>“Force Majeure” shall have the meaning ascribed in Clause 14 herein.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">3. Appointment of Vendor</h5>
            <ol style="list-style-type: decimal;">
                <li>ConstructKaro hereby appoints the Vendor as a non-exclusive vendor on its Platform, subject to the terms of this Agreement.</li>
                <li>The Vendor may offer services in one or more categories, subject to ConstructKaro’s approval.</li>
                <li>Nothing in this Agreement shall be construed as creating an employer-employee or partnership relationship. Vendor is and shall remain an independent contractor.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">4. Vendor Obligations</h5>
            <ol style="list-style-type: decimal;">
                <li>Maintain all licenses, registrations, certifications, GST compliance, labour law compliance, and insurances necessary for operations.</li>
                <li>Deliver services in accordance with industry standards, IS/BIS codes, BOQs, approved drawings, and timelines agreed with Customers.</li>
                <li>Ensure safety standards at worksites and provide necessary PPE and insurances for workers.</li>
                <li>Provide milestone updates through the Platform to enable monitoring.</li>
                <li>Avoid entering into direct or indirect side-deals with Customers outside the Platform.</li>
                <li>Provide accurate invoices in compliance with tax laws.</li>
                <li>Maintain records for audits by ConstructKaro.</li>
                <li>Not misuse Customer data or ConstructKaro’s intellectual property.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">5. Commercial Terms and Fees</h5>
            <ol style="list-style-type: decimal;">
                <li>The Vendor acknowledges that ConstructKaro shall charge a <strong>service fee or commission</strong>, the structure of which shall depend on the type of Vendor and service category, as detailed in <strong>Annexure B</strong>.</li>
                <li>For some Vendor categories, the fee may be a <strong>percentage of the project value</strong> (e.g., contractors, interiors). For others, it may be a <strong>fixed fee or slab-based fee</strong> (e.g., architects, consultants).</li>
                <li>ConstructKaro shall notify the Vendor of the applicable fee at the time of Vendor onboarding and/or project allocation.</li>
                <li>The commission/service fee is <strong>exclusive of applicable taxes</strong>, which will be levied as per prevailing law.</li>
                <li>ConstructKaro reserves the right to revise the fee structure with prior written notice of <strong>30 days</strong>.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">6. Vendor Representations and Warranties</h5>
            <ol style="list-style-type: decimal;">
                <li>It holds all valid licenses, permits, GST registrations, and statutory approvals.</li>
                <li>All services and deliverables will be free from defects, conform to industry standards, and comply with applicable laws.</li>
                <li>No intellectual property rights of third parties are infringed by the Vendor’s work.</li>
                <li>The Vendor is not restricted by any prior agreement that conflicts with this Agreement.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">7. ConstructKaro’s Role and Rights</h5>
            <ol style="list-style-type: decimal;">
                <li>ConstructKaro shall be the customer-facing entity, providing a single-window interface for project onboarding, vendor allocation, milestone tracking, and payment facilitation.</li>
                <li>The execution, workmanship, and site-level performance shall remain the sole responsibility of the Vendor.</li>
                <li>ConstructKaro shall, however, exercise an oversight role, which includes:
                    <ol type="a">
                        <li>Conducting weekly site visits through its safety and quality officers.</li>
                        <li>Carrying out audit checks (technical, safety, material quality, and milestone completion).</li>
                        <li>Ensuring compliance with IS/BIS codes, safety norms, and BOQ specifications.</li>
                    </ol>
                </li>
                <li>Such monitoring or audit shall not absolve the Vendor of its responsibility. Any deficiencies, accidents, or legal violations shall remain the Vendor’s liability.</li>
                <li>ConstructKaro may withhold or delay payments if audit findings reveal non-compliance, safety hazards, or defective workmanship until corrective actions are taken.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">8. Intellectual Property and Branding</h5>
            <ol style="list-style-type: decimal;">
                <li>The Vendor grants ConstructKaro a limited license to use its name, logo, and work images for marketing, case studies, and listings on the platform.</li>
                <li>All platform IP, brand name, logo, website, and technology are the exclusive property of ConstructKaro. Vendors shall not use them except with written consent.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">9. Data Protection & Privacy</h5>
            <ol style="list-style-type: decimal;">
                <li>The Vendor shall not misuse, disclose, or sell Customer data obtained through the platform.</li>
                <li>ConstructKaro shall implement reasonable security measures to safeguard Vendor and Customer data.</li>
                <li>Both Parties shall comply with India’s Digital Personal Data Protection Act, 2023 and any subsequent data privacy regulations.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">10. Compliance with Laws</h5>
            <ol style="list-style-type: decimal;">
                <li>The Vendor shall comply with all applicable labour, safety, taxation, and environmental laws.</li>
                <li>The Vendor shall be solely liable for any penalties, claims, or damages arising from non-compliance.</li>
                <li>ConstructKaro may request proof of compliance (e.g., labour insurance, GST returns).</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">11. Liability & Indemnity</h5>
            <ol style="list-style-type: decimal;">
                <li>The Vendor is solely liable for execution, safety, and quality of work.</li>
                <li>The Vendor shall indemnify and hold harmless ConstructKaro from:
                    <ol type="a">
                        <li>Customer claims due to Vendor negligence or misconduct.</li>
                        <li>Regulatory penalties or third-party claims caused by Vendor’s work.</li>
                    </ol>
                </li>
                <li>ConstructKaro’s liability, in any case, shall be limited to the commission earned on the specific project.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">12. Insurance</h5>
            <ol style="list-style-type: decimal;">
                <li>Vendors must maintain adequate insurance coverage, including:
                    <ol type="a">
                        <li>Worker accident insurance (ESIC/Workmen’s Compensation).</li>
                        <li>Third-party liability insurance.</li>
                        <li>Project-specific coverage where required.</li>
                    </ol>
                </li>
                <li>ConstructKaro may request proof of valid insurance policies at any time.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">13. Term & Termination</h5>
            <ol style="list-style-type: decimal;">
                <li>This Agreement is valid from the Effective Date and shall continue unless terminated.</li>
                <li>Either Party may terminate with 30 days’ written notice.</li>
                <li>ConstructKaro may terminate immediately in case of:
                    <ol type="a">
                        <li>Fraud, misrepresentation, or side-dealing with Customers;</li>
                        <li>Gross negligence or repeated quality/safety failures;</li>
                        <li>Breach of confidentiality.</li>
                    </ol>
                </li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">14. Confidentiality</h5>
            <ol style="list-style-type: decimal;">
                <li>Vendors shall maintain confidentiality of all project details, pricing, and customer information.</li>
                <li>Confidentiality obligations shall survive termination for 3 years.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">15. Dispute Resolution</h5>
            <ol style="list-style-type: decimal;">
                <li>Any dispute shall first be resolved by negotiation between Vendor and Customer.</li>
                <li>If unresolved, ConstructKaro will act as mediator.</li>
                <li>If still unresolved, disputes shall be referred to arbitration under the Arbitration and Conciliation Act, 1996. Venue: Mumbai. Language: English.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">16. Governing Law & Jurisdiction</h5>
            <p>This Agreement shall be governed by the laws of India. Courts at Khalapur, Maharashtra shall have exclusive jurisdiction.</p>

            <hr>

            <h5 class="fw-bold mt-4">17. Miscellaneous</h5>
            <ol style="list-style-type: decimal;">
                <li>Independent Contractor: The Vendor is an independent contractor; no employment or partnership is created.</li>
                <li>Assignment: Vendors cannot assign or transfer rights under this Agreement without ConstructKaro’s consent.</li>
                <li>Notices: Any notice shall be sent to the registered address/emails of both Parties.</li>
                <li>Entire Agreement: This Agreement supersedes all prior discussions and constitutes the full understanding.</li>
                <li>Severability: If any clause is found invalid, the remaining clauses shall still apply.</li>
            </ol>

            <hr>

            <h5 class="fw-bold mt-4">Annexure A – Vendor Onboarding Documents</h5>
            <ol style="list-style-type: decimal;">
                <li>Identity & Legal Documents: GSTIN, PAN, Incorporation, Registrations.</li>
                <li>Technical Credentials: Completed projects, licenses, equipment proof.</li>
                <li>Financial Credentials: Cancelled cheque, last 2 years ITR/Financials.</li>
                <li>Insurance & Compliance: ESIC, accident insurance, safety certificates.</li>
            </ol>

            <h5 class="fw-bold mt-4">Annexure B – Commission Structure</h5>
            <ol style="list-style-type: decimal;">
                @if($workTypes_name->work_type == 'Contractor')
                    <li>Contractors: 5% – 7% of project value (exclusive of taxes).</li>
                @endif
                @if($workTypes_name->work_type == 'Architect')
                    <li>Architects: Fixed fee (₹25,000 – ₹1,00,000) OR 2% – 3% of design cost.</li>
                @endif
                @if($workTypes_name->work_type == 'Interior Designer')
                    <li>Interior Designers: 14% – 15% of project value.</li>
                @endif
                @if($workTypes_name->work_type == 'Consultant')
                    <li>Consultants: Fixed fee (₹10,000 – ₹50,000) OR retainer fee.</li>
                @endif
                @if($workTypes_name->work_type == 'Surveyor')
                    <li>Surveyors: ₹5,000 – ₹15,000 per job, milestone-based.</li>
                @endif
                @if($workTypes_name->work_type == 'Fabricator')
                    <li>Fabricators: 8% – 10% of work order value.</li>
                @endif
            </ol>

            <h5 class="fw-bold mt-4">Annexure C – Code of Conduct & Safety Guidelines</h5>
            <ol style="list-style-type: decimal;">
                <li>Workers must wear helmets, gloves, boots, reflective jackets.</li>
                <li>Vendor must ensure scaffolding, lifting, and machinery comply with IS/BIS standards.</li>
                <li>No child labour shall be employed.</li>
                <li>Vendors must cooperate with ConstructKaro Safety Auditors during weekly visits.</li>
                <li>Maintain daily attendance & safety logbooks at site.</li>
                <li>Immediate stoppage of work in case of serious safety violations.</li>
                <li>Vendor staff must maintain professional behaviour with customers and neighbours.</li>
            </ol>

            <h5 class="fw-bold mt-4">Annexure D – Milestone Payment Framework</h5>

            <h6 class="fw-bold">1. General Principles</h6>
            <ol style="list-style-type: decimal;">
                <li>All payments between Customers and Vendors will flow through ConstructKaro only.</li>
                <li>Each Project shall have pre-agreed milestones linked to clear deliverables, timelines, and documentation.</li>
                <li>Payment release is subject to:
                    <ol type="a">
                        <li>Vendor uploading evidence of milestone completion.</li>
                        <li>Customer approval on the platform within 72 hours.</li>
                        <li>If no approval/objection is raised, milestone is deemed approved.</li>
                    </ol>
                </li>
                <li>ConstructKaro reserves the right to withhold or partially release payment if disputes arise.</li>
            </ol>

            <h6 class="fw-bold mt-4">2. Milestone Categories (Vendor-Type Wise)</h6>
            <ol style="list-style-type: decimal;">
                @if($workTypes_name->work_type == 'Contractor')
                    <li><b>Contractors</b>
                        <ol type="a">
                            <li>Mobilization – 10%</li>
                            <li>Foundation & Footings – 15%</li>
                            <li>RCC Structure Completion – 25%</li>
                            <li>Masonry + Plastering – 20%</li>
                            <li>Flooring + Internal Finishes – 20%</li>
                            <li>Handover & Snag Rectification – 10%</li>
                        </ol>
                    </li>
                @endif
                @if($workTypes_name->work_type == 'Architect')
                    <li><b>Architects</b>
                        <ol type="a">
                            <li>Concept Presentation – 20%</li>
                            <li>Finalized Layouts & 3D – 30%</li>
                            <li>Approval Drawings & BOQ – 30%</li>
                            <li>Site Supervision – 20%</li>
                        </ol>
                    </li>
                @endif
                @if($workTypes_name->work_type == 'Interior Designer')
                    <li><b>Interior Designers</b>
                        <ol type="a">
                            <li>Design Freeze – 20%</li>
                            <li>Advance Procurement – 30%</li>
                            <li>Execution Mid-Stage – 30%</li>
                            <li>Final Handover – 20%</li>
                        </ol>
                    </li>
                @endif
                @if($workTypes_name->work_type == 'Surveyor')
                    <li><b>Surveyors</b>
                        <ol type="a">
                            <li>Site Visit & Data Collection – 40%</li>
                            <li>Draft Survey Drawings – 30%</li>
                            <li>Final Certified Drawings – 30%</li>
                        </ol>
                    </li>
                @endif
                @if($workTypes_name->work_type == 'Consultant')
                    <li><b>Consultants</b>
                        <ol type="a">
                            <li>Initial Review – 25%</li>
                            <li>Draft Report – 35%</li>
                            <li>Final Report & Handholding – 40%</li>
                        </ol>
                    </li>
                @endif
                @if($workTypes_name->work_type == 'Fabricator')
                    <li><b>Fabricators</b>
                        <ol type="a">
                            <li>Design & Shop Drawing Approval – 20%</li>
                            <li>Material Procurement/Fabrication – 40%</li>
                            <li>Installation/Completion – 40%</li>
                        </ol>
                    </li>
                @endif
            </ol>

            <h6 class="fw-bold mt-4">3. Evidence Required for Payment Release</h6>
            <ol style="list-style-type: decimal;">
                <li>Photos/videos of work done.</li>
                <li>Inspection reports where applicable.</li>
                <li>Customer’s signed site confirmation (digital OK valid).</li>
                <li>Invoices corresponding to milestone.</li>
            </ol>

            <h6 class="fw-bold mt-4">4. Dispute Escalation</h6>
            <ol style="list-style-type: decimal;">
                <li>If Customer rejects milestone: Vendor has 7 days to rectify.</li>
                <li>If unresolved → ConstructKaro Mediation Desk decides.</li>
                <li>ConstructKaro may approve partial release if significant progress achieved.</li>
            </ol>

            <h6 class="fw-bold mt-4">5. Retention / Withheld Amount</h6>
            <ol style="list-style-type: decimal;">
                <li>5–10% of final milestone may be kept as retention, released 30–60 days post-handover.</li>
                <li>This boosts customer trust without hurting vendors badly.</li>
            </ol>

        </div>
    </div>
</div>
@endsection
