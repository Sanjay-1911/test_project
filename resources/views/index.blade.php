<!DOCTYPE html>
<html>
<head>
    <title>User Registration Form</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}">
    
</head>
<body>
    <div class="container">


        <h1>User Registration Form</h1>

@if (session('success'))
    <div class="success-message" style="color: black; background-color: yellow; text-align:center;">
        {{ session('success') }}
    </div>
@endif       
        <form action="{{route('user.store')}}"  method="post" id="userForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                @error('name')
                <div class="error-message">{{ $message }}</div>
               @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <div class="phone-input">
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10,12}" placeholder="Enter 10 to 12 digits Indian phone number" required>
                    <span class="phone-prefix">+91</span>
                    <img class="flag-icon" src="images/indian-tiranga.png" alt="Indian Tiranga Flag" name="profile_image">
                </div>
                <div class="error-message" id="phoneError"></div>
                @error('phone')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country" onchange="loadStates()" required>
                    <option value="">Select Country</option>

                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                     @endforeach
                </select>
            </div>
            @error('country')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-group">
        <label for="state">State:</label>
        <select id="state" name="state" onchange="loadCities()" required>
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->state }}</option>
            @endforeach
        </select>
        @error('state')
                <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <select id="city" name="city" required>
            <option value="">Select City</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->city }}</option>
            @endforeach
        </select>
        @error('city')
                <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                @error('profile_image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    
    <script src="scripts.js"></script>

    <script>
        function loadStates() {
            var countryId = document.getElementById("country").value;

            // Make an AJAX request to fetch states based on the selected country ID
            fetch(`/get-states?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    var stateSelect = document.getElementById("state");
                    stateSelect.innerHTML = "<option value=''>Select State</option>";

                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement("option");
                        option.value = data[i].id;
                        option.text = data[i].state;
                        stateSelect.appendChild(option);
                    }
                })
                .catch(error => console.error(error));
        }

        function loadCities() {
            var stateId = document.getElementById("state").value;

            // Make an AJAX request to fetch cities based on the selected state ID
            fetch(`/get-cities?state_id=${stateId}`)
                .then(response => response.json())
                .then(data => {
                    var citySelect = document.getElementById("city");
                    citySelect.innerHTML = "<option value=''>Select City</option>";

                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement("option");
                        option.value = data[i].id;
                        option.text = data[i].city;
                        citySelect.appendChild(option);
                    }
                })
                .catch(error => console.error(error));
        }
    </script>
    
</body>
</html>
