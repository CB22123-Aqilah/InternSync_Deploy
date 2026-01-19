<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Internship Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #c1ffca, #ebfff3);
        }

        .form-card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #63d77a, #6ec780);
        }

        .form-control {
            border-radius: 0.6rem;
            padding: 0.65rem 0.9rem;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.15rem rgba(59,130,246,0.25);
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 form-card">

                <!-- Header -->
                <div class="card-header text-white text-center py-4 form-header">
                    <h4 class="fw-bold mb-1">Industry Internship Information</h4>
                    <p class="mb-0 small opacity-75">
                        Kindly provide accurate internship details for students
                    </p>
                </div>

                <div class="card-body p-4 p-md-5">

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 rounded-4
                                    d-flex align-items-center gap-3
                                    shadow-sm"
                             style="
                                background: rgba(25,135,84,0.08);
                                border-left: 4px solid #198754;
                             ">
                            <div class="fs-4">✅</div>
                            <div class="small fw-semibold text-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    {{-- ERROR MESSAGE --}}
                    @if($errors->any())
                        <div class="mb-4 px-4 py-3 rounded-4
                                    d-flex gap-3 align-items-start
                                    shadow-sm"
                             style="
                                background: rgba(220,53,69,0.08);
                                border-left: 4px solid #dc3545;
                             ">
                            <div class="fs-4">⚠️</div>
                            <div class="small text-danger">
                                <div class="fw-semibold mb-1">Submission Error</div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- FORM -->
                    <form method="POST" action="{{ route('guest.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Company Name</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Industry Type</label>
                            <input type="text" name="industry_type" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" placeholder="example@company.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Internship Title</label>
                            <input type="text" name="internship_title" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Internship Description</label>
                            <textarea name="internship_description" rows="4" class="form-control"
                                      placeholder="Brief description of tasks and responsibilities"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Duration</label>
                                <input type="text" name="duration" class="form-control" placeholder="e.g. 12 weeks">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit"
                                    class="btn btn-success px-5 py-2 fw-semibold rounded-pill shadow-sm">
                                Submit Information
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
