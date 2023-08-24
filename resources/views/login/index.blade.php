<!DOCTYPE html>
<html lang="en" data-bs-theme="white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('img/icone_enagro.png') }}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <title>Login - Enagro Admin</title>
    <style>

      .loginLogo {
        width: 50%;
      }

    </style>

</head>
<body>
    
      <div class="modal modal-sheet position-static d-block p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
          <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0 justify-content-center">
              <img src="{{ asset('img/logo_enagro.png') }}" class="loginLogo" alt="Logo">
            </div>
      
            <h1 class="p-5 pb-4">Faça o seu login</h1>
            <div class="modal-body p-5 pt-2">
              <form action="{{ route('login.logar') }}" method="POST">
                <div class="form-floating mb-3">
                    @method('POST')
                    @csrf
                  <input type="email" name="email" class="form-control mb-2 rounded-3" id="floatingInput" placeholder="name@example.com">
                  <label for="floatingInput">Endereço de Email</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="password" name="password" class="form-control mb-2 rounded-3" id="floatingPassword" placeholder="Password">
                  <label for="floatingPassword">Senha</label>
                </div>

                <button class="w-100 mb-2 btn btn-lg rounded-3 text-white" value="Entrar" style="background-color: #009632;" type="submit">Entrar</button>
                <p style="color: red; text-align: center;">{{$msg ?? ''}}</p><small class="text-body-secondary">© 2023 - Enagro Inc</small>           
              </form>
            </div>
          </div>
        </div>
      </div>


</body>
</html>