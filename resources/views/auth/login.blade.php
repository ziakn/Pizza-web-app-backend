<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Metas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="AJT">
    <!-- Links -->
    <link rel="icon" type="image/png" href="#">
    <!-- google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat&display=swap" rel="stylesheet">
    <!-- Plugins CSS -->
    <link href="{{ asset('design/css/plugin.css') }}" rel="stylesheet">
    <!-- style CSS -->
    <link href="{{ asset('design/css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('design/images/favicon.png') }}" type="image/png" />
    <!-- Document Title -->
    <title>Login </title>
<body>
    
    <!--Page Wrapper starts-->
    <div class="page-wrapper">

        <header class="header">
            <a href="" class="logo">Pizza  </a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
           
          
          </header>
       
       
       
        <div class="property-details-wrap bg-cb">
           
            <!--Listing Details Info starts-->
            <div class="single-property-details mt-60">
                <div class="container" style="padding-top: 40px;">
                    
                    <div class="row">
                           
                        <div class="col-xl-6 col-lg-6" style="margin-left: auto; margin-right: auto;">
                            <div id="list-sidebar" class="listing-sidebar">
                                <div class="widget filter-widget">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-sm-12 col-12 mb-3">
                                                <form action="{{ route('login') }}" method="POST" >
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 style="margin-bottom: 0px;">LOGIN</h3>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input class="form-control filter-input @error('email') is-invalid @enderror"  type="text" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus >
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input id="password" class="form-control filter-input @error('password') is-invalid @enderror" type="password"  name="password" required autocomplete="current-password" placeholder="Password"  >
                                                                @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                        </div>
                                                        <div class="col-md-12" style="padding-top:20px;">
                                                            <label class="checkbox-inline"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me</label>
                                                        </div>
                                                        <div class="col-md-12" style="padding-top: 20px;">
                                                        <button type="submit" class="btn v8" type="submit" >Login</button>
                                                        </div>
                                                        <!-- <div class="col-md-12" style="text-align: center; padding-top: 10px;">
                                                            <label>
                                                            @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}" >Forgot Password?</a>
                                                            @endif
                                                            </label>
                                                        </div> -->
                                                    </div>
        
                                                </form>
                                            </div>
                                        </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Listing Details Info ends-->
            
        </div>
    </div>
    <!--Page Wrapper ends-->
 
    <!--Footer ends-->
</body>

</html>