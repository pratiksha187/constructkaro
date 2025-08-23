{{-- resources/views/leegality/new.blade.php --}}
@extends('layouts.app')
@section('title','Send for eSign')
@section('content')
<div class="container py-4">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

  <form method="POST" action="{{ route('esign.create') }}" enctype="multipart/form-data" class="card p-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">Document name</label>
      <input name="doc_name" class="form-control" required value="Work Order">
    </div>
    <div class="mb-3">
      <label class="form-label">PDF</label>
      <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Signer Name</label>
        <input name="signer_name" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Signer Email</label>
        <input name="signer_email" class="form-control" placeholder="optional">
      </div>
      <div class="col-md-4">
        <label class="form-label">Signer Phone</label>
        <input name="signer_phone" class="form-control" placeholder="+91XXXXXXXXXX">
      </div>
    </div>
    <button class="btn btn-primary mt-3">Send for eSign</button>
  </form>

  <p class="text-muted mt-3">
    This flow can be configured to use Aadhaar OTP or Face eSign and (optionally) Digital Stamping inside the same workflow. Face eSign uses the Leegality Helper app on Android for on-field journeys. </p>
</div>
@endsection
