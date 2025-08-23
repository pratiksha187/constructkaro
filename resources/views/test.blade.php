<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ===== SMS UI ===== --}}
<input id="phone_number" placeholder="+9198XXXXXXXX">
<button id="sendsmsotp" type="button">Send OTP</button>

<input id="phoneOtp" placeholder="Enter 6-digit OTP" maxlength="6" style="margin-left:8px;">
<button id="verifyPhoneOtpBtn" type="button">Verify</button>

<hr>

{{-- ===== EMAIL UI ===== --}}
<input id="email_address" placeholder="name@example.com" style="margin-right:8px;">
<button id="sendemailotp" type="button">Send Email OTP</button>

<input id="emailOtp" placeholder="Enter 6-digit OTP" maxlength="6" style="margin-left:8px;">
<button id="verifyEmailOtpBtn" type="button">Verify</button>

<script>
const SEND_URL_SMS     = '{{ route('otp.sms.send') }}';
const VERIFY_URL_SMS   = '{{ route('otp.sms.verify') }}';
const SEND_URL_EMAIL   = '{{ route('otp.email.send') }}';
const VERIFY_URL_EMAIL = '{{ route('otp.email.verify') }}';

function csrf() {
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}
async function postForm(url, obj){
  const fd = new FormData();
  Object.entries(obj).forEach(([k,v]) => fd.append(k,v));
  const r = await fetch(url, { method:'POST', headers:{ 'X-CSRF-TOKEN': csrf() }, body: fd });
  const j = await r.json().catch(()=>({}));
  if(!r.ok) throw new Error(j.message || 'Request failed');
  return j;
}

/* ===================== SMS ===================== */
// Send SMS OTP
document.getElementById('sendsmsotp').addEventListener('click', async () => {
  const phone = document.getElementById('phone_number').value.trim();
  if(!/^\+\d{8,15}$/.test(phone)){ alert('Enter phone in E.164 format, e.g. +9198XXXXXXXX'); return; }

  const btn = document.getElementById('sendsmsotp');
  btn.disabled = true;
  try {
    const res = await postForm(SEND_URL_SMS, { phone });
    alert((res.status||'')+': '+(res.message||'OTP sent'));
  } catch(e) {
    alert('error: '+e.message);
  } finally {
    btn.disabled = false;
  }
});

// Verify SMS OTP
document.getElementById('verifyPhoneOtpBtn').addEventListener('click', async () => {
  const phone = document.getElementById('phone_number').value.trim();
  const code  = document.getElementById('phoneOtp').value.trim();

  if(!/^\+\d{8,15}$/.test(phone)){ alert('Enter phone in E.164 format, e.g. +9198XXXXXXXX'); return; }
  if(!/^\d{6}$/.test(code)){ alert('Enter the 6-digit OTP'); return; }

  const btn = document.getElementById('verifyPhoneOtpBtn');
  btn.disabled = true;
  try {
    const res = await postForm(VERIFY_URL_SMS, { phone, code });
    alert((res.status||'')+': '+(res.message||''));
  } catch(e) {
    alert('error: '+e.message);
  } finally {
    btn.disabled = false;
  }
});

/* ===================== EMAIL ===================== */
// Send Email OTP
document.getElementById('sendemailotp').addEventListener('click', async () => {
  const email = document.getElementById('email_address').value.trim();
  if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ alert('Enter a valid email'); return; }

  const btn = document.getElementById('sendemailotp');
  btn.disabled = true;
  try {
    const res = await postForm(SEND_URL_EMAIL, { email });
    alert((res.status||'')+': '+(res.message||'Email OTP sent'));
  } catch(e) {
    alert('error: '+e.message);
  } finally {
    btn.disabled = false;
  }
});

// Verify Email OTP
document.getElementById('verifyEmailOtpBtn').addEventListener('click', async () => {
  const email = document.getElementById('email_address').value.trim();
  const code  = document.getElementById('emailOtp').value.trim();

  if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ alert('Enter a valid email'); return; }
  if(!/^\d{6}$/.test(code)){ alert('Enter the 6-digit OTP'); return; }

  const btn = document.getElementById('verifyEmailOtpBtn');
  btn.disabled = true;
  try {
    const res = await postForm(VERIFY_URL_EMAIL, { email, code });
    alert((res.status||'')+': '+(res.message||''));
  } catch(e) {
    alert('error: '+e.message);
  } finally {
    btn.disabled = false;
  }
});
</script>
