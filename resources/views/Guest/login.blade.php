@extends('Guest.layout')
@section('title', 'Login')

@section('content')
    
<body class="login-home">
  <div class="container-fluid">
    <br><br><br>
    <div class="row">
      <div class="col-md-1"></div>
      

      <div class="col-md-10">
        <div id="loginpagebox">
          {{-- <dv id="loginbox"> --}}

          <div class="row">
            <center>
              <br>
              <img src="{{asset ('images/WorkplaceIcon.png') }}" alt="Company Logo" style="  width: auto;" class="companyLogo">
            </center>
          </div>

          
            <form action="/logincheck" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-3 col-2"></div>
                <div class="col-md-6 col-8">
                  <br><br>
                  <label for="acctype"><b>Select Account Type:</b></label><br>
                  <input type="radio" id="student" name="acctype" value="student" required>
                  <label for="student">Student</label><br>
                  <input type="radio" id="company" name="acctype" value="company">
                  <label for="company">Company</label><br>
                  <br><br>
                </div>
                <div class="col-md-3 col-2"></div>
              </div>

              <div class="row">
                <div class="col-md-3 col-1"></div>
                <div class="col-md-6 col-10">
                  <label for="username"><b>Username:</b> </label><br />
                    <input type="text" id="loginusername" name="username" required/><br /><br />
                </div>
                <div class="col-md-3 col-1"></div>
              </div>

              <div class="row">
                <div class="col-md-3 col-1"></div>
                <div class="col-md-6 col-10">
                  <label for="password"><b>Password:</b></label><br />
                  <input type="password" id="loginpword" name="password" required /><br />
                  <input type="checkbox" onclick="showPass()" />Show Password
                  <br /><br /><br />
                </div>
                <div class="col-md-3 col-1"></div>
              </div>

              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <center>
                  <input type="submit" value="Login" id="loginsubBtn" /><br /><br />
                  <a href="/AccType"><input type="button" value="Create New Account" id="createNewAccBtn" /></a>
                </center>
                </div>
                <div class="col-md-4"></div>
              </div>
              
            </form>
              
          
        </div>
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>


      
         
          
          
        
      <script>
        function showPass() {
          var x = document.getElementById("loginpword");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
      </script>
    {{-- <x-flash-msg /> --}}

      
</body>

@endsection