
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <style>
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            #se-pre-con {
                    position: fixed;
                    left: 0px;
                    top: 0px;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    background: url(/Preloader_2.gif) center no-repeat #fff;
            }
        </style>
    <script>
    
        
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
            @if(Auth::check())
                window.authUser={!! Auth::user() !!}
            @else
                window.authUser=false
             @endif
        })();
        </script>
                
    </head>
    <body>
        <div id="se-pre-con"></div>
        <div id="app"> 
            <z-dashboard></z-dashboard>
        </div>
        <script>
            window.addEventListener('load', function() {
                var s = document.getElementById('se-pre-con').style;
                s.opacity = 1;
                (function fade(){(s.opacity-=.1)<0?s.display="none":setTimeout(fade,40)})();
                    // $(".se-pre-con").fadeOut("slow");
                })
        
        </script>
    </body>
</html>
