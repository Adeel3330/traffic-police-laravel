<!DOCTYPE html>
<html lang="en-US">
@include('include.head')
<body>
<div class="wrapper">
    <div class="wrapper_inner">
        @include('include.header')

        <div class="container my-5 py-3">
            <div class="row">
                <div class="col-md-12">

                    {{-- Always show the form --}}
                    <h3 class="my-3" style="font-size: 32px">Verification</h3>
                    <form action="{{ route('license.verify') }}" method="POST" id="cnic-validation-frm2">
                        @csrf
                        <div>
                            <input type="text" 
                                   name="user_license_number" 
                                   id="cnic"
                                   class="form-control p-4 @error('user_license_number') is-invalid @enderror"
                                   placeholder="Enter Your CNIC Number"
                                   value="{{ old('user_license_number') }}"
                                   style="font-size: 16px;">
                            {{-- Validation error --}}
                            @error('user_license_number')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>

                    {{-- Results Section --}}
                    @if(request()->isMethod('post'))
                        <h3 class="my-3" style="font-size: 32px">Verification Status</h3>

                        @if($license)
                            {{-- Show table if record found --}}
                            <div class="table-responsive">
                                <table class="table table-primary table-bordered table-hover mt-3" style="font-size: 18px;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>CNIC</th>
                                            <th>License Type</th>
                                            <th>Learner Number</th>
                                            <th>License Number</th>
                                            <th>Issue Date</th>
                                            <th>Expire Date</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $license->ApplicantName }}</td>
                                            <td>{{ $license->CNIC }}</td>
                                            <td>{{ $license->LicenseType }}</td>
                                            <td>{{ $license->LearnerNumber }}</td>
                                            <td>{{ $license->LicenseNumber }}</td>
                                            <td>{{ $license->issue_date }}</td>
                                            <td>{{ $license->expire_date }}</td>
                                            <td>{{ $license->address }}</td>
                                            <td>{{ $license->Status }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Show message if no record found --}}
                            <div class="alert alert-danger mt-3">
                                No record found
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

        @include('include.footer')
    </div>
</div>
</body>
</html>
