@extends('frontend.common.base')
@push('setTitle') Resume Builder @endpush

@push('addTitle'){{ 'Home' }}@endpush
@push('addDescription'){{ app('settings')['site_description'] }}@endpush
@push('addKeywords')@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@push('addStyle')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card bg-white shadow-sm rounded p-4 w-100 my-5" style="max-width: 900px;">
            <h2 class="text-center text-primary mb-3">AI Resume Generator</h2>
            
            <form id="resumeForm">
                <div class="mb-3">
                    <label for="job_role" class="form-label fw-semibold">Enter Job Role:</label>
                    <input type="text" id="job_role" name="job_role" class="form-control" required>
                </div>
    
                <button type="submit" class="btn btn-primary w-100">Generate Resume</button>
            </form>
    
            <div class="mt-4">
                <h3 class="h5 fw-semibold">Generated Resume:</h3>
                <div id="loading" class="d-none text-center text-primary">⏳ Generating...</div>
                <pre id="resumeOutput" class="p-3 bg-light rounded border mt-2 text-dark"></pre>
            </div>
        </div>
    
        <script>
            document.getElementById('resumeForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let jobRole = document.getElementById('job_role').value;
                let output = document.getElementById('resumeOutput');
                let loading = document.getElementById('loading');
                
                output.innerText = "";
                loading.classList.remove("d-none");
    
                axios.post('/tools/generate-resume', { job_role: jobRole })
                    .then(response => {
                        loading.classList.add("d-none");
                        output.innerText = response.data.resume;
                    })
                    .catch(error => {
                        console.error(error);
                        loading.classList.add("d-none");
                        output.innerText = "⚠️ Error generating resume.";
                    });
            });
        </script>
    </div>
@endsection

@push('addScript')

@endpush
