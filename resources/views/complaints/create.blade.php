@extends('layouts.app')

@section('title', 'File a Complaint')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">File a Complaint</h1>
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" id="complaintForm">
                @csrf
                <input type="hidden" name="anonymous" value="1">

                @guest
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Anonymity</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="anonymousCheckbox" name="anonymous" value="0" checked>
                                <label class="form-check-label" for="anonymousCheckbox">File Anonymously</label>
                            </div>
                        </div>
                    </div>

                    <div id="userInfoFields" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="addressFields" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Address Information</h5>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state">
                                </div>
                                <div class="mb-3">
                                    <label for="zip" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zip" name="zip">
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Complaint Details</h5>
                        <div class="mb-3" id="custom_type_div" style="display: none;">
                            <label for="custom_type" class="form-label">Custom Type</label>
                            <input type="text" class="form-control" id="custom_type" name="custom_type">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Complaint Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="incident_date" class="form-label">Incident Date and Time</label>
                            <div style="max-width: 250px; display: inline-block;">
                                <input type="datetime-local" class="form-control" id="incident_date" name="incident_date" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Employee Information</h5>
                        <div class="mb-3">
                            <label for="officer_name" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="officer_name" name="officer_name">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Attachments</h5>
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Upload Files (Images, Videos, Documents)</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Submit Complaint</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        background-color: #ffffff;
    }

    .form-check-input {
        width: 16px;
        height: 16px;
    }
</style>

<script>
    @guest
    document.getElementById('anonymousCheckbox').addEventListener('change', function() {
        var userInfoFields = document.getElementById('userInfoFields');
        var addressFields = document.getElementById('addressFields');
        if (this.checked) {
            userInfoFields.style.display = 'none'; // Hide user info fields if anonymous
            addressFields.style.display = 'none'; // Hide address fields if anonymous
            // Clear the values of the user info and address fields
            document.getElementById('first_name').value = '';
            document.getElementById('last_name').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
            document.getElementById('zip').value = '';
        } else {
            userInfoFields.style.display = 'block'; // Show user info fields if not anonymous
            addressFields.style.display = 'block'; // Show address fields if not anonymous
            // The hidden input will ensure that anonymous is set to 0
        }
    });

    document.getElementById('complaintForm').addEventListener('submit', function(e) {
        console.log('Form action:', this.action); // Log the form action URL
        console.log('Anonymous value:', document.querySelector('input[name="anonymous"]').value); // Log the anonymous value

        var anonymous = document.getElementById('anonymousCheckbox').checked;
        if (!anonymous) {
            var requiredFields = ['first_name', 'last_name', 'phone', 'email', 'password', 'address', 'city', 'state', 'zip'];
            for (var i = 0; i < requiredFields.length; i++) {
                var field = document.getElementById(requiredFields[i]);
                if (!field.value) {
                    e.preventDefault(); // Prevent form submission only if validation fails
                    alert('Please fill in all required fields.'); // Alert user
                    return; // Exit the function
                }
            }
        }
        console.log('Form is valid, submitting...'); // Log for debugging
        // Form will submit normally if all validations pass
    });
    @endguest

    let witnessIndex = 1;
    document.getElementById('addWitness').addEventListener('click', function() {
      const witnessesDiv = document.getElementById('witnesses');
      const newWitnessDiv = document.createElement('div');
      newWitnessDiv.classList.add('witness', 'row', 'mb-3');
      newWitnessDiv.innerHTML = `
                <div class="col-md-4">
                    <label for="witness_name_${witnessIndex}" class="form-label">Witness Name</label>
                    <input type="text" class="form-control" id="witness_name_${witnessIndex}" name="witnesses[${witnessIndex}][name]">
                </div>
                <div class="col-md-3">
                    <label for="witness_contact_${witnessIndex}" class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="witness_contact_${witnessIndex}" name="witnesses[${witnessIndex}][contact]">
                </div>
                <div class="col-md-3">
                    <label for="witness_email_${witnessIndex}" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="witness_email_${witnessIndex}" name="witnesses[${witnessIndex}][email]">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-danger delete-witness">Delete</button>
                </div>
            `;
      witnessesDiv.appendChild(newWitnessDiv);
      witnessIndex++;
    });

    document.getElementById('witnesses').addEventListener('click', function(event) {
      if (event.target.classList.contains('delete-witness')) {
        event.target.closest('.witness').remove();
      }
    });

    document.querySelectorAll('input[name="complaint_type"]').forEach(function(radio) {
      radio.addEventListener('change', function() {
        var customTypeDiv = document.getElementById('custom_type_div');
        if (this.value === 'Others') {
          customTypeDiv.style.display = 'block';
        } else {
          customTypeDiv.style.display = 'none';
          document.getElementById('custom_type').value = ''; // Clear the custom type input
        }
      });
    });

    document.getElementById('signature_agreement').addEventListener('change', function() {
      var signatureDiv = document.getElementById('signature_div');
      if (this.checked) {
        signatureDiv.style.display = 'block';
      } else {
        signatureDiv.style.display = 'none';
        document.getElementById('signature').value = ''; // Clear the signature input
      }
    });
</script>
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
