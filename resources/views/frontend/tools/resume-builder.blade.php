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
<div class="flex justify-center">
    <div class="bg-white shadow-md rounded-xl p-6 w-full max-w-3xl my-8">
        <h2 class="text-2xl text-indigo-600 font-semibold text-center mb-4">AI Resume Generator</h2>

        <form id="resumeForm">
            <div class="mb-4">
                <label for="job_role" class="block text-sm font-medium text-gray-700 mb-1">Enter Job Role:</label>
                <input type="text" id="job_role" name="job_role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Generate Resume</button>
        </form>

        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800">Generated Resume:</h3>
            <div id="loading" class="hidden text-center text-indigo-600 mt-2">⏳ Generating...</div>
            <pre id="resumeOutput" class="mt-3 bg-gray-50 border rounded-lg p-4 text-gray-800 whitespace-pre-wrap"></pre>
        </div>
    </div>

    <script>
        document.getElementById('resumeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let jobRole = document.getElementById('job_role').value;
            let output = document.getElementById('resumeOutput');
            let loading = document.getElementById('loading');

            output.innerText = "";
            loading.classList.remove("hidden");

            axios.post('/tools/generate-resume', { job_role: jobRole })
                .then(response => {
                    loading.classList.add("hidden");
                    output.innerText = response.data.resume;
                })
                .catch(error => {
                    console.error(error);
                    loading.classList.add("hidden");
                    output.innerText = "⚠️ Error generating resume.";
                });
        });
    </script>
</div>

@endsection

@push('addScript')

@endpush
