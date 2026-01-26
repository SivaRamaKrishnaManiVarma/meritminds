<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Documents</title>
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
        <h1>Documents</h1>
         <button class="register" type="submit"><a href="Main.html">Home</a></button>
        <div class="form-wrapper">
            <form action="">
               
                <div class="form-item">
                    <label for="fullname">SSC:</label>
                    <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Inter:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Graduation Cmm:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				 <div class="form-item">
                    <label for="fullname">Semester Trans:</label>
                    <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Provisional Certificate:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Original Degree:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				 <div class="form-item">
                    <label for="fullname">English Exam Score:</label>
                    <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">GRE / GMAT / SAT:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Passport:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				 <div class="form-item">
                    <label for="fullname">Resume:</label>
                    <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Letter Of Recommendations:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Experience Certificate:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				 <div class="form-item">
                    <label for="username">Medium Of Instruction:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				 <div class="form-item">
                    <label for="fullname">Bonafied Certificate:</label>
                    <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Course Comple Cert:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
                <div class="form-item">
                    <label for="username">Backlog Certificate:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
				
                
                 <div class="form-item">
                    <label for="username">Signed Declaration:</label>
                     <input type="file" name="file" accept=".pdf, .docx, .xlsx">
                </div>
           

              
               
              
               
                
            
              
               

                <button class="register" type="submit">Submit</button>
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