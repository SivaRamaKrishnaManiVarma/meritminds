<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversion</title>
    <style>
        html {
            background: rgba(233, 225, 225, 0.479);
        }
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            width: 75vw;
            background: #6fd5e659;
            padding: 25px;
        }
        
        .container h1 {
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(59, 55, 55);
            font-size: 25px;
            margin-bottom: 5px;
        }
        
        .container h2 {
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(59, 55, 55);
            font-size: 20px;
            margin-top: 5px;
        }
        
        .form-wrapper {
            margin: 15px;
            width: 100%;
        }
        
        .form {
            width: 90%;
        }
        
        #studentimage {
            height: 80px;
            width: 80px;
            border-radius: 5px;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(59, 55, 55);
        }
        
        p {
            font-family: Arial, Helvetica, sans-serif;
            color: Black;
            font-size: 14px;
        }
        
        .form-item {
            display: flex;
            margin: auto;
            align-items: center;
            width: 80%;
        }
        
        .form-item label {
            width: 250px;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }
        
        .form-item input {
            margin: 5px 15px;
            height: 22px;
            width: 100%;
            font-size: 13px;
            border: 1px black solid;
            border-radius: 5px;
        }
        
        .form-item select {
            margin: 5px 0px;
            width: max-content;
        }
        
        .genders {
            display: flex;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
            margin-left: 16px;
            font-size: 14px;
        }
        
        .genders input {
            width: 20px;
        }
        
        hr {
            margin-top: 15px;
            width: 80%;
        }
        
        h3 {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }
        .same-perm{
            display: flex;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            font-size: 13px;
            margin: 5px 105px;
        }
        
        .register {
            margin: 25px;
            background: #1e90ff;
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
            padding: 7px 20px;
            border-radius: 5px;
            color: #fbfbfb;
            border: 0;
            cursor: pointer;
        }
        
        .register:hover {
            color: #3a3636;
        }
        
        @media screen and (max-width: 640px) {
            .container {
                width: 90vw;
                padding: 10px 5px;
            }
            .form-item label {
                font-size: 14px;
            }
            .form-item input {
                margin: 5px 10px;
                font-size: 12px;
            }
            .genders {
                margin-left: 10px;
                font-size: 13px;
            }
            .genders input {
                width: 15px;
            }
            .same-perm{

            font-size: 13px;
            margin: 5px 50px;
        }
            .register {
                margin: 25px;
                font-size: 15px;
                padding: 7px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>NEW STUDENT ENQUIRY</h1>
        
		  <button class="register" type="submit"><a href="Main.html">Home</a></button>
        <div class="form-wrapper">
            <form action="">
               
                <div class="form-item">
                    <label for="fullname">Student Name:</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
                </div>
                <div class="form-item">
                    <label for="username">Father's Name:</label>
                    <input type="text" name="username" id="fathersname" placeholder="Father's Full Name" required>
                </div>
                <div class="form-item">
                    <label for="username">Mother's Name:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Mother's Full Name" required>
                </div>

                <div class="form-item">
                    <label for="gender">Gender:</label>
                    <div class="genders">
                        <p>Male</p> <input type="radio" name="gender" id="gender" value="male" required>
                        <p>Female</p> <input type="radio" name="gender" id="gender" value="female">
                        <p>Other</p> <input type="radio" name="gender" id="gender" value="other">
                    </div>
                </div>
                <div class="form-item">
                    <label for="email">Date of Birth</label>
                    <input type="date" name="DOB" id="DOB" required>
                </div>
				
				  <div class="form-item">
                    <label for="phonenumber">Tel/Mobile:</label>
                    <input type="tel" name="phonenumber" id="phonenumber" placeholder="XXX XXX XXXX" required>
                </div>
                <div class="form-item">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="email@xyz.com" required>
                </div>
                
           

              
                <hr>
             
				   <h3>Intake Interested</h3>
                <div class="same-perm">
                    <label for="sameaspermanent">Summer 2025</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                 <label for="sameaspermanent">Fall 2025 </label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Spring 2026</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Summer 2026</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Fall 2026</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
               
				</div>
              
               
                
                <hr>
                <h3>Country Interested</h3>
                <div class="same-perm">
                    <label for="sameaspermanent">Usa</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                 <label for="sameaspermanent">Uk </label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Ireland</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Australia</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">New land</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Canada</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                 <label for="sameaspermanent">Germany </label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Finland</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">France</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
                <label for="sameaspermanent">Sweeden</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
				<label for="sameaspermanent">Other</label> <input type="checkbox" name="sameaspermanent" id="sameaspermanent">
				</div>
              
                <div class="form-item">
                    <label for="username">Program Interested:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Program Interested" required>
                </div>
                 <div class="form-item">
                    <label for="department">Preferred Universities:</label>
                    <select name="department" id="department">
						 
                        <option value="electrical">Electrical Engineering</option>
                        <option value="electrical">Computer Engineering</option>
                        <option value="electrical">Software Engineering</option>
                        <option value="electrical">Civil Engineering</option>
						<option value="electrical">------Select------</option>
                    </select>
                </div>
				
				 <div class="form-item">
                    <label for="username">Preffered Locations:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Preffered Locations" required>
                </div>
				
				<div class="form-item">
                    <label for="gender">Tution Fee Budget:</label>
                    <div class="genders">
                        <p>10-15Lakhs</p> <input type="radio" name="gender" id="gender" value="10-15Lakhs" required>
                        <p>15-20Lakhs</p> <input type="radio" name="gender" id="gender" value="15-20Lakhs">
                        <p>20-25Lakhs</p> <input type="radio" name="gender" id="gender" value="20-25Lakhs">
						  <p>25-35Lakhs</p> <input type="radio" name="gender" id="gender" value="25-35Lakhs" >
                        <p>35-45Lakhs</p> <input type="radio" name="gender" id="gender" value="35-45Lakhs">
                        <p>50-70Lakhs</p> <input type="radio" name="gender" id="gender" value="50-70Lakhs">
						<p>75-100Lakhs</p> <input type="radio" name="gender" id="gender" value="75-100Lakhs">
                    </div>
                </div>
				<div class="form-item">
                    <label for="username">Qualification:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Qualification" required>
                </div>
				<div class="form-item">
                    <label for="username">Year of pass:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Year of pass" required>
                </div>
				<div class="form-item">
                    <label for="username">Percentage:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Percentage" required>
                </div>
				<div class="form-item">
                    <label for="username">Backlogs:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Backlogs" required>
                </div>
				<div class="form-item">
                    <label for="username">Inter English Marks:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Inter english marks" required>
                </div>
				<div class="form-item">
                    <label for="username">Inter Percentage:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Inter Percentage" required>
                </div>
					<div class="form-item">
                    <label for="username">Financial Ability:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Financial Ability" required>
                </div>
					<div class="form-item">
                    <label for="username">Previous Travel History:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Previous Travel History" required>
                </div>
					<div class="form-item">
                    <label for="username">Previous Visa Refusals:</label>
                    <input type="text" name="username" id="mothersname" placeholder="Previous Visa Refusals" required>
                </div>
                <button class="register" type="submit">Register</button>
            </form>
        </div>

    </div>
<script>
    let pstate = document.querySelector("#pstate")
    let pcity = document.querySelector("#pcity")
    let pzip = document.querySelector("#pzip")
    let pphonenumber = document.querySelector("#pphonenumber")

    let tstate = document.querySelector("#tstate")
    let tcity = document.querySelector("#tcity")
    let tzip = document.querySelector("#tzip")
    let tphonenumber = document.querySelector("#tphonenumber")

    let sameaspermanent = document.querySelector("#sameaspermanent")
    sameaspermanent.addEventListener('change', () => {
            if (sameaspermanent.checked === true) {
                tstate.value = pstate.value;
                tcity.value = pcity.value;
                tzip.value = pzip.value;
                tphonenumber.value = pphonenumber.value;
            } else if (sameaspermanent.checked === false) {
                tstate.value = "";
                tcity.value = "";
                tzip.value = "";
                tphonenumber.value = "";
            }
        })



</script>
</body>

</html>