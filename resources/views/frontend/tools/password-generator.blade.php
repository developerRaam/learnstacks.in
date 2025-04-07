@extends('frontend.common.base')
@push('setTitle') Password Generator @endpush

@push('addTitle'){{ 'Home' }}@endpush
@push('addDescription'){{ app('settings')['site_description'] }}@endpush
@push('addKeywords'){{'tech blog, programming tutorials, web development tips, PHP tutorials, Laravel tutorials, coding best practices, tech job postings, AI tutorials, cybersecurity best practices'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="p-4">
                    <h3 class="mb-3 text-center">🔑 Password Generator</h3>
                    <div class="mt-4 passwordOutput">
                        <p id="text_copied" class="text-success"></p>
                        <div class="input-group">
                            <input type="text" id="passwordOutput" class="form-control passwordOutputText fw-bold" readonly>
                            <button class="btn btn-outline-secondary" onclick="copyPassword()">Copy</button>
                        </div>
                    </div>
                    <div class="card p-3">
                        <div class="row g-4">
                            <h2>Customize your password</h2>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Password Length: <span id="passwordLengthValue">8</span></label>
                                    <input type="range" id="passwordLength" class="form-range" value="8" min="4" max="32" oninput="generatePassword()">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input type="radio" id="easyToSay" name="passwordType" class="form-check-input">
                                    <label class="form-check-label">Easy to say</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="easyToRead" name="passwordType" class="form-check-input">
                                    <label class="form-check-label">Easy to read</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="allCharacters" name="passwordType" class="form-check-input">
                                    <label class="form-check-label">All Characters</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input type="checkbox" id="uppercase" class="form-check-input" checked>
                                    <label class="form-check-label">Uppercase</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="lowercase" class="form-check-input" checked>
                                    <label class="form-check-label">Lowercase</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="numbers" class="form-check-input" checked>
                                    <label class="form-check-label">Numbers</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="symbols" class="form-check-input">
                                    <label class="form-check-label">Symbols</label>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button class="btn btn-primary btn-custom" onclick="generatePassword()">Generate Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addScript')
<script>
    function generatePassword() {
        let length = document.getElementById('passwordLength').value;
        let easyToSay = document.getElementById('easyToSay').checked;
        let easyToRead = document.getElementById('easyToRead').checked;
        let includeUppercase = document.getElementById('uppercase').checked;
        let includeLowercase = document.getElementById('lowercase').checked;
        let includeNumbers = document.getElementById('numbers').checked;
        let includeSymbols = document.getElementById('symbols').checked;
        
        let uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        let numberChars = '0123456789';
        let symbolChars = '!@#$%^&*()_+[]{}|;:,.<>?';
        
        let chars = '';
        if (includeUppercase) chars += uppercaseChars;
        if (includeLowercase) chars += lowercaseChars;
        if (includeNumbers) chars += numberChars;
        if (includeSymbols) chars += symbolChars;
        
        if (easyToSay) chars = chars.replace(/[0oO1lI]/g, '');
        if (easyToRead) chars = chars.replace(/[B8G6I1l0OQDS5Z2]/g, '');
        
        if (chars.length === 0) {
            alert("Please select at least one character type");
            return;
        }
        
        let password = '';
        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('passwordOutput').value = password;
        document.getElementById('passwordLengthValue').innerText = length;
    }

    function copyPassword() {
        let passwordField = document.getElementById('passwordOutput');
        passwordField.select();
        document.execCommand('copy');
        document.getElementById('text_copied').innerText = "Password copied";
        setTimeout(() => {
            document.getElementById('text_copied').innerText = '';
        }, 2000);
    }

    // Ensure that selecting "All Characters" automatically checks other options
    document.getElementById('allCharacters').addEventListener('change', function () {
        let isChecked = this.checked;
        document.getElementById('uppercase').checked = isChecked;
        document.getElementById('lowercase').checked = isChecked;
        document.getElementById('numbers').checked = isChecked;
        document.getElementById('symbols').checked = isChecked;
        document.getElementById('numbers').disabled = false;
        document.getElementById('symbols').disabled = false;
    });

    document.getElementById('easyToSay').addEventListener('change', function () {
        let isChecked = this.checked;
        document.getElementById('uppercase').checked = isChecked;
        document.getElementById('lowercase').checked = isChecked;
        document.getElementById('numbers').checked = false;
        document.getElementById('symbols').checked = false;
        document.getElementById('numbers').disabled = true;
        document.getElementById('symbols').disabled = true;
    });

    document.getElementById('easyToRead').addEventListener('change', function () {
        let isChecked = this.checked;
        document.getElementById('uppercase').checked = isChecked;
        document.getElementById('lowercase').checked = isChecked;
        document.getElementById('numbers').disabled = false;
        document.getElementById('symbols').disabled = false;
    });
    
    window.onload = function() {
        document.getElementById('passwordLength').value = 8;
        generatePassword();
    };
</script>
@endpush

@push('addStyle')
<style>
    .passwordOutput {
        margin-bottom: 2rem;
    }
    .passwordOutputText {
        font-size: 2rem;
    }
    
</style>
@endpush