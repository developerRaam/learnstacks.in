@extends('frontend.common.base')
@push('setTitle') Password Generator @endpush

@push('addTitle'){{ 'Home' }}@endpush
@push('addDescription'){{ app('settings')['site_description'] }}@endpush
@push('addKeywords'){{'tech blog, programming tutorials, web development tips, PHP tutorials, Laravel tutorials, coding best practices, tech job postings, AI tutorials, cybersecurity best practices'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-xl p-6">
            <h3 class="text-2xl font-semibold text-center mb-6">🔑 Password Generator</h3>

            <div class="mb-6">
                <p id="text_copied" class="text-green-600 text-sm"></p>
                <div class="flex gap-2">
                    <input type="text" id="passwordOutput" class="w-full px-4 py-2 border rounded-lg font-semibold text-gray-800 bg-gray-100" readonly>
                    <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium" onclick="copyPassword()">Copy</button>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-medium mb-4">Customize your password</h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Length: <span id="passwordLengthValue" class="font-semibold">8</span></label>
                        <input type="range" id="passwordLength" class="w-full" value="8" min="4" max="32" oninput="generatePassword()">
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input type="radio" id="easyToSay" name="passwordType" class="accent-indigo-500">
                            Easy to say
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" id="easyToRead" name="passwordType" class="accent-indigo-500">
                            Easy to read
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" id="allCharacters" name="passwordType" class="accent-indigo-500">
                            All Characters
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="uppercase" class="accent-indigo-500" checked>
                            Uppercase
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="lowercase" class="accent-indigo-500" checked>
                            Lowercase
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="numbers" class="accent-indigo-500" checked>
                            Numbers
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="symbols" class="accent-indigo-500">
                            Symbols
                        </label>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition" onclick="generatePassword()">Generate Password</button>
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