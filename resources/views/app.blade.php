@php
    $userName = explode(' ',$user->name)[0];
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="icon" href="{{ asset('img/icone_enagro.png') }}" type="image/x-icon">
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="/" class="nav_logo"> <i class='fa-solid fa-arrows-rotate fa-spin nav_logo-icon'></i><span
                        class="nav_logo-name"><img src="{{ asset('img/logo_enagro_white.png') }}" style="width: 30%"></span></a>
                <div class="nav_list">

                    <a id="usuarios" href="{{route('user.index')}}" class="nav_link"> <i class='fa fa-users nav_icon'></i>
                        <span class="nav_name">Usuários</span>
                    </a>

                    <a id="tipUsuarios" href="{{route('user_type.index')}}" class="nav_link"><i class="fas fa-user"></i>
                        <span class="nav_name">Tipos de Usuários</span> 
                    </a>
    

                    <a href="" class="nav_link @yield('relClass')"> <i class='fa-solid fa-paw nav_icon'></i>
                        <span class="nav_name">Animais</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-plus-medical nav_icon'></i>
                        <span class="nav_name">Planos de Saúde</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='fa-solid fa-lock nav_icon'></i>
                        <span class="nav_name">Seguros</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='fa-solid fa-briefcase nav_icon'></i>
                        <span class="nav_name">Serviços Avulsos</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='fa-solid fa-stethoscope nav_icon'></i>
                        <span class="nav_name">Veterinários</span> </a>

                    
                    <hr style="color: #fff">

                    <div class="nav_link d-flex" style="color: white"> 
                        <i class='fa fa-user-circle bx-sm nav_icon'></i>
                        <span>{{ $userName }}</span>           
                        <form action="{{ route('login.sair') }}">
                            <button class="btn btn-link ms-auto" type="submit">
                                <i class="logoutBtn bx bx-log-out bx-rotate-180 bx-sm"></i>
                            </button>
                        </form>
                    
                    </div>


                        {{-- <div class="cardLogin card d-flex flex-row align-items-center">
                            <i class="userIcon bx bx-user-circle bx-sm"></i>
                            <span>{{ $user->name }}</span>
                            <form action="{{ route('login.sair') }}">
                                <button class="btn btn-link ms-auto" type="submit">
                                    <i class="logoutBtn bx bx-log-out bx-rotate-180"></i>
                                </button>
                            </form> 
                        </div> --}}


                </div>

                

                

            </div>
        </nav>
    </div>
    <p class="error-message">@yield('error')</p>
    <div class="height-100 bg-light p-4">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        var menuAtivo = @yield('menuAtivo');
        menuAtivo.classList.add('active');
    </script>
</body>

</html>
