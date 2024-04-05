@extends('layouts.app')

@section('title', 'Patient Scheduels')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Patient Schedule</h1>
                <div class="section-header-button">
                    <a href="{{ route('patient-schedules.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Patient</a></div>
                    <div class="breadcrumb-item">All Patient Schedule</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Patiens</h2>
                <p class="section-lead">
                    You can manage all Patients, such as editing, deleting and more.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('patient-schedules.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
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
                                            <th>Name</th>
                                            <th>Complaint</th>
                                            <th>Schedule Time</th>
                                            <th>Examining Doctor</th>
                                            <th>Gender</th>
                                            <th>Birthdate</th>
                                            <th>NIK</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($patientSchedules as $schedule)
                                            <tr>
                                                <td>
                                                    {{ $schedule->id }}
                                                </td>
                                                <td>
                                                    {{ $schedule->patient->name }}
                                                </td>
                                                <td>{{ $schedule->complaint }}
                                                </td>
                                                <td>
                                                    {{ $schedule->schedule_time }}
                                                </td>
                                                <td>
                                                    {{ $schedule->doctor->doctor_name }}
                                                </td>
                                                <td>
                                                    {{ $schedule->patient->gender }}
                                                </td>
                                                <td>
                                                    {{ $schedule->patient->birth_date }}
                                                </td>
                                                <td>
                                                    {{ $schedule->patient->nik }}
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('patient-schedules.edit', $schedule->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('patient-schedules.destroy', $schedule->id) }}"
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
                                    {{ $patientSchedules->withQueryString()->links() }}
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
