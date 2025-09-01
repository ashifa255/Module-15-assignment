[file name]: index.php
[file content begin]
<!-- PHP Function Starts -->
<?php

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

$allowedGenders = ["male", "female", "others"];
$allowedSkills = ["html", "css", "php", "js"];
$countries = ['Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cambodia', 'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Democratic Republic of the Congo', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, North', 'Korea, South', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Macedonia', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'];

// Initialize variables
$userName = $userEmail = $userPhone = $gender = $country = $pass = '';
$skills = [];
$errName = $errEmail = $errPhone = $errGender = $errSkills = $errCountry = $errPass = '';
$showData = '';

// Form Validation Starts
if(isset($_POST['signup'])){
    $userName = $_POST['userName'] ?? '';
    $userEmail = $_POST['userEmail'] ?? '';
    $userPhone = $_POST['userPhone'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $skills = $_POST['skills'] ?? [];
    $country = $_POST['country'] ?? ''; 
    $pass = $_POST['pass'] ?? '';

    // Name Validation Starts
    if(empty($userName)){
        $errName = "<span style='color: red'>Please Enter Your Name</span>";
    } elseif(!preg_match("/^[a-zA-Z.\-' ]*$/", $userName)){
        $errName = "<span style='color: red'>Only letters and white space allowed</span>";
    } elseif(strlen($userName) < 3){
        $errName = "<span style='color: red'>Name must be at least 3 characters</span>";
    } else {
        $crrName = sanitize($userName);  
    }

    // Email Validation Starts
    if(empty($userEmail)){
        $errEmail = "<span style='color: red'>Please Enter Your Email</span>";
    } elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        $errEmail = "<span style='color: red'>Invalid Email Format</span>";
    } else {
        $crrEmail = sanitize($userEmail);
    }

    // Phone Number Validation Starts
    if(!empty($userPhone) && !preg_match("/^[0-9+\-\s()]*$/", $userPhone)){
        $errPhone = "<span style='color: red'>Invalid phone number format</span>";
    } else {
        $crrPhone = sanitize($userPhone);
    }

    // Gender Validation Starts
    if(empty($gender)){
        $errGender = "<span style='color: red'>Please Select your Gender</span>";
    } elseif(!in_array($gender, $allowedGenders)){
        $errGender = "<span style='color: red'>Invalid Gender</span>";
    } else {
        $crrGender = sanitize($gender);
    }

    // Skills Validation Starts
    if(!empty($skills)){
        foreach($skills as $skill){
            if(!in_array($skill, $allowedSkills)){
                $errSkills = "<span style='color: red'>Invalid Skill</span>";
                break;
            }
        }
        if(empty($errSkills)){
            $crrSkills = array_map('sanitize', $skills);
        }
    }

    // Country Validation Starts
    if(empty($country)){
        $errCountry = "<span style='color: red'>Please Select Your Country</span>";
    } elseif(!in_array($country, $countries)){
        $errCountry = "<span style='color: red'>Invalid Country</span>";
    } else {
        $crrCountry = sanitize($country);     
    }

    // Password Validation Starts
    if(empty($pass)){
        $errPass = "<span style='color: red'>Please Enter Your Password</span>";
    } elseif(strlen($pass) < 8){
        $errPass = "<span style='color: red'>Password must be at least 8 characters</span>";
    } else {
        // Don't sanitize password - just hash it for security
        $crrPass = password_hash($pass, PASSWORD_DEFAULT);
    }

    // Data Show Starts
    if(empty($errName) && empty($errEmail) && empty($errPhone) && empty($errGender) && empty($errSkills) && empty($errCountry) && empty($errPass)){
        $skillsText = !empty($crrSkills) ? implode(', ', $crrSkills) : 'None selected';
        $phoneText = !empty($crrPhone) ? $crrPhone : 'Not provided';
        
        $showData = "
        <div style='background: white; padding: 20px; border-radius: 10px; margin-top: 20px; color: black;'>
            <h2>Registration Successful!</h2>
            <p><strong>Name:</strong> $crrName</p>
            <p><strong>Email:</strong> $crrEmail</p>
            <p><strong>Phone:</strong> $phoneText</p>
            <p><strong>Gender:</strong> $crrGender</p>
            <p><strong>Skills:</strong> $skillsText</p>
            <p><strong>Country:</strong> $crrCountry</p>
        </div>";
    }
}

?>

<!-- PHP Function Ends -->

<!-- CSS Code Starts -->
<style>
    body {
        margin: 0;
        padding: 20px;
        font-family: 'Times New Roman', Times, serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        text-align: left;
    }
    .form-container {
        width: 100%;
        max-width: 600px;
        padding: 30px;
        border: 1px solid #000000;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.9);
        color: #333;
    }
    h1 {
        color: #000;
        font-size: 28px;
        margin-bottom: 25px;
        text-align: center;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        text-align: left;
        font-size: 16px;
        color: #000;
    }
    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 12px;
        margin: 8px 0 16px 0;
        border-radius: 5px;
        border: 1px solid #000000;
        background-color: rgba(255, 255, 255, 0.8);
        color: #000;
        box-sizing: border-box;
    }
    input:focus,
    select:focus {
        outline: none;
        border: 1px solid #764ba2;
        box-shadow: 0 0 5px rgba(118, 75, 162, 0.5);
    }
    .form-group {
        margin-bottom: 15px;
    }
    .radio-group, .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 10px 0;
    }
    .radio-group label, .checkbox-group label {
        font-weight: normal;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: #fff;
        padding: 12px;
        margin: 20px 0;
        border-radius: 7px;
        border: none;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .btn:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }
    .error {
        color: red;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
        display: block;
    }
</style>
<!-- CSS Code Ends -->

<!-- Digital Form Starts -->
<div class="form-container">
    <h1>Registration Form</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="userName">Your Name:</label>
            <input type="text" placeholder="Your Name" name="userName" id="userName" value="<?= htmlspecialchars($userName) ?>">
            <?= $errName ?>
        </div>

        <div class="form-group">
            <label for="userEmail">Your Email:</label>
            <input type="text" placeholder="Your Email" name="userEmail" id="userEmail" value="<?= htmlspecialchars($userEmail) ?>">
            <?= $errEmail ?>
        </div>

        <div class="form-group">
            <label for="userPhone">Your Phone Number:</label>
            <input type="text" placeholder="Your Number" name="userPhone" id="userPhone" value="<?= htmlspecialchars($userPhone) ?>">
            <?= $errPhone ?>
        </div>

        <div class="form-group">
            <label>Gender:</label>
            <div class="radio-group">
                <label><input type="radio" value="male" name="gender" <?= $gender == "male" ? "checked" : "" ?>> Male</label>
                <label><input type="radio" value="female" name="gender" <?= $gender == "female" ? "checked" : "" ?>> Female</label>
                <label><input type="radio" value="others" name="gender" <?= $gender == "others" ? "checked" : "" ?>> Others</label>
            </div>
            <span class="error"><?= $errGender ?></span>
        </div>

        <div class="form-group">
            <label>Skills:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" value="html" name="skills[]" <?= in_array('html', $skills) ? "checked" : "" ?>> HTML</label>
                <label><input type="checkbox" value="css" name="skills[]" <?= in_array('css', $skills) ? "checked" : "" ?>> CSS</label>
                <label><input type="checkbox" value="php" name="skills[]" <?= in_array('php', $skills) ? "checked" : "" ?>> PHP</label>
                <label><input type="checkbox" value="js" name="skills[]" <?= in_array('js', $skills) ? "checked" : "" ?>> JS</label>
            </div>
            <span class="error"><?= $errSkills ?></span>
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <select name="country" id="country">
                <option value="">Select Country</option>
                <?php foreach($countries as $ctr): ?>
                    <option value="<?= $ctr ?>" <?= $country == $ctr ? "selected" : "" ?>><?= $ctr ?></option>
                <?php endforeach; ?>
            </select>
            <span class="error"><?= $errCountry ?></span>
        </div>

        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" placeholder="Your Password">
            <span class="error"><?= $errPass ?></span>
        </div>

        <button type="submit" class="btn" name="signup">Sign Up</button>
    </form>
    
    <?= $showData ?>
</div>
<!-- Digital Form Ends -->
[file content end]
