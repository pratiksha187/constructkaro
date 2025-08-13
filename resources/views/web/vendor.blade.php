@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
<style>
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(to right, #f8fafc, #ffffff);
    }

    .register-card {
        width: 100%;
        max-width: 1446px;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
        padding: 3rem;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #1c2c3e;
    }

    .btn-orange {
        background-color: #f97316;
        color: white;
        border: none;
    }

    .btn-orange:hover {
        background-color: #ea580c;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }

    .welcome-box {
        background: #f1f5f9;
        border-left: 5px solid #f97316;
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
    }

    .welcome-box h2 {
        font-size: 1.75rem;
        color: #1c2c3e;
        font-weight: 700;
    }

    .welcome-box p {
        margin-top: 0.5rem;
        color: #334155;
        font-size: 1rem;
    }

    .welcome-box ul {
        padding-left: 1.25rem;
        margin-top: 0.5rem;
        list-style: none;
    }

    .welcome-box ul li::before {
        content: "✔";
        margin-right: 8px;
        color: #22c55e;
        font-weight: bold;
    }

    #suggestions {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }

    #suggestions div {
        padding: 0.5rem 1rem;
        cursor: pointer;
    }

    #suggestions div:hover,
    #suggestions .highlight {
        background-color: #f0f0f0;
    }

    @media (max-width: 768px) {
        .register-card {
            padding: 2rem;
        }

        .welcome-box {
            padding: 1.25rem;
        }
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="register-wrapper">
    <div class="register-card">
        <!-- Welcome Section -->
        <div class="welcome-box">
            <h2>Welcome to Constructkaro</h2>
            <p>Join as a verified service provider and grow your business by connecting with thousands of active construction project owners across India.</p>
            <ul>
                <li>Verified Leads</li>
                <li>Real-time Notifications</li>
                <li>Simple Project Management</li>
            </ul>
        </div>

        <!-- Registration Form -->
        <h3 class="fw-bold text-center mb-2" style="color: #1c2c3e;">
            Register as a <span style="color:#f97316;">Service Provider</span>
        </h3>
        <p class="text-center text-muted mb-4">Create your account and start growing your business with us</p>

        <form id="serviceprovider">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Mobile Number *</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email ID *</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" autocomplete="off" required>
                    <div id="suggestions" class="col-md-6" style="display: none; z-index: 1000;"></div>
                </div>

                <div class="col-md-6">
                    <label>Business Name</label>
                    <input type="text" name="business_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>GST Number</label>
                    <input type="text" name="gst_number" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>City / Location *</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-5">Create Account</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const suggestionsBox = document.getElementById("suggestions");

    const domains = [
        "gmail.com", "yahoo.com", "outlook.com", "hotmail.com", "icloud.com",
        "protonmail.com", "rediffmail.com", "mail.com", "zoho.com", "aol.com"
    ];

    let selectedIndex = -1;

    emailInput.addEventListener("input", function () {
        const value = this.value;
        const atIndex = value.indexOf("@");

        if (atIndex !== -1 && !value.slice(atIndex + 1).includes(".")) {
            const username = value.slice(0, atIndex + 1);
            suggestionsBox.innerHTML = "";
            selectedIndex = -1;

            domains.forEach((domain, index) => {
                const suggestion = document.createElement("div");
                suggestion.textContent = username + domain;
                suggestion.setAttribute("data-index", index);
                suggestion.classList.add("px-3", "py-2", "border-bottom");

                suggestion.addEventListener("click", function () {
                    emailInput.value = this.textContent;
                    suggestionsBox.style.display = "none";
                });

                suggestionsBox.appendChild(suggestion);
            });

            suggestionsBox.style.display = "block";
        } else {
            suggestionsBox.style.display = "none";
        }
    });

    emailInput.addEventListener("keydown", function (e) {
        const items = suggestionsBox.querySelectorAll("div");

        if (suggestionsBox.style.display === "none") return;

        if (e.key === "ArrowDown") {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % items.length;
            updateHighlight(items);
        }

        if (e.key === "ArrowUp") {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + items.length) % items.length;
            updateHighlight(items);
        }

        if (e.key === "Enter") {
            if (selectedIndex >= 0 && items[selectedIndex]) {
                e.preventDefault();
                emailInput.value = items[selectedIndex].textContent;
                suggestionsBox.style.display = "none";
            }
        }
    });

    document.addEventListener("click", function (e) {
        if (!emailInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = "none";
        }
    });

    function updateHighlight(items) {
        items.forEach(item => item.classList.remove("bg-light"));
        if (items[selectedIndex]) {
            items[selectedIndex].classList.add("bg-light");
            items[selectedIndex].scrollIntoView({ block: "nearest" });
        }
    }
});
</script>

<script>
    $(document).ready(function () {
        $('#serviceprovider').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('registerServiceProvider') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    window.location.href = "{{ route('types_of_agency') }}";
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let errorMessage = "";

                    if (errors) {
                        $.each(errors, function (key, value) {
                            errorMessage += `<div>${value[0]}</div>`;
                        });
                    } else {
                        errorMessage = "An unexpected error occurred.";
                    }

                    $('body').prepend(`
                        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3" style="max-width: 600px;" role="alert">
                          ${errorMessage}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        });
    });
</script>
@endsection
