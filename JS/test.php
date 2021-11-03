<!doctype html>
<html lang="en">

<head>
    <title>Test</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript" src="index.js"></script>

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <form action="#" onsubmit="submitted()">
            <div class="row">
                <div id="name_block">
                    <label for="name">Name</label><br>
                    <input type="text" name="name" id="name" class="col-5">
                </div>
                <div id="first_name_block">
                    <label for="first_name">First name</label><br>
                    <input type="text" name="first_name" id="first_name" class="col-5">
                </div>
            </div>
            <div class="row">
                <div id="email_block">
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" class="col-12">
                </div>
            </div>
            <div class="row">
                <div id="phone_block">
                    <label for="phone">Phone</label><br>
                    <input type="phone" name="phone" id="phone" class="col-5">
                </div>
                <div id="gender_block">
                    <label for="gender">Gender</label><br>
                    <select type="gender" name="gender" id="gender" class="col-5">
                        <option value="">---Choose a gender---</option>
                        <option value="male" name="male" id="male">Male</option>
                        <option value="female" name="female" id="female">Female</option>
                        <option value="other" name="other" id="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div id="city_block">
                    <label for="city">City</label><br>
                    <input type="text" name="city" id="city" class="col-5">
                </div>
                <div id="postal_code_block">
                    <label for="postal_code">Postal code</label><br>
                    <input type="text" name="postal_code" id="postal_code" class="col-5">
                </div>
            </div>
            <div class="row">
                <div id="birth_date_block">
                    <label for="birth_date">Birth date</label><br>
                    <input type="date" name="birth_date" id="birth_date" class="col-5">
                </div>
            </div>
            <input class="btn btn-info mt-3 col-12" type="submit" value="Send it"></input>
        </form>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

<script>
    myName = document.getElementsByName('name');
    myFirst_name = document.getElementsByName('first_name');
    myPassword = document.getElementsByName('password');
    myEmail = document.getElementsByName('email');
    myBirth_date = document.getElementsByName('birth_date');
    myCity = document.getElementsByName('city');
    myPostal_code = document.getElementsByName('postal_code');
    myPhone = document.getElementsByName('phone');
    myGender = document.getElementsByName('gender');

    addPeople(myName, myFirst_name, myPassword, myEmail, myBirth_date, myCity, myPostal_code, myPhone, myGender);
</script>

</html>