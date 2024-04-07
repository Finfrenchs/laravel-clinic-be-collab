@extends('layouts.app')

@section('title', 'Medical Records')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Medical Records</h1>
                <div class="section-header-button">
                    <a href="{{ route('medical-records.create') }}" class="btn btn-primary">Add Medical Records</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Medical Records</a></div>
                    <div class="breadcrumb-item">Medical Record List</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Medical Records</h2>
                <p class="section-lead">
                    You can manage all Medical Records, such as editing, deleting and more.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('medical-records.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by patient name" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Id</th>
                                            <th>Patient Name</th>
                                            <th>Schedule Time</th>
                                            <th>Doctor Name</th>
                                            <th>Complaint</th>
                                            <th>Medical Treatment</th>
                                            <th>Diagnosis</th>
                                            <th>Doctor Notes</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($medicalRecords as $medical)
                                            <tr>
                                                <td>
                                                    {{ $medical->id }}
                                                </td>
                                                <td>
                                                    {{ $medical->patient->name }}
                                                </td>
                                                <td>{{ $medical->patientSchedule->schedule_time }}
                                                </td>
                                                <td>
                                                    {{ $medical->doctor->doctor_name }}
                                                </td>
                                                <td>
                                                    {{ $medical->patientSchedule->complaint }}
                                                </td>
                                                <td>
                                                    {{ $medical->medical_treatments }}
                                                </td>
                                                <td>
                                                    {{ $medical->diagnosis }}
                                                </td>
                                                <td>
                                                    {{ $medical->doctor_notes }}
                                                </td>


                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('medical-records.edit', $medical->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('medical-records.destroy', $medical->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $medicalRecords->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
