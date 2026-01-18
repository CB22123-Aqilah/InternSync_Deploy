<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Internship Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4>Industry Internship Information Form</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('guest.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="industry_type" class="form-label">Industry Type</label>
                    <input type="text" name="industry_type" id="industry_type" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="internship_title" class="form-label">Internship Title</label>
                    <input type="text" name="internship_title" id="internship_title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="internship_description" class="form-label">Internship Description</label>
                    <textarea name="internship_description" id="internship_description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
